<html>
  <head>
<!-- Custom styles for this template -->
    
	
<link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>  
<link rel="stylesheet" href="./css/inlinepopup.css"> 
<link rel="stylesheet" href="./css/font-awesome.css">
<link href="carousel.css" rel="stylesheet">
<?php
require 'authorinclude.php';

if (file_exists('./css/bootstrap-theme.css'))
{
}
else
{
	echo "<span class='error'>Bootstrap is required for the dashboard to look nice. Expecting to find bootstrap-theme.css and related files in /css/ subdirectory. Page may not appear correctly.</span><br/><br/><br/>";
}


if (file_exists('./images/'))
{
}
else
{
	echo "<span class='error'>An /images directory is expected.</span><br/><br/><br/>";
}
if (file_exists('./css/inlinepopup.css'))
{
}
else
{
	echo "<span class='error'>Expecting to find inlinepopup.css in /css/ subdirectory. Page may not appear correctly.</span><br/><br/><br/>";
}
if (file_exists('./css/font-awesome.css'))
{
}
else
{
	echo "<span class='error'>Expecting to find font-awesome.css in /css/ subdirectory. Page may not appear correctly.</span><br/><br/><br/>";
}
if (file_exists('./fonts/FontAwesome.otf'))
{
}
else
{
	echo "<span class='error'>Expecting to find FontAwesome.otf in the /fonts/ subdirectory. Font-awesome fonts must be installed.</span><br/><br/><br/>";
}

$url=util::curPageURL();

$novels=array();
/*constants*/
$allfiction = "allfiction";
$all="all";
//cartegory
$nonfiction="nonfiction";
$NOVEL_CONSTANT="novel";
$collection="collection";

// genre
$scifi="scifi";
$fantasy="fantasy";

$preorder_out=0;
$preorder_on=1;
$preorder_off=2;




//
///////////////////
//
$LANGUAGE_FILE_TO_LOAD="lang_english.json";
$CONTENT_FILE_TO_LOAD="options.json";
//////////////////



	$LANGUAGE_TO_USE = $LANGUAGE_FILE_TO_LOAD;
 //
 // Load data file
 //
 $result = json_decode(file_get_contents($CONTENT_FILE_TO_LOAD), true);

 $lang_file = json_decode(file_get_contents($LANGUAGE_TO_USE), true);
//
// * CONSTANTS
//
$SCHEMA_TITLE1="";
$SCHEMA_TITLE2="";
$SCHEMA_TITLE2="";
$AUTHOR="";
$PUBLISHER="";
$CATEGORIES= null;
$CATEGORIES2 = null; // novel, stories, non-fiction
$STYLE_SHEET = "";
$image_height="";//150px;
$image_width="";//100px;
$BLOG_URL="";
$SHOW_ANY_OPTION="";
$FACEBOOK_CODE="";
$GPLUS_CODE="";
$TWITTER_NAME="";
$FOOTER_ABOVE="";
$FOOTER_BELOW="";
$DEFAULT_CATEGORY="";
$SCHEMEORG_SCHEMA="";
$SHOW_REVIEWS=util::$FALSE;
	//
	// All setting information is stored in a record = -1
	// The first record in the list
	//
	if ($result)
	{
		foreach($result[util::$KEY_FOR_WORKSCREATED] as $key)
		{
			$AUTHOR=$key[util::$KEY_LOOKS_AUTHOR];
			$PUBLISHER=$key[util::$KEY_LOOKS_PUBLISHER];
			$CATEGORIES = $key[util::$KEY_CATEGORIES];
			$CATEGORIES2 = $key[util::$KEY_CATEGORIES2];
			$STYLE_SHEET = $key[util::$KEY_STYLE_SHEET];
			
			$image_height = $key[util::$IMAGE_HEIGHT]."px";
			$image_width = $key[util::$IMAGE_WIDTH]."px";
			$BLOG_URL	=	$key[util::$BLOG_LINK];
			$SHOW_ANY_OPTION=$key[util::$SHOW_ANY_OPTION];
			
			$FACEBOOK_CODE=$key[util::$FACEBOOK_CODE];
			$GPLUS_CODE=$key[util::$GPLUS_CODE];
			$TWITTER_NAME=$key[util::$TWITTER_NAME];
			$FOOTER_ABOVE=$key[util::$FOOTER_ABOVE];
			$FOOTER_BELOW=$key[util::$FOOTER_BELOW];
			$DEFAULT_CATEGORY=$key[util::$DEFAULT_CATEGORY];
			$SCHEMEORG_SCHEMA=$key[util::$SCHEMEORG_SCHEMA];
			$SHOW_REVIEWS=$key[util::$SHOW_REVIEWS];
			
		break;
		}
	}
