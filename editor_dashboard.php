<html>

<?php
require 'authorinclude.php';

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


<?php
 $result = json_decode(file_get_contents("options.json"), true);
 $STYLE_SHEET = $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][util::$KEY_STYLE_SHEET];
if (!$STYLE_SHEET)
{
	exit ("ERROR: A style sheet needs to be defined in the provided schema for this page and it must exist in the directory. From the editor dashboard edit the look and feel and fill in the field index_style_sheet with the name of an appropriate file.");
	
}
if (!file_exists($STYLE_SHEET))
{
	exit ("ERROR: The style sheet [".$STYLE_SHEET."] does not exist. It needs to .");
}
require $STYLE_SHEET;
?>
<style>
/*Override the excerpt stuff*/
input[type=checkbox] + label{
font-size:0.6em;
color:white;
background-color:orange;
padding:5px;
}
input[type=checkbox] + label:after { content: " +"; }
input[type=checkbox]:checked + label:after { content: " -"; }
.nicelink a:link{
color:white;
}
.nicelink a:visited{
color:white;
}
body {
  padding-top: 20px;
  padding-bottom: 20px;
}

.navbar {
  margin-bottom: 20px;
}
body{
background-color: white;
font-size: 2em;
}
</style>
	</head>
	

  
  
  
  <body role="document>
 
  <div class="row">	
   
    
	     <div class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Main Dashboard</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li ><a href="editor.php?record=<?php echo util::$INDEX_SETTINGS_RECORD;?>&columns_to_use=columns_settings1&schema_to_use=schema_settings1">Look and Feel</a></li>
              <li><a href="editor.php?record=<?php echo util::$INDEX_SETTINGS_RECORD;?>&columns_to_use=columns_words&schema_to_use=schema_words&override_json=lang_english.json">Text</a></li>
		
              
			  <li><a href="index.php">Visit Site</a></li>
			 
			  <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Add <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="add_new_work.php">Add New Work</a></li>
				<li><a href="add_new_review.php">Add New Review</a></li>
              </ul>
            </li>
			 <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Advanced <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
               	   <li ><a href="editor.php?record=<?php echo util::$INDEX_SETTINGS_RECORD;?>&columns_to_use=columns_settings1&schema_to_use=schema_settings1&override_json=reviews.json">Review Look and Feel</a></li>
				    <li ><a href="editor.php?record=<?php echo util::$INDEX_SETTINGS_RECORD;?>&columns_to_use=columns_words&schema_to_use=schema_word&override_json=lang_english.json">Text Look and Feel</a></li>
				    <li><a href="backup.php">Backup Data</a></li>
              </ul>
            </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
	  
	   <div class="row">
        <div class="col-md-4">
       <div class="page-header">
        <h1>Works</h1>
       </div>

	  <?php
// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.

function myTruncate($string, $limit, $break=".", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}
	  
	 
	  
	
	/* 	  echo "<br/><br/><a href='add_new_work.php'>Add New Work</a>";
	  echo "<br/><br/><a href='editor.php?record=".util::$INDEX_SETTINGS_RECORD."&columns_to_use=columns_settings1&schema_to_use=schema_settings1'>Custom Index.php</a>";
	  
	  
	  echo "<br/><br/><a href='editor.php?record=".util::$INDEX_SETTINGS_RECORD."&columns_to_use=columns_words&schema_to_use=schema_words&override_json=lang_english.json'>Define Strings/Text</a>"; */
	
	
	  
  $works_label="works";
  $works_title="title";
  $showwork="showwork";
 
	$ListOfWorks = $result[$works_label];
	
	
	
 
 // sort will be more complicated than this --> add to an array with $value_minor as key? Sort on that?
	$results_array = array();
	  foreach ( $ListOfWorks as $key_minor => $value_minor)
	  {
		  $warning="";
		  $title = $result[$works_label][$key_minor][$works_title];
		  if ($title)
		  {
			 // echo "->".$result[$works_label][$key_minor][$showwork]."<-";
			  if ( $result[$works_label][$key_minor][$showwork] === "true")
			  {
			  }
			  else
			  {
				$warning="<span class='nicelink label label-warning'>Hidden</span>";
			  } 
			  $stage_label=$result[$works_label][$key_minor][util::$KEY_STAGE];
			  $stage_appearance_html_class=  $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][$stage_label];//'label label-primary';
			  $stage=sprintf("<span class='%s'>%s</span>",$stage_appearance_html_class, $stage_label );
			  
			  $work_id = $result[$works_label][$key_minor][util::$WORKID];
			  $comment_str = $result[$works_label][$key_minor][util::$KEY_COMMENT];
			  $comment_str_short = myTruncate($comment_str, 10);
			  $comment=sprintf('<span class="label label-info">%s</span>',$comment_str_short );
	/* 		 $collapsiblecomment = sprintf('<div class="faq">
			   <ul>
			   <li><a href="#%s">%s</a>   
			   <div id="%s">%s </div>
			   </li>  </ul>  
</div>',$key_minor,$comment,$key_minor,$comment_str); */
$collapsiblecomment = "";
   if ($comment_str && $comment_str != "" && $comment_str != "comment")
   {
   $collapsiblecomment = sprintf("<input type='checkbox' style='display: none' id=l%s>
<label for=l%s></label><div class='orangebox' style='color: white; font-size:0.7em;'>%s</div>",$key_minor,$key_minor,$comment_str);
  
 }
			  
			  // I put the ID = Title in here so that it would sort alphabetically.
				$results_array[$title] =  sprintf("<h3> <span class='nicelink label label-default'><a id='%s' href='editor.php?record=%s'>%s</a></span> %s %s %s</h3> ",$title,$key_minor,$title, $stage, $warning, $collapsiblecomment);
		  }
	  }
	sort($results_array, SORT_STRING);
		foreach ($results_array as $newkey=>$value)
		{
			echo $value;
		}
	  
	  echo "</div>";
	  echo '<div class="col-md-4">';
	  ?>
      <div class="page-header">
        <h1>Reviews</h1>
       </div>
	  <?php
	  Review::DrawListOfReviewsForEditing();
	  echo "</div>  </div>";
	  util::DrawFooterOnHTMLPage();
  ?>
   <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  
	  </body>
	  </html>
	 
