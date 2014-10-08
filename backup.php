<?php
require 'authorinclude.php';

$myip_security=util::GetIP();
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

?>