if (!$STYLE_SHEET)
{
	exit ("ERROR: A style sheet needs to be defined in the provided schema for this page and it must exist in the directory. From the editor dashboard edit the look and feel and fill in the field index_style_sheet with the name of an appropriate file.");
	
}
if (!file_exists($STYLE_SHEET))
{
	exit ("ERROR: The style sheet [".$STYLE_SHEET."] does not exist. It needs to .");
}
require $STYLE_SHEET;
	//
	// now parse STRINGS from the language file
	//
	$LANGUAGE=null;
	foreach($lang_file[util::$KEY_FOR_WORKSCREATED] as $key)
	{
		$LANGUAGE = $key;
		$SCHEMA_TITLE1=$key[util::$KEY_LOOKS_PAGETITLE];
		$SCHEMA_TITLE2=$key[util::$KEY_LOOKS_PAGETITLE2];
		$SCHEMA_TITLE3=$key[util::$KEY_LOOKS_PAGETITLE3];
	
	break;
	}

// * -- Get Parameters
$category=htmlspecialchars($_GET["cat"]);
$workid=-1;
if (is_numeric(htmlspecialchars($_GET["workid"])))
{
	$workid=htmlspecialchars($_GET["workid"]);
	
}

if ($category==="")
{
	$category=$DEFAULT_CATEGORY;//$allfiction;
}	

//echo $result['category1'][0];

//echo "boop ".var_dump($result);


// *SETUP CATEGORY1 categories
//foreach ($result['category1'] as $key => $value) {
//    echo "Key: $key; Value: $value<br />\n";
//}
/*Key: scifi; Value: Science Fiction<br />
Key: horror; Value: Horror<br />
Key: fantasy; Value: Fantasy<br />
*/


$arrcount=-1;
foreach ($result['works'] as $valu){
	$arrcount++;
	array_push($novels, Novel::AddNovelFromArray($valu, $arrcount));
}

function cmp($a, $b)
{
    if ($a->priority == $b->priority) {
        return 0;
    }
    return ($a->priority < $b->priority) ? -1 : 1;
}
usort($novels,"cmp");


 
/*foreach ($result['works'][work1] as $key => $value) {
    echo "Key: $key; Value: $value<br />\n";
	} */
