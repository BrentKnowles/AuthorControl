  <?php
  if (file_exists('./css/bootstrap-theme.css'))
{
}
else
{
	echo "<span class='error'>Bootstrap is required for the dashboard to look nice. Expecting to find bootstrap-theme.css and related files in /css/ subdirectory. Page may not appear correctly.</span><br/><br/><br/>";
}
  ?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
	
	<title>Author Edit Panel</title>
	 
	 <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="./css/bootstrap-theme.min.css" rel="stylesheet">
	   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>
	

  
  <?php
	require 'authorinclude.php';
	
	$JSON_FILE = "options.json";
	$override_json =$_GET['override_json'];
	$SKIP_LANGUAGE = 0;
	if ($override_json!="")
	{
		$JSON_FILE =$override_json;
		//
		// We want to suppress automatic translation when we are using the editor itself for translation
		//
		$SKIP_LANGUAGE = 1;
	}
   //
   // Load data file
   //
   $result = json_decode(file_get_contents($JSON_FILE), true);
   //
   // Load schema (definition file that determines how to arrange values
   //
   $result_schema = json_decode(file_get_contents("schema.json"), true);
  //
  // default values -- page will edit a Single Work (i.e., a Story or Novel)
  //
  $columns_to_use=util::$KEY_COLUMNS_FOR_WORKSCREATED; //"columns_works";
  $schema_to_use=util::$KEY_SCHEMA_FOR_WORKSCREATED;
  $work_type=util::$KEY_FOR_WORKSCREATED;
 
