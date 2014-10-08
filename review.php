<?php
/*DETAILS
- Contains the review class.

*/
class Review{

	public static $REVIEW_FILE = "reviews.json";
	public static $REVIEW_SCHEMA = "schema_reviews";
	public static $REVIEW_COLUMNS = "columns_reviews";
	
	// Work Id associated with work (this connects the review to a specific work
	public $work_id=-1;
	// the caption heading
	public $review_caption="";
	// the snippet of review text to show
	public $review_text="";
	// web address to the actual article or location of the review
	public $review_site="";
	// reviewers name
	public $reviewer="";
	// work name
	public $workname="";
	// work link
	public $worklink="";
	
	function __construct($reviewcaption, $reviewtest, $workid, $reviewsite, $_reviewer, $_workname, $_worklink) {
	   $this->review_caption=$reviewcaption;
	   $this->review_text=$reviewtest;
	   $this->work_id = $workid;
	   $this->review_site= $reviewsite;
	   $this->reviewer = $_reviewer;
	   $this->workname = $_workname;
	   $this->worklink = $_worklink;
   }
	////////////////////////////////////////
	// Just randomizes the review list so the
	// same review is not always shown.
	////////////////////////////////////////
    public static function AdjustListOfReviews(&$reviews)
	{
		shuffle($reviews);
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
 	public static function BuildStylesheet($reviews)
	{
	
		echo "<style>";
		
		$count1 = 0;
		foreach ($reviews as $review)
		{
			$count1++;
			echo sprintf('#slide%s:checked ~ #slides .inner { margin-left:%s%%; }',$count1, -1 * (($count1-1)*100));
			echo "\n";
		}
		
		$count1 = 0;
		foreach ($reviews as $review)
		{
			$count1++;
			if ($count1 > 1) echo ",\n";
			$value_to_write = $count1+1;
			
			echo sprintf('#slide%s:checked ~ #controls label:nth-child(%s)', $count1, $value_to_write);
			
		}
		echo "{\nbackground: #ffffff url('arrowright.png') no-repeat;";
		echo "float: right;";
		echo "margin: 0 10px 0 0;";
		echo "display: block;\n}";
		// write out for next button
		
		
		// write out for prev button
		$count1 = 1;
		foreach ($reviews as $review)
		{
			$count1++;
			if ($count1 > 2) echo ",\n";
			$value_to_write = $count1-1;
			
			echo sprintf('#slide%s:checked ~ #controls label:nth-child(%s)', $count1, $value_to_write);
			
		}
		echo "{\nbackground: #ffffff url('http://www.phlume.com/chad/testtest/prev.png') no-repeat;";
		echo "float: left;";
		echo "margin: 0 0 0 10px;";
		echo "display: block;\n}";
		 
		 
		 // write out for active button
		$count1 = 1;
		foreach ($reviews as $review)
		{
			$count1++;
			if ($count1 > 1) echo ",\n";
			$value_to_write = $count1;
			
			echo sprintf('#slide%s:checked ~ #active label:nth-child(%s)', $count1, $value_to_write);
			
		}
		echo "{\n	background: #333;border-color: #333 !important;}";
		
			
			 // write out for INFO
		$count1 = 1;
		foreach ($reviews as $review)
		{
			$count1++;
			if ($count1 > 1) echo ",\n";
			$value_to_write = $count1;
			
			echo sprintf('#slide%s:checked ~ #slides article:nth-child(%s) .info', $count1, $value_to_write);
			
		}
		echo "{\n	opacity: 1;
	-webkit-transition: all 1s ease-out 0.6s;
	-moz-transition: all 1s ease-out 0.6s;
	-o-transition: all 1s ease-out 0.6s;
	transition: all 1s ease-out 0.6s;}";
		echo "</style>";
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
	public static function BuildInputControls($reviews)
	{
		$count1 = 0;
		foreach ($reviews as $review)
		{
			$count1++;
			$checked="";
			if ($count1 === 1) $checked = "checked";
			echo sprintf('<input %s type=radio name=slider id=slide%s />',$checked,$count1);
			echo "\n";
		}
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
	public static function BuildArticles($reviews)
	{
	$count1 = 0;
		foreach ($reviews as $review)
		{
			$count1++;
			$checked="";
			
			echo sprintf('<article><h2>%s</h2><h4> %s</h4><a href="%s">%s</a> | <a href="%s">%s</a></article>',$review->review_caption,$review->review_text,$review->worklink,$review->workname, $review->review_site,  $review->reviewer);
			echo "\n";
		}
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
	public static function BuildControlLabels($reviews)
	{
	$count1 = 0;
	echo '	<div id=controls>';
		foreach ($reviews as $review)
		{
			$count1++;
			$checked="";
			
			echo sprintf('<label for=slide%s>%s</label>',$count1,"");
			echo "\n";
		}

			
		
		echo '</div> <!-- #controls -->';
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
	public static function BuildActiveLabels($reviews)
	{
	$count1 = 0;
	echo '<div id=active>';
		foreach ($reviews as $review)
		{
			$count1++;
			$checked="";
			
			echo sprintf('<label for=slide%s>%s</label>',$count1,"");
			echo "\n";
		}

			
		
		echo '</div> <!-- #active --> ';
	}
	
	
	////////////////////////////////////////
	// for the editor_dashboard; list of reviews
	////////////////////////////////////////
	public static function DrawListOfReviewsForEditing()
	{
	echo "<h1>Reviews</h1>";
	 $result = json_decode(file_get_contents(Review::$REVIEW_FILE), true);
	 
	 $ListOfWorks = $result[util::$KEY_FOR_WORKSCREATED];
	// if (!$ListOfWorks) echo "nothing";
	 
	 $results_array = array();
	  foreach ( $ListOfWorks as $key_minor => $value_minor)
	  {
	 // echo "here";
		  $warning="";
		  $title = $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$REVIEWTITLE];
		  $workname = $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$WORKNAME];
		//echo "(".util::$REVIEWTITLE.") title = [".$title."] for key = ".$key_minor;
		  
		  // I put the ID = Title in here so that it would sort alphabetically.
			$results_array[$title] =  sprintf("<h3> <span class='nicelink label label-default'><a id='%s' href='editor.php?record=%s&columns_to_use=%s&schema_to_use=%s&override_json=%s'>%s</a></span>%s|%s</h3>",$title,$key_minor,
			Review::$REVIEW_COLUMNS,Review::$REVIEW_SCHEMA,Review::$REVIEW_FILE,
			$workname,$title,$warning);
	  }
	  	  
	  sort($results_array, SORT_STRING);
	  
		foreach ($results_array as $newkey=>$value)
		{
		
			echo $value;
		}
	  
	}
	////////////////////////////////////////
	// Load review file and reviews into array
	////////////////////////////////////////
	public static function LoadReviewsFromFile()
	{
		 $reviews = array();
	// load file
		$result = json_decode(file_get_contents(Review::$REVIEW_FILE), true);
		 $ListOfWorks = $result[util::$KEY_FOR_WORKSCREATED];
		if ($result)
		{
		
			foreach ( $ListOfWorks as $key_minor => $value_minor)
			{
			
			
				$title=$result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$REVIEWTITLE];
				if ($title && $title !== "")
				{
					
					$blurb= $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$REVIEWBLURB];
					$workid=$result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$REVIEW_WORKID];
					$reviewsite = $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$REVIEWSITE];
					$reviewname = $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$REVIEWER];
					$workname = $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$WORKNAME];
					$worklink = $result[util::$KEY_FOR_WORKSCREATED][$key_minor][util::$WORKLINK];
					$review =  new Review($title,$blurb, $workid, $reviewsite, $reviewname, $workname, $worklink);
					
					array_push($reviews, $review);
				}
			}
		 
		
		} 
		 return $reviews;
	}
	
}

?>
