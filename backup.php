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

// array with filenames to be sent as attachment
$files = array("options.json","reviews.json","schema.json","lang_english.json");
 
// email fields: to, from, subject, and so on
$to = $emailaddy;
$from = $emailaddy;
$subject = sprintf('AuthorControlBackup for site: %s',$_SERVER[HTTP_HOST]); 
$message = sprintf("AuthorControl Backup: Please find %s attached backup files.",count($files));
$headers = "From: $from";
 
// boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 
// headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
// multipart boundary 
$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
$message .= "--{$mime_boundary}\n";
 
// preparing attachments

// preparing attachments
for($x=0;$x<count($files);$x++){
    $file = fopen($files[$x],"rb");
    $data = fread($file,filesize($files[$x]));
    fclose($file);
    $data = chunk_split(base64_encode($data));
    $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . 
    "Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" . 
    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
	
	
	
   // $message .= "--{$mime_boundary}\n";
	
 	if ($x=== (count($files)-1) ){
	$message .="–-{$mime_boundary}–-\n";
	}
	else{
	$message .="--{$mime_boundary}\n";
	} 
}
 //echo $message;
// send
 
$ok = @mail($to, $subject, $message, $headers); 
if ($ok) { 
    echo "<p>mail sent to $to!</p>"; 
} else { 
    echo "<p>mail could not be sent!</p>"; 
} 



	
	echo "<br/>";
	echo "<a href='editor_dashboard.php'>Back</a>";
?>