/*HELP FILE

Categories - Special
(define what any special keywords trigger)

*/
?>


   
    
   <meta charset=utf-8 />
  <meta name="viewport" content="width=device-width">
  <meta name="description" content= <?php echo $LANGUAGE[util::$PAGE_DESCRIPTION];?>/>
    <title><?php echo $LANGUAGE[util::$HIDDEN_TITLE];?></title>
    
    

    
  </head>

  <body  > 
 
  
  <section class="centerelement innerbackground">
    <article class="topbox">

		  <aside class="border1 ChalkBox chalk">
		  <div class="specialoffer">
			<p class="neon"><?php echo $LANGUAGE[util::$SPECIAL_OFFER_TITLE];?></p>
			<?php echo $LANGUAGE[util::$KEY_OFFER];?>
			<br/>
			</div>
			<div class="specialoffer">
			<p class="neon"><?php echo $LANGUAGE[util::$PROGRESS_TITLE];?></p>
			<?php
				// iterate through all records looking for SHOWPROGRESS = true
				// if true then LIST the name
				foreach ($novels as $novel)
				{
					if ($novel->showprogress==util::$TRUE)
					{
						
						//<br/>
						echo sprintf('<progress max="100" value=%s></progress><span class="progresslabel"> ', $novel->progress);
						
						if ($result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][$novel->stage."_behavior"] === util::$BEHAVIOR_DONE)
						//if ($novel->stage === util::$DONE)
						{
							// we display a hyperlink instead.
							echo sprintf('%s  <br/> [<a href="%s"  class="nicelink">%s</a>]',$novel->title, $novel->publishedat[$novel->progress_link], $LANGUAGE[util::$NOW_AVAILABLE]);
							
						}
						else
						{
							echo sprintf('%s',$novel->title);
						}
						echo sprintf(" %s<br/></span>", $LANGUAGE[$novel->stage.util::$STRING]);
					}
				}
			?>
	
			</div>
			
 	  </aside>
			  <div class="titleandsubdiv">
  <a class="nicelink title gold letterpress" href="<?php echo util::curPageURL();?>"><?php echo $SCHEMA_TITLE1;?> </a><br/>
  <a class="nicelink title gold letterpress" href="<?php echo util::curPageURL();?>"><?php echo $SCHEMA_TITLE2;?></a>
  <p class="subtitle letterpress"><?php echo $SCHEMA_TITLE3;?></p>
  </div>

  
  </article>
  
  <nav class="">
  
  <div class="floatrightlinks">
  <a class="nicelink" href="<?php echo $BLOG_URL;?>"><?php echo $LANGUAGE[util::$BLOG_LINK_LABEL];?></a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  
  <?php 
  function BuildListFromArray($thearray)
  {
	global $LANGUAGE;
	  if ($thearray)
	   {
		   foreach ($thearray as $key ){
			$value = $key;
			 
			   
			  // NOW LOOK UP $value into LANGUAGE JSON to see what word we should use.
			  if ($LANGUAGE[$key])
			  {
				//
				// i.e., scifi becomes Science Fiction
				//
				$value = $LANGUAGE[$key];
			  }
			  //
			  // if we defined a blank string
			  // that means we do not want to show this option
			  //
			  if ($value === util::$SKIP_ENTRY)
			  {
			  }
			  else
			  {
				if ($count > 0) echo "|";
				WriteMenuLink($key, $value);
			  }
			  $count++;
			  //echo "Key: $key; Value: $value<br />\n";
			}
		}
  }
  $count=0;
   //foreach ($result['category1'] as $key => $value) {
   // 16/09/2014 - read categories from USER-DEFINED data instead.
   $CATEGORIES_ARRAY = explode(',',$CATEGORIES);
   BuildListFromArray($CATEGORIES_ARRAY);
   
 ?> 
  &nbsp;&nbsp;
  
    <?php 
	
	
   $CATEGORIES_ARRAY = explode(',',$CATEGORIES2);
   BuildListFromArray($CATEGORIES_ARRAY);
	
  /* $count=0;
   foreach ($result['category2'] as $key => $value) {
   if ($count > 0) echo "|";
  WriteMenuLink($key, $value);
  $count++;
}   */
/*   <?php WriteMenuLink($allfiction, "Novels");  //allfiction;fiction ?>
  |<?php WriteMenuLink("story", "Stories");  //allfiction;fiction ?>
  |<?php WriteMenuLink($nonfiction, "Non-Fiction");?>
 */  
 ?> 
 

  
  &nbsp;&nbsp;
  <?php if ($SHOW_ANY_OPTION!="") WriteMenuLink($all, $SHOW_ANY_OPTION);?>
  </div>
  </nav>
  <section class="data">


  
  <?php

function WriteMenuLink($clicked_category, $label)
{
global $category;
$isselected=""; 
//echo $clicked_category."->".$category."]]]";
if ($clicked_category===$category)
{
$isselected=" select";
}
 
 
 echo '<a class="nicelink'.$isselected.'" href="'.$url.'?cat='.$clicked_category.'">'.$label.'</a>';
 }
 



