<?php
/*DETAILS
- Contains the review class.

*/
class Review{
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
	
	function __construct($reviewcaption, $reviewtest, $workid, $reviewsite, $_reviewer) {
	   $this->review_caption=$reviewcaption;
	   $this->review_text=$reviewtest;
	   $this->work_id = $workid;
	   $this->review_site= $reviewsite;
	   $this->reviewer = $_reviewer;
   }
	////////////////////////////////////////
	// Just randomizes the review list so the
	// same review is not always shown.
	////////////////////////////////////////
    public function AdjustListOfReviews(&$reviews)
	{
		shuffle($reviews);
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
 	public function BuildStylesheet($reviews)
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
	public function BuildInputControls($reviews)
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
	public function BuildArticles($reviews)
	{
	$count1 = 0;
		foreach ($reviews as $review)
		{
			$count1++;
			$checked="";
			
			echo sprintf('<article><h2>%s</h3><h4> %s</h4><a href="%s">%s</a></article>',$review->review_caption,$review->review_text, $review->review_site, $review->reviewer);
			echo "\n";
		}
	}
	////////////////////////////////////////
	//
	////////////////////////////////////////
	public function BuildControlLabels($reviews)
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
	public function BuildActiveLabels($reviews)
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
}

?>
