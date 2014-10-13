<?php
require 'authorinclude.php';

//echo $_POST["dog"];
$myip_security=util::GetIP();

//d ecide which JSON file we are editing.



$JSON_FILE = "options.json";
	$override_json =$_POST['override_json'];
	if ($override_json!="")
	{
		$JSON_FILE =$override_json;
	}


$record_id= $_POST["record_id"];

// can I iterate this automatically?
//$columns_to_use=$_POST["columns_works"];//"columns_works"; // Do not require this now because we pass all the data we require in POST from editor.php
//$schema_to_use=$_POST["schema_works"];//'schema_works'; // Do not require this now because we pass all the data we require in POST from editor.php
$work_type=$_POST["work_type"];//'works';
$work_row = $_POST["work_row"]; // Add a blank work row with the number indicated (i.e., 0 would create 0th entry)

//TODO: This should come from _POST eventually
//$groupToAdd=$_POST['grouptoadd']; //DO NOT UPLOAD YET THIS NOT TESTED OR SETUP
$groupToAdd="group1";

$groupFieldsToAdd=array();
$groupFieldsToAdd["linktype"]="amazon_link";
$groupFieldsToAdd["link"]="enter link";




// we want pure json to send to email. Next step creates the array object we require for other operations
$extra_message=file_get_contents($JSON_FILE);
$extra_message2="";
$result = json_decode($extra_message, true);

 //$emailaddy= $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][util::$BACKUP_EMAIL_ADDRESS];
 
 //mail( $emailaddy, 'Fiction Site Backup', "".$extra_message." ".$extra_message2);
 //echo $JSON_FILE;
 //echo "email=".$emailaddy;
 
 
 $keys_to_store = array();
 
 $array_of_tags_to_parse = explode(",", $_POST["tags_to_parse"]);
 $count=0;
 
 // index into keys_to_store must be a field value (i.e., TITLE)
 // index into POST needs to be the same
 
 foreach ($array_of_tags_to_parse as $ckey)
 {
	$keys_to_store[$ckey] = $_POST[$ckey];
	$count++;
 }
 
/*  foreach($result[$columns_to_use] as $ckey => $col_key)
   {
	
	 foreach ($result[$schema_to_use][$col_key] as $key => $value) {
		$keys_to_store[$key] = $_POST[$key];
   } */
 
/*  foreach ($columns as $col_key)
 {
	 foreach ($result['schema_works'][$col_key] as $key => $value) {
		$keys_to_store[$key] = $_POST[$key];
		
	} 
}*/
 
//$title=$_POST["title"];
//$blurb=$_POST["blurb"];

//echo $_SERVER['REMOTE_ADDR'];

if ($_SERVER['REMOTE_ADDR'] === $myip_security && is_numeric($record_id))
{


 foreach ($keys_to_store  as $key => $value) {
	$result[$work_type][$record_id][$key] = $value;
	if ($work_row >= 0)
	{
		foreach ($groupFieldsToAdd as $groupKey=>$groupKeyValue)
		{
			$result[$work_type][$record_id][$groupToAdd."_".$work_row."_".$groupKey] = $groupKeyValue;
		}
		//$result[$work_type][$record_id]["group1_".$work_row."_link"]="put link here";
	}
 }
 // now we need to modify the record
 //$result["works"][$record_id]["title"] =  $title;
 //$result["works"][$record_id]["blurb"] =  $blurb;
 
 file_put_contents($JSON_FILE, json_encode($result));
}
else
{
// wrong ip, can't update
}
?>