$buy_button_image_height='25px';
$buy_button_image_width='100px';

// creates a nicely formatted link
function AddLink($the_link,$button_image_class, $alt, $button_image,$isbn)
{
	global $buy_button_image_height;
	global $buy_button_image_width;
	
	$isbn_details ="";
	if ($isbn !=""){
		$isbn_details= '<meta itemprop="isbn" content="'.$isbn.'">';
	}
	
	echo $isbn_details. "<a itemprop='url' class='nicelink' title='".$alt."' href=".$the_link."><img class='".$button_image_class."' alt='".$alt."' src='/images/".$button_image."' height=".$buy_button_image_height." width=".$buy_button_image_width."</img></a>";
}



foreach ($novels as $val)
{
//echo "Type = ".$val->type."<br/>";

	$allowedtoshow = 0;

	if ($val->showwork==="true")
	{
	
		if ($workid > -1)
		{
			if ($workid === $val->workid)
			{
				$allowedtoshow = 1;
			}
		}
		else
		if ($category===$all ||  ($category===$allfiction && ($val->type===$NOVEL_CONSTANT || $val->type===$collection)) || $val->category===$category ||$val->type==$category)
		{
			$allowedtoshow = 1;
		}
	}
	
	if ($allowedtoshow === 1)
	{
		
		echo "<article class='border1 bookbox'>";
		//
		// Start schema code
		//
		echo '<div itemscope itemtype="'.$SCHEMEORG_SCHEMA.'">';
		echo '<div itemprop="name">';
		///////////////////////////////////////////////////////////
		
		$titleToUse = $val->title;
		if ($val->workid > 0)
		{
			// we have a workID which means it makes sense to have a "clickable" page all about us
			$titleToUse = sprintf("<a href='index.php?workid=%s'>%s</a>",$val->workid, $val->title);
		}
		
		echo "<H2 class='booktitle'>".$titleToUse."</H2>";
		echo '</div>';
		
		if ($val->image != "")
		{
		echo "<img class='bookimage' height=".$image_height." width=".$image_width." src='/images/".$val->image."' alt='".$val->image_alt."' title='".$val->image_alt."'></img>";
		}
		else
		{
		echo "<i class='bookimage fa fa-spinner fa-spin fa-5x'></i>";
		}
		echo '<div itemprop="description">';
		
		if ($val->excerpt && $val->excerpt !== "excerpt")
		{
			$collapsiblecomment = sprintf('<div class="faq">
			   <ul>
			   <li>
			   <a href="#%s">%s</a>   
			   <div id="%s" class="orangebox"><br/><b>%s</b><br/>%s </div>
			   </li>  </ul>  
</div>',$val->position,"Excerpt",$val->position,$titleToUse,$val->excerpt);
echo $collapsiblecomment;
		}
		
		echo $val->blurb;
		
		
		echo '</div>';
		
	/* 	if ($val->amazon_link != "")
		{
		
	//	"?tag=brenknow-20
		
		//echo "<img class='kindlebuttonimage' src='kindlelogo1.jpg' height=33 width=125</img>";
			echo "<a class='nicelink' href=".$val->amazon_link."?tag=brenknow-20><img class='kindlebuttonimage' alt='BUY NOW AT AMAZON.COM' src='/kindlelogo1.jpg' height=33 width=125</img></a><br/>";
		}
		
		if ($val->print_link != "")
		{
		
		echo "<a class='nicelink' href=".$val->print_link."?tag=brenknow-20><img class='kindlebuttonimage' alt='BUY PRINT NOW AT AMAZON.COM' src='/images/kindleprint.jpg' height=33 width=125</img></a><br/>";
		}
		if ($val->web_link != "")
		{
			echo "<a class='nicelink' href=".$val->web_link."0><img class='kindlebuttonimage' alt='Free read on the web' src='/images/web.jpg' height=33 width=125</img></a><br/>";
		} */
		
		// New Array Links (remove above code once this works)
		if (is_null($val->publishedat))
		{
		}
		else
		{
		
		
		$key = "";
				$link="";
				
				//
				// we grab a default value in case the links don't have overrides
				//
				$isbn=$val->isbn;
				
				
			 //parse links
			 echo "<br/>";
			foreach($val->publishedat as $Highkey => $masterlink)
			{
				
				
				if (strpos($Highkey,'linktype') !== false) {
					$key=$masterlink;
				}
				else
			//	 Had problems with adding this AND realized that we really only need an ISBN PER WORK
				if (strpos($Highkey,'isbn') !== false) {
					//$isbn=$masterlink;
					// skip ISBN because we will look it up directly
					//break; 
					//echo $Highkey;
				} 
				else
				if (strpos($Highkey,'link') !== false && $Highkey != "link_for_progress") {
					$link=$masterlink;
				}
				
				
				/* foreach ($masterlink as $minorkey => $minorlink)
				{
					// linktype first entry
					// link second
					if ($minorkey == "linktype")
					{
						$key=$minorlink;
					}
					else
					if ($minorkey=="link")
					{
						$link=$minorlink;
					}
					
				} */
				if ($key != "" && $link != "" )
				{
				
					
					
					$image_lookup = $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][$key];
					$alt_text_message = "Click to visit site and preview work.";
					
					//
					// TODO Remove Hack
					//
					if ($key==="amazon_link" || $key==="print_link")
					{
						$link = $link."?tag=brenknow-20";
					}
					// grab the ISBN directly
					// search from the END of the string (for the second _)
					$pos = strrpos ($Highkey, "_");
					if ($pos === false)
					{
					}
					else
					{
						// we know we have found an underscore so this is a valid
						// group identified (yes, a big assumption TODO)
						$tag_start = substr($Highkey,0,$pos);
					}
					
					
					
					$tag_end="_linkisbn";
					//'group1_0_linkisbn'
					$full_tag = $tag_start.$tag_end;
					//echo $full_tag;
					$new_isbn="";
					if ($val->publishedat[$full_tag])
					{
					
						$new_isbn=$val->publishedat[$full_tag];
					}
					if ($new_isbn != "")
					{
						$isbn=$new_isbn;
					}
					AddLink($link,'kindlebuttonimage', $alt_text_message, $image_lookup, $isbn);
				$key = "";
				$link="";
				
					/* if ($key==="amazon_link")
					{
					/* echo "<a class='nicelink' href=".$link."?tag=brenknow-20><img class='kindlebuttonimage' alt='BUY NOW AT AMAZON.COM' src='/kindlelogo1.jpg' height=33 width=125</img></a><br/>"; 
					AddLink($link,'kindlebuttonimage', 'BUY NOW AT AMAZON.COM', "kindlelogo1.jpg");
					}
					else
					if ($key==="print_link")
					{
					/* echo "<a class='nicelink' href=".$link."?tag=brenknow-20><img class='kindlebuttonimage' alt='BUY PRINT NOW AT AMAZON.COM' src='/images/kindleprint.jpg' height=33 width=125</img></a><br/>"; 
					
					AddLink($link,'kindlebuttonimage', 'BUY PRINT NOW AT AMAZON.COM', "kindleprint.jpg");
					}
					else
					if ($key==="web_link")
					{
						/* echo "<a class='nicelink' href=".$link."><img class='kindlebuttonimage' alt='Free read on the web' src='/images/web.jpg' height=33 width=125</img></a><br/>"; 
						AddLink($link,'kindlebuttonimage', 'Free read on the web', "web.jpg");
					}
					else
					if ($key==="kobo_link")
					{
						/*
						echo "<a class='nicelink' href=".$link."><img class='kindlebuttonimage' alt='Read on your Kobo!' src='/images/kobo.jpg' height=33 width=125</img></a><br/>";
						
						
						// make a function
						AddLink($link,'kindlebuttonimage', 'Read on your Kobo', "kobo.jpg");
					} 
					else
					if ($key==="direct_link")
					{
						AddLink($link,'kindlebuttonimage', 'Buy directly from the author', "direct.jpg");
					} */
					
					
				}
				
			}
		}
		
		
		//
		//// Extra Information
		//
		if ($val->preorder_state === "preorder_soon")
		{
			echo $LANGUAGE[util::$PREORDER_SOON];
			
		}
		else
		if ($val->preorder_state === "preorder_on")
		{
		//$LANGUAGE[util::$PREORDER_SOON]
			echo sprintf($LANGUAGE[util::$PREORDER_ON_NOW] ,$val->publishedat[$val->progress_link]);
			
		}		
			if ($val->type===$collection)
			
			{
				echo $LANGUAGE[util::$COLLECTION_NOTE];
			}
		if ($val->publishedat[util::$KEY_LIMITEDTIME] == util::$TRUE)
		{
			echo $LANGUAGE[util::$LIMITED_TIME];
		}

		
		
		
		echo '<div itemprop="author" itemscope itemtype="http://schema.org/Person">';
		echo '<meta itemprop="name" content="'.$AUTHOR.'"/>';
		echo '</div>';
		echo '<div itemprop="publisher" itemscope itemtype="http://schema.org/Organization">';
		echo '<meta itemprop="name" content="'.$PUBLISHER.'"/>';
		echo '</div>';
		//
		// End schema code
		//
		echo '</div>';
		///////////////////////////////////////////////////////////
		echo "</article>";
	}
}

 
  ?>
    </section>
 </section>
  
  
  <article>
 
 