//
// GENERATE LANGUAGE ARRAY for string LOOKUP
// 
 $LANGUAGE_TO_USE = "lang_english.json";
 $lang_file = json_decode(file_get_contents($LANGUAGE_TO_USE), true);
 $LANGUAGE=null;
 if($lang_file)
 {
	foreach($lang_file[util::$KEY_FOR_WORKSCREATED] as $mykey)
	{
		$LANGUAGE = $mykey;
		break;
	}
 }
 else
 {
	echo "No strings are defined in the language file. Click the 'Text' link from editor_dashboard.php";
 }
  //
  // User may override the schema to use the editor for other types
  //  but BOTH the schema and the display columns to put that schema's fields must be valid
  //
  if ($_GET['columns_to_use'] && $_GET['schema_to_use'] )
  {
	
	//
	// these values must also be present in the options file before set to them
	//
	if ( $result_schema[$_GET['columns_to_use']] && $result_schema[$_GET['schema_to_use']])
	{
		
		 $columns_to_use = htmlspecialchars($_GET['columns_to_use']);
		 $schema_to_use= htmlspecialchars($_GET['schema_to_use']);
	 }
  }
  
  
  
 
  
  //
  // Default record value is 0. Overridden by an url parameters called 'record', i.e., http://fiction.brentknowles.com/editor.php?record=5
  //
  $record = 0;
  if (is_numeric($_GET['record']))
  {
	$record = $_GET['record'];
  }
  $array_of_things_to_save =array();
  ?>

 <body role="document">
 
  
 
    <div class="page-header">
     <h2>Product Editor</h2>
	   <div id="saveok" class="alert alert-success" role="alert">
        <strong>Updated!</strong> Your edits have been saved.
      </div>  
	  <div id="saveneeded" class="alert alert-warning" role="alert">
        <strong>Edits Not Saved!</strong> Remember to Press "SAVE"
      </div>  
	  <button type="button" id="sendbutton" onclick="update_work();" class="btn btn-md btn-primary">SAVE</button>
	    <a href="editor_dashboard.php">Dashboard</a>
      </div>

	<div class="row">	
	  

   
	
   <?php 
   
   function DrawInputObject($rowvalue, $value_minor, $key, $overridevalue)
   {
     global $result;
	 global $result_schema;
   global $record;
   global $array_of_things_to_save ;
   global $schema_to_use;
   global $work_type;
   
   
   $buildID=$key.'_control';
   
				if ($value_minor === "label")
				{
					// don't do anything special. Just a label
				}
				else
				if ($value_minor === "string")
				{
					$fieldvalue=$result[$work_type][$record][$key];
					if ($overridevalue != "")
					{
						$fieldvalue=$overridevalue;
					}
					$rowvalue= '<input onchange="editsMade();" type="text" size="35" id="'.$buildID.'" value="'.$fieldvalue.'"><br>';
				}
				else
				if ($value_minor ==="textarea")
				{
					$rowvalue= '<textarea onchange="editsMade();" cols="40" rows="5" id="'.$buildID.'"  >'.$result[$work_type][$record][$key].'</textarea>';
				}
				else
				if ($value_minor==="integer")
				{
					$rowvalue= '<input onchange="editsMade();" type="number" step="1" id="'.$buildID.'" value="'.$result[$work_type][$record][$key].'"><br>';
				}
				else
				if ($value_minor==="range")
				{
					$rowvalue= '<input onchange="editsMade();" type="range" min="0" max="100" step="1" id="'.$buildID.'" value="'.$result[$work_type][$record][$key].'"><br>';
				}
				
				
				/* else
				if (strpos($value_minor,'array') !== false) {
					// if there is an array type we look for it
					if ($result[$value_minor])
					{
						// grab the array custom type definition 
						// iterate throuhg "publishedat"
						$count=0;
						foreach ($result[$work_type][$record][$key] as $published_item)
						{
								// now iterate through the "schema types"
								foreach ($result[$value_minor] as $array_type=>$array_value)
								{
									$overridevalue = $published_item[$array_type];
								
									//echo $array_value['type'];
									$rowvalue = $rowvalue.DrawInputObject($rowvalue, $array_value['type'], $count.$array_type, $overridevalue);
								//	echo 'b'.$published_item[$array_type];
								}
								$rowvalue = $rowvalue."<br/>";
						$count++;		
						}
						
					}
				} */
				else
				{
					// we did not find a defined element
					// try load as a enum
					
							//( As part of the change to use a comma-delim list we don't do this test anymore
							//if ($result[$value_minor])
					
					//
					//
					// retrieve the string list from record -1
					//
					$stringlist = $result[$work_type][util::$INDEX_SETTINGS_RECORD][$value_minor];
					$ListOfCommaEnum =  explode(",",$stringlist);
					if ($ListOfCommaEnum)
					{
						$option="";
						
						
						foreach ($ListOfCommaEnum as $item)
						{
						$selected="";
							$currentSelectedOption = $result[$work_type][$record][$key];
							if ($currentSelectedOption===$item)
							{
								$selected="selected='selected'";
								
							}
							$option=$option.'<option value="'.$item.'" '.$selected.'>'.$item.'</option>';
						}
						$rowvalue ='<select onchange="editsMade();" id="'.$buildID.'">'.$option.'</select>';
					}
					
						/* // This was the original way. It iterates through an area. I'm going to tweak this to use a comma-delim list
						// to make editing of said list easier
					
						$option="";
						// need to keep the stored option because most lists work like this. Will have to change preorder
						foreach ($result[$value_minor] as $item)
						{
						$selected="";
							$currentSelectedOption = $result[$work_type][$record][$key];
							if ($currentSelectedOption===$item)
							{
								$selected="selected='selected'";
								
							}
							$option=$option.'<option value="'.$item.'" '.$selected.'>'.$item.'</option>';
						}
						$rowvalue ='<select onchange="editsMade();" id="'.$buildID.'">'.$option.'</select>'; */
					
				}
		return $rowvalue;		
   }
   
   
    $group1 = 0;
	$MaxGroupValueReached=-1;
   function DoColumnDetails($column)
   {
	   global $result;
	   global $MaxGroupValueReached;
	   global $result_schema;
	   global $record;
	   global $array_of_things_to_save ;
	   global $schema_to_use;
	   global $work_type;
	   global $group1;
	   $RunAgain = 0; // when building groups this times the app to look for another entry
	   
	   $schema_array = $result_schema[$schema_to_use][$column];
			
			
			/* // we test for the presence of GROUPS
			// and if so add them to the array so they are picked up
			if ($result[$work_type][$record]["groupA0_linktype"])
			{
				array_push($schema_array,$result[$schema_to_use]["array_publishedat"]["linktype"]);
			}
				if ($result[$work_type][$record]["groupA0_link"])
			{
				array_push($schema_array,$result[$schema_to_use]["array_publishedat"]["link"]);
			}
			 */
			
				
			foreach ($schema_array as $key => $value) {
			//echo $key . $value;
			
			
			$rowvalue="";
			$helpvalue="";
			
				
			// now we are in the subarray -- the elements within key="title" for example
			
			//
			// we store an array of keys like "title" that is later used when we send information to update_work.php.
			//
			//$array_of_things_to_save = array();
			
			$override_value="";
		
			
			foreach ($value as $key_minor => $value_minor)
			{
			
					
				// LIMIT: Only allowed one GROUP So Far
				// $group1 is a variable (index starts at 0) that counts how many LINKS we've added.
				if ($key_minor=="isgroup") 
				{
						if ($value_minor=="group1")
						{
							
							// Now we get complicated because we have more than one of these.
							$override_value_key=$value_minor."_".$group1."_".$key;
							//echo $override_value_key;
							$override_value = $result[$work_type][$record][$override_value_key];
							if (!$result[$work_type][$record][$override_value_key])
							{
							
								//
								// A control did NOT exist 
								// AND
								// there has been no valid entries at this Nth item (where n = $group1)
								if ($group1 > $MaxGroupValueReached)
								{
									// at the point when we hit a dead entry we just BAIL entirely.
									// The group has ended and columns are only suppose to have one group in them.
									// THere we are done ELSE infinite loop
									
									// 14/09/2014
									// This ended up working BUT because previous data
									// did not have the NEW FIELD, it added it to the end of the entire set
									// and consequently I could not use it
									
									//  13/09/2014
									//  Just verified that we DO still need this.
									//  We are effectively building a list "group1[0] ... group1[infinity]... we use
									//  the "does it exist" test to prevent us from growing exponentially.
									
									// THE PROBLEM
									//  The problem with this is when I went to add a new field ... each link requiring an ISBN
									//  I cannot go back and fix the old entries, which means as soon as it tries to find 
									//  an ISBN and can't... it does not render the rest of the elements.
									
									// POSSIBLE SOLUTION
									//   We test to see if an element of N was found and if so
									//   we skip the Existence Test.
									//   That is if a linktype exists for N=9 then we know there is a 9th ROW, even if
									//   the NewField does not exist in it.
									//   IMPLEMENTATION: Just keep track of the Highest N we encounter. If this elements is
									//      on the Nth Row[if we have this info] then it gets a pass, even if it does not exist
									
									//echo "Reached Last In Series with max group = ".$group1. " and max group = ".$MaxGroupValueReached;
									return;
								}
							}
							else
							{
								// we track what record # we "found".
								// if we find a control in a set (i.e., set N=1) then 
								// even if another label (a new field added after the original dataset created) is added
								// we still display it.
								$MaxGroupValueReached = $group1;
							}
						//echo "Max Group Reached = ".$group1;
						// now try to "iterate" through all of them and write them all now.
						
						//echo "-->".$override_value;
						
						$key=$override_value_key; // we set this so that the control is named this. If the control is named this then things should save!
						}
						else
						if ($value_minor=="groupend")
						{
							// test to see if the next value exists?
							$group1++;
							//$override_value_key=$value_minor."_".$group1."_".$key;
							//echo "here1 ".$override_value_key;
							//if ($result[$work_type][$record][$override_value_key])
							{
							//echo "here2";	
							
							// we have to just run again and look and hope error handling handles errors?
								$RunAgain = 1;
							}
							// try to write an ID 
							echo "<h3><hr></hr></h3>";
						}	

							/* MY LOGIC
							 -- somehow I want to run through the entire... COLUMN? again
							 -- would that work? If I made a RULE that only one thing can be in a column?
							*/
				}
				
				if ($key_minor =="type") 
				{
					$rowvalue = DrawInputObject($rowvalue, $value_minor, $key,$override_value);
					

				}
				else if ($key_minor =="help")
				{
					$helpvalue=$value_minor;
				}
			} // foreach 1
			// I moved the push array to the end so that if the key is modified (as it is for groups) the change is reflecte
			if ($key != "group1end")
			{
					array_push($array_of_things_to_save, $key);
				
				
				echo '<div class="panel panel-default"><div class="panel panel-success"><div class="panel-heading">';
				
				echo '<h3>';
				$label = Lookup($key);
				echo '<span class="label label-primary">'.$label.'</span>';
				echo '</h3>';
				if ($helpvalue!="")
				{
					echo '<h4><span class="label label-warning">'.$helpvalue.'</span></h4>';	
				}
				
				echo ' </div></div> <div id="panelz" class="panel-body">';
				echo $rowvalue;
				echo '</div></div>';
			}
		}//foreach2
		
		if ($RunAgain == 1)
		{
			DoColumnDetails($column);
		}
	}
	//
	// Looks up for $id in the Translation file (i.e., lang_english.json)
	// and returns value OTHERWISE returns original $id
	//
	function Lookup($id)
	{
		global $LANGUAGE;
		global $SKIP_LANGUAGE;
		//
		// If we are translating strings (i.e., using the editor to adjust the labels themselves)
		// we do not want to show the translation, we want to use the 'key'
		//
		if ($SKIP_LANGUAGE === 1) return $id;
		if ($LANGUAGE[$id])
		{
			return $LANGUAGE[$id];
		}
		return $id;
		
	}
   function WriteColumn($column)
   {
	   global $result;
	   global $result_schema;
	   global $record;
	   global $array_of_things_to_save ;
	   global $schema_to_use;
	   global $work_type;
	   global $group1;
	   
	  if ($result_schema[$schema_to_use][$column])
	  {
	    echo '<div class="col-sm-4" id="'.$column.'">';
		DoColumnDetails($column);
		//if ($group1 > 0)
		
		if ($result_schema[$schema_to_use][util::$KEY_DO_WE_SHOW_ADD_LINK_BUTTON] == $column)
		//if ($column ==="col3")
		{
					echo '<button  class="btn btn-md btn-primary" onclick="addnewwork();" type="button">Add new Link</button>';
					
		}
		
		//
		// We add an Add Schema button if editing the Look and Feel or Text json files
		//
		if ($record == -1)
		{
			//echo '<button  class="btn btn-md btn-primary"  onclick="location.href=\'add_schema_field.php\'" type="button">Add Schema Field</button>';

			$typesasstring= $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][util::$TYPESOFFIELDS];
			if (!$typesasstring)
			{
			// ensure a default field appears
				$typesasstring = "string";
			}
			 $types = explode(",", $typesasstring);


			
echo '<form action="add_schema_field.php" method="post">';
 echo sprintf('<input type="hidden" name="schema_to_use" value="%s">', $schema_to_use);
echo sprintf('<input type="hidden" name="columntoaddto" value="%s">',$column);


echo 'New Field Name: <input type="text"  name="nameoffield"><br>';
echo 'Field Help: <input type="text" name="helpstringforfield"><br>';
//Type (next)
echo "<label>Field Type:</label>";
echo "<select name='fieldtype'>";
foreach ($types as $type)
{
	echo sprintf('<option value="%s">%s</option>',trim($type),trim($type));
}
echo "/<select><br/>";

echo '<input class="btn btn-md btn-primary" value="Add New Field" type="submit">';
echo '</form>';
			
		}
		
		echo '</div>';
		} // column definition must exist
   }
   
  
   
   // write out the individual fields.
   // * COLUMN 1
   foreach($result_schema[$columns_to_use] as $key => $value)
   {
	WriteColumn($value);
   }
   //WriteColumn('col1');
   //WriteColumn('col2');
   
  /*   foreach ($array_of_things_to_save as $field_to_save)
 {
 echo $field_to_save . "<br/>";
 } */
   ?>
 
    <script>
	

