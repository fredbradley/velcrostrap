<?php 
 /**
 * CMS Default Class
 * ***************
 * Author: Fred Bradley <hello@fredbradley.co.uk>
 * Project: CMS
 * Copyright: All Rights Resevered
 *
 * Description:  .
 *
 * Note:  
 */
	class CMS
	{
		var $num_queries      = 0;
		var $last_query       = null;
		var $last_error       = null;
		var $col_info         = null;
		var $captured_errors  = array();
		var $cache_dir        = false;
		var $cache_queries    = false;
		var $cache_inserts    = false;
		var $use_disk_cache   = false;
		var $cache_timeout    = 24; // hours
		var $timers           = array();
		var $total_query_time = 0;
		var $db_connect_time  = 0;
		var $trace_log        = array();
		var $use_trace_log    = false;
		var $sql_log_file     = false;
		var $do_profile       = false;
		var $profile_times    = array();

	/**********************************************************************
	*  Functions */

	function __construct() {
		$connection = mysql_connect(DBHOST, DBUSER, DBPASS)
            or die("Could not connect to the database:<br />" . mysql_error());
        mysql_select_db(DBNAME, $connection) 
            or die("Database error:<br />" . mysql_error());

	}
	function logged_in() {
		if (!empty($_SESSION['username'])) {
			return true;
		} else {
			return false;
		}
	}
	function refresh() {
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}

	function saveOAuthDetails($user_info, $access_token) {
		$query = mysql_query("SELECT * FROM ".DBPREFIX."users WHERE oauth_provider = 'twitter' AND oauth_uid = ". $user_info->id);  
		$result = mysql_fetch_array($query);
    
		// If not, let's add it to the database  
		if(empty($result)){  
			$query = mysql_query("INSERT INTO ".DBPREFIX."users (oauth_provider, oauth_uid, username, oauth_token, oauth_secret) VALUES ('twitter', {$user_info->id}, '{$user_info->screen_name}', '{$access_token['oauth_token']}', '{$access_token['oauth_token_secret']}')");  
			$query = mysql_query("SELECT * FROM ".DBPREFIX."users WHERE id = " . mysql_insert_id());  
			$result = mysql_fetch_array($query);  
		} else {  
			// Update the tokens  
			$query = mysql_query("UPDATE ".DBPREFIX."users SET oauth_token = '{$access_token['oauth_token']}', oauth_secret = '{$access_token['oauth_token_secret']}' WHERE oauth_provider = 'twitter' AND oauth_uid = {$user_info->id}");  
		}
		$_SESSION['id'] = $result['id']; 
		$_SESSION['username'] = $result['username']; 
		$_SESSION['oauth_uid'] = $result['oauth_uid']; 
		$_SESSION['oauth_provider'] = $result['oauth_provider']; 
		$_SESSION['oauth_token'] = $result['oauth_token']; 
		$_SESSION['oauth_secret'] = $result['oauth_secret']; 
		
	}
	function saveGuess($guess, $user_id) {
		mysql_query("INSERT INTO ".DBPREFIX."guesses (`guess`, `user_id`, `time`) VALUES ('$guess', '$user_id', '".time()."')");
		$user = $this->getUser($user_id);
		if (!empty($user->oauth_secret) && $user->oauth_provider == "twitter") {
			$message = "@".$user->username." thanks for guessing with the name, ".$guess."! Get your friends to Guess The Royal Baby's name!";
			if (strlen($message) > 118) {
				$message = substr($message, 0, 115);
				$message = $message."...";
			}
			$link = " http://www.thisismywebsite-isntgreat.com/thanks";
			$this->updateTwitter($message.$link);
		}
	}
	function getSettings() {
		$configs = "SELECT * FROM ".DBPREFIX."site_configs";
		$result = mysql_query($configs);
		while($r = mysql_fetch_object($result)) {
			$output[] = $r;
		}
	return $output;
	}

	function get_mysql_array($result) {
		return mysql_fetch_array($result);
	}
	function getUsers() {
	global $db;
		$users = $db->get_results("SELECT * FROM users");
		return $users;
	}
	function getUser($id) {
		$query = "SELECT * FROM ".DBPREFIX."users WHERE id='".$id."'";
		$user = $this->get_results($query);
		$user = $user[0];
		return $user;
	}
	function getTable($thetable) {
	global $db;
		$table = $db->get_results("SELECT * FROM ".$thetable);
		return $table;
	}
	function get_results($query) {
		$result = mysql_query($query);
		while($r = mysql_fetch_object($result)) {
			$output[] = $r;
		}
		return $output;
	}
	function updateUser() {
	global $db;
		$query = "UPDATE users SET ";
	foreach ($_POST as $key => $value) {
		$each .= $key."='".$value."', ";	
	}
		$each = substr($each, 0, -2);  // substr takes the last 2 characters off (the last comma and space)
		$query = $query.$each." WHERE user_id=".$_POST['user_id'];
		$update = $db->query($query);
	}
	function countUsers() {
		$query = "SELECT * FROM users";
		$result = mysql_query($query);
		return mysql_num_rows($result);
	}
	function addUser() {
	global $db, $mail;
		if ($_POST['password'] != $_POST['passwordconfirm']) {
			return "Error: Passwords do not match";
		} else {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$email = $_POST['email'];
			$firstname = $_POST['first_name'];
			$surname = $_POST['surname'];
			$verifycode = 'verify-'.$username.'-'.md5($email).'-'.md5($firstname).'-talentcow';
			$query = "INSERT INTO users (username, password, email, first_name, surname, verifycode) VALUES ('$username', '$password', '$email', '$firstname', '$surname', '$verifycode')";
			$result = $db->query($query);	
			if ($result==false)
				$db->debug();
		
			$body = $this->verifyUserEmail($verifycode);
			$mail->SetFrom('moo@talentcow.com', 'The Cow Shed');
			$mail->AddAddress($email, $firstname." ".$surname);
			$mail->Subject = "Please Verify your Talent Cow Account";
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->MsgHTML($body);
			if(!$mail->Send()) {
			  return "Mailer Error: " . $mail->ErrorInfo;
			} else {
			  return "Message sent!";
			}
		}
	}
	
	function verifyUserEmail($code) {
		$body = '<body>
<style type="text/css">
<!--
body {
   background-color: #ffffff;
   margin: 0;
   padding: 0;
}
a {
	color:#333333;
	text-decoration:none;
}
a:hover {
	color:#333333;
	text-decoration:underline;
}
img {
	border: none;
	}

h1 {
	color:black;
	font-weight: bold;
	font-size: 30px;

	}
-->
</style>
<table width="100%" border="0" align="center" cellpadding="20" cellspacing="0" bgcolor="#ffffff" style="background-repeat:repeat-x">
  <tr>
    <td valign="top">
      
      
      <table width="650" border="0" align="center" cellpadding="10" cellspacing="0" bgcolor="#ffffff">
        <tr>
          <td valign="top">
            
                       <!-- START OF Header Table -->
            <table width="633" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="67" width="350"  align="left" valign="middle" bgcolor="#FFFFFF" style="color: #e3e3e3; font-family: Helvetica, sans-serif; font-size: 12px; letter-spacing: 
0px;"><h1>Please Verify your Talent Cow Account</h1></td>
                </tr>
              <tr>
                <td height="19" colspan="2" align="left" bgcolor="#FFFFFF" style="font-family: Arial, Helvetica, sans-serif; color: #7a7a7a; font-size: 12px; letter-spacing: -1px;"><img 
src="http://www.talentcow.com/img/full_width_hr.jpg" width="633" height="20" alt="break1" /></td>
              </tr>
              <tr>
               
                <td width="386" align="right" valign="top" bgcolor="#FFFFFF" style="color: #7a7a7a; font-family: Helvetica, sans-serif; font-size: 12px; letter-spacing: 0px;"><span 
style="text-align: right"></span>
                  
                  <table width="300" border="0" align="right" cellpadding="0" cellspacing="0" style="color: #7a7a7a; font-family: Helvetica, sans-serif; font-size: 12px; letter-spacing: 0px; 
text-align: right;">
                    
                  </table>
                  
                </td>
              </tr>
            </table>
            <!-- END OF Header Table -->
                        
            <!-- START OF full width Table 1 --> 
                    
		<table width="633" border="0" cellspacing="0" cellpadding="0">
  			<tr>
    			<td colspan="2" height="20">&nbsp;</td>
  			</tr>
  			<tr>
    <td width="210" align="left" valign="top"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #7a7a7a; line-height: 18px;"><img 
src="http://www.talentcow.com/img/milk.png" width="200" height="500" alt="pic1" /></span></td>
    <td width="423" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #7a7a7a; line-height: 18px;"><span style="font-family: Arial, Helvetica, 
sans-serif; font-size: 18px; color: #33333c; line-height: 18px;">Subject: Please Verify your Account</span>
    
    <br /><br />
    
      <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #7a7a7a; line-height: 20px;">Please click the link below to verify your account.</span>';
      $body .= '
<p><a href="http://dev.talentcow.com/verify?code='.$code.'">http://dev.talentcow.com/verify?code='.$code.'</a></p>
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #373737; line-height: 18px;">Kind Regards</span>
<br />
<br />
<!--<img src="http://www.talentcow.com/img/sig.png">-->
<br />
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #373737; line-height: 18px;">Fred Bradley
</span>
<br />
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #373737; line-height: 18px;">the web dude - talentcow limited</span>
</td>
  </tr>
</table>
                     <!-- START OF FOOTER TABLE --> 
            <table width="633" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="47" colspan="2" align="right" valign="top" style="color: #7a7a7a; font-family: Helvetica, sans-serif; font-size: 12px; letter-spacing: 0px;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="right" valign="top" style="color: #7a7a7a; font-family: Helvetica, sans-serif; font-size: 12px; letter-spacing: 0px;">
                  
                  <table width="300" border="0" cellspacing="0" cellpadding="0" style="color: #7a7a7a; font-family: Helvetica, sans-serif; font-size: 12px; letter-spacing: 0px;">
                  </table>
                  
                </td>
              </tr>
              <tr>
                <td height="10" colspan="2" valign="top"><img src="http://www.talentcow.com/img/three_quarter_HR.gif" width="633" height="20" alt="hr1" /></td>
              </tr>
              <tr>
                <td width="401" align="left" valign="top" style="font-family: Helvetica, sans-serif; font-size: 11px; color: #7a7a7a; line-height: 16px;"><p>Copyright &copy; 2012 talentcow 
limited. All Rights Reserved.<br />
                  for more details e: <a href="mailto:moo@talentcom.com">moo@talentcow.com</a></p>
                  
                </td>
              </tr>
            </table>
            <!-- END OF FOOTER TABLE --> 
            
            
          </td>
        </tr>
      </table>
      
    &nbsp;</td>
  </tr>
</table>

</body>';

	return $body;
		
	}
	function sendMail() {
	global $mail;
		$body             = file_get_contents('../emails/sql_backup.html');
		$body             = eregi_replace("[\]",'',$body);

		$mail->AddReplyTo("hello@fredbradley.co.uk","Fred Bradley");
	
		$mail->SetFrom('moo@talentcow.com', 'The Cow Shed');
	
		$mail->AddReplyTo("moo@talentcow.com","The Cow Shed");
	
		$mail->AddAddress("hello@fredbradley.co.uk", "Fred Bradley");
		$mail->AddAddress("luckythirteen@mac.com", "Neil Bentley");
	
		$mail->Subject    = "Database Backup: ".$backupfile;
	
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	
		$mail->MsgHTML($body);
	
		$mail->AddAttachment($backupfile);
	
		if(!$mail->Send()) {
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		  echo "Message sent!";
		}
	}
	function updateTwitter($message, $consumerKey=CONSUMER_KEY, $consumerSecret=CONSUMER_SECRET, $oAuthToken=SITE_OAUTH_TOKEN, $oAuthSecret=SITE_OAUTH_SECRET){

        // create a new instance
        $connection = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

        //send a tweet
        $connection->post('statuses/update', array('status' => $message));
	}

}

?>
