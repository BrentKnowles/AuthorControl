<?php
require 'authorinclude.php';

$filetouse="schema.json";

$schema_section=$_POST['schema_to_use'];//"schema_settings1";
$scheme_column=$_POST["columntoaddto"];//"col2";

$schema_field_name=$_POST["nameoffield"];//"done";
$schema_field_type=$_POST["fieldtype"];//"string";
$schema_field_help=$_POST["helpstringforfield"];//"for adjusting appearance of status/state boxes on dashboard";


/* echo $schema_section."<br></br>";
echo $scheme_column."<br></br>";
echo $schema_field_name."<br></br>";
echo $schema_field_type."<br></br>";
echo $schema_field_help."<br></br>"; */

//die("EARLY EXIT");
// when invoked will add a new field to the appropriate column
// "backup_email_address":{"type":"string","help":"Specify the email address to send backup files to. Backups can be invoked from dashboard"}
$myip_security=util::GetIP();
// will create a new record if IP matches
if ($_SERVER['REMOTE_ADDR'] === $myip_security )
{
	// we open the file
	$result=json_decode(file_get_contents($filetouse), true);
	
	if ($result[$schema_section][$scheme_column])
	{
		
		$result[$schema_section][$scheme_column][$schema_field_name][util::$TYPE] = $schema_field_type;
		$result[$schema_section][$scheme_column][$schema_field_name][util::$HELP] = $schema_field_help;
		
		
		
		// we add the new field
		
		// we save
		file_put_contents($filetouse, json_encode($result));
	}
	
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else
{
	echo "invalid ip";
}

?>
