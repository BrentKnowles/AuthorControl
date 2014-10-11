<?php
require 'authorinclude.php';

$myip_security=util::GetIP();
if ($_SERVER['REMOTE_ADDR'] != $myip_security)
{
	die("Unauthorized user");
}
$JSON_FILE = "options.json";
$JSON_FILE2 = Review::$REVIEW_FILE;


$optionFile = file_get_contents($JSON_FILE);
$result = json_decode($optionFile, true);
$emailaddy = $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][util::$BACKUP_EMAIL_ADDRESS];
if ($emailaddy==="")
{
	die("Invalid email");
}

//define the receiver of the email 
$to =$emailaddy; 
//define the subject of the email 
$subject = sprintf('AuthorControlBackup for site: %s',$_SERVER[HTTP_HOST]); 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash 
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$headers = sprintf("From: %s\r\nReply-To: %s", $emailaddy, $emailaddy); 
//add boundary string and mime type specification 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
//$attachment = chunk_split(base64_encode(file_get_contents('options.json'))); 
$attachment = file_get_contents($JSON_FILE); 
$attachment2 = file_get_contents($JSON_FILE2); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

AuthorControl Backup
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>AuthorControl Backup</h2> 
<p>Please find 4 attached backup files.</p> 

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" ; name="options.txt"  
Content-Transfer-Encoding: 7bit 
Content-Disposition: attachment  

<?php echo $attachment; ?>
 --PHP-mixed-<?php echo $random_hash; ?>-- 
 
 --PHP-alt-<?php echo $random_hash; ?>-- 
 --PHP-mixed-<?php echo $random_hash; ?>  
 Content-Type: text/plain; charset="iso-8859-1" ; name="reviews.txt"  
Content-Transfer-Encoding: 7bit 
Content-Disposition: attachment  

<?php echo $attachment2; ?>
 
--PHP-mixed-<?php echo $random_hash; ?>-- 



<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed"; 

	echo "Done";
	echo "<br/>";
	echo "<a href='editor_dashboard.php'>Back</a>";
?>


<?php
/*$myip_security=util::GetIP();
$JSON_FILE = "options.json";
$JSON_FILE2 = Review::$REVIEW_FILE;

if ($_SERVER['REMOTE_ADDR'] === $myip_security)
{
	$extra_message=file_get_contents($JSON_FILE);
	$extra_message2=file_get_contents($JSON_FILE2);
	
	$result = json_decode($extra_message, true);

	$emailaddy= $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][util::$BACKUP_EMAIL_ADDRESS];
	 mail( $emailaddy, 'Fiction Site Backup', "".$extra_message." ||| ".$extra_message2);
	echo "Done";
	echo "<br/>";
	echo "<a href='editor_dashboard.php'>Back</a>";
}
*/
?>
