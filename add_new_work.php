<?php
require 'authorinclude.php';

$myip_security=util::GetIP();
// will create a new record if IP matches
if ($_SERVER['REMOTE_ADDR'] === $myip_security )
{
	$result=json_decode(file_get_contents("options.json"), true);
	
	 //
   // Load schema (definition file that determines how to arrange values
   //
   $result_schema = json_decode(file_get_contents("schema.json"), true);
	
	$row = (string)count($result["works"]);
	//echo $row;
	// iterate th rough schema?
	//$result["works"][$row]["title"] =  "testERS";
	
	$columns_to_use="columns_works";
	$schema_works="schema_works";
	
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
			$result["works"][$row][$key2]=$key2;
				/* foreach($key2 as $key3=>$key4)
				{
				echo $key. '|'.$key4;
					$result["works"][$row][$key3]=$key3;
					// ignore groups
				} */
			}
		}
   }
	 file_put_contents('options.json', json_encode($result));
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else
{
	echo "invalid ip";
}
?>
