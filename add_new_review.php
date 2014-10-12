<?php
require 'authorinclude.php';

$myip_security=util::GetIP();
// will create a new record if IP matches
if ($_SERVER['REMOTE_ADDR'] === $myip_security )
{
	$result=json_decode(file_get_contents(Review::$REVIEW_FILE), true);
	$columns_to_use=Review::$REVIEW_COLUMNS;
//	echo $columns_to_use;
	
	$schema_works=Review::$REVIEW_SCHEMA;
	 //
   // Load schema (definition file that determines how to arrange values
   //
   $result_schema = json_decode(file_get_contents("schema.json"), true);
	
	$row = (string)count($result[util::$KEY_FOR_WORKSCREATED]);
	//echo $row;
	// iterate th rough schema?
	//$result["works"][$row]["title"] =  "testERS";
	
	
	
	foreach($result_schema[$columns_to_use] as $key => $value)
   {
		// iterate all columns
		foreach($result_schema[$schema_works][$value] as $key2=>$keyz)
		{
			//echo $key2."-".$keyz;
			if ($result_schema[$schema_works][$value][$key2]["isgroup"])
			{
			
			}
			else
			{
			//echo "Add = " . $key2;
			$result[util::$KEY_FOR_WORKSCREATED][$row][$key2]=$key2;
				/* foreach($key2 as $key3=>$key4)
				{
				echo $key. '|'.$key4;
					$result["works"][$row][$key3]=$key3;
					// ignore groups
				} */
			}
		}
   }
	 file_put_contents(Review::$REVIEW_FILE, json_encode($result));
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else
{
	echo "invalid ip";
}
?>