function update_work(reloadit)
{

// set published at to have all the array stuff that is needed
// TODO: this has to be dynamically generated
//$('#publishedat_control').val('monkeys');

//alert('first');
/*UPDATE LOGIC
 - we pass only the changed record and its ID#
 - the php file will load and modify the JSON
 */
 <?php
 
 // not using this function yet but it might be helpful to wrap things
function writephpvariables_jquerylookup($newvariable, $field_to_save)
{
	echo "var ".$newvariable." = $('#".$field_to_save."_control').val();\n";
}	
 
 $param_to_pass="";


 sort($array_of_things_to_save);
 foreach ($array_of_things_to_save as $field_to_save)
 {
	$newvariable="new_".$field_to_save;
	echo "var ".$newvariable." = $('#".$field_to_save."_control').val();\n";
	if ($param_to_pass != "")
	{
		$param_to_pass = $param_to_pass .  ",";
	}
	$param_to_pass=$param_to_pass . $field_to_save.":".$newvariable;
 }
 
 //echo var param_to_pass
 ?>
 //var new_title = $('#title_control').val();
 //var new_blurb = $('#blurb_control').val();
 <?php echo "var v_columns_work = '" .$columns_to_use."';"; ?>
 <?php echo "var v_schemas_work = '" .$schema_to_use."';"; ?>
 <?php echo "var v_work_work = '" .$work_type."';"; ?>
 <?php echo "var new_override_json = '" .$JSON_FILE."';"; ?>
 
 
 <?php 
 $new_result = "";
 foreach ($array_of_things_to_save as $item)
 {
	if ($new_result != "")
	{
		$new_result = $new_result.",";
	}
	$new_result = $new_result.$item;
 }
 echo "var new_tags_to_parse = '".$new_result."';"; ?>
 //alert(new_group1_0_link);
MyHash = "none";
	$.post( "update_work.php",{tags_to_parse:new_tags_to_parse,hash:MyHash,record_id:<?php echo $record;?>,<?php echo $param_to_pass;?>, 
			columns_works:v_columns_work,
			schema_works:v_schemas_work,
			work_type:v_work_work,
			work_row:new_work_row,
			override_json:new_override_json} ,function(data) {
	ShowSaveOk();
	if (reloadit == 1) location.reload();
	});
}
var new_work_row = -1;
function addnewwork()
{
	//$("#col3").append("<div>hello world</div>");
	new_work_row = <?php echo $group1;?>;
//	alert("saving");
	
	// now save it
	update_work(1);
	// now do reload
	
}
function HideEdits()
{
$('#saveneeded').hide();
}
function HideSaveOk()
{
$('#saveok').hide();
}
function ShowEdits()
{
	HideSaveOk();
	$('#saveneeded').show();
}
function ShowSaveOk()
{
$('#saveok').show();
HideEdits();
}
function editsMade()
{
	ShowEdits();
}
</script>   
	
	
	
	</div>
  

    
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
<script>
jQuery(function($){
HideSaveOk();
HideEdits();
});
</script>   
<?php
util::DrawFooterOnHTMLPage();
?>
  </body>
</html>