<?php
 if ($FOOTER_ABOVE != "")
{
	echo $FOOTER_ABOVE;
}
?>
<div class="sharebuttons">

<?php
$showreviews="hidden";

//
// On FireFox we never show reviews (we can't make them appear properly)
//
if(isset($_SERVER['HTTP_USER_AGENT'])){
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
if(strlen(strstr($agent,"Firefox")) > 0 ){      
    // won't enable reviews
}
else
if ($SHOW_REVIEWS === util::$TRUE)
{

    $reviews = Review::LoadReviewsFromFile($workid);
	Review::AdjustListOfReviews($reviews);
	Review::BuildStylesheet($reviews);
	
	$showreviews="visible";
}
?>



<?php



if ($FACEBOOK_CODE !="")
{
	echo $FACEBOOK_CODE;
}
if ($GPLUS_CODE !="")
{
	echo $GPLUS_CODE;
}
if ($TWITTER_NAME!="")
{
echo '<a href="https://twitter.com/'.$TWITTER_NAME.'" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false" data-dnt="true">Follow @'.$TWITTER_NAME.'?></a>';
}
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
</article>

		<article id=slider style="color:white; visibility: <?php echo $showreviews;?>;">		
		
	
		<!-- Slider Setup -->
		<?php
			Review::BuildInputControls($reviews);
		?>
		
	
	
		<!-- The Slider -->
		
		<div id=slides>		
			<div id=overflow>			
				<div class=inner>	
				<?php
					Review::BuildArticles($reviews);
				?>				
					
				</div> <!-- .inner -->
			</div> <!-- #overflow -->
		</div> <!-- #slides -->
		<!-- Controls and Active Slide Display -->
	<?php
			Review::BuildControlLabels($reviews);
			Review::BuildActiveLabels($reviews);
		?>
		

			
		
	</article>

<article style="margin:0px 10px;">
<br/>
<?php

if ($FOOTER_BELOW != "")
{
	echo sprintf($FOOTER_BELOW, $brown, $chalkboardgreen,$gold);
	//echo $FOOTER_BELOW;
}
?>
  


   


<div style="color:white">
<br/><br/>
<?php

$footer_override = $result[util::$KEY_FOR_WORKSCREATED][util::$INDEX_SETTINGS_RECORD][util::$FOOTER];
if ($footer_override && $footer_override !== "")
{
	echo $footer_override;
}
else
	util::DrawFooterOnHTMLPage();?>
</div>
</article>



  </body>
</html>
