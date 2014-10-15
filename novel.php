<?php
class Novel
{
    public $title;
    public $blurb;
	// 0 = live, 1 = active preorder, 2 = no preorder YET
	public $preorder_state;
	
	public $type; //novel,collection
	
	public $category; //scifi,horror,general,fantasy
	public $image;
	public $image_alt;
	//public $amazon_link;
	//public $print_link;
	public $priority; // sortable field (eventually)
	public $web_link;
	public $publishedat;
	public $showwork;
	public $isbn;
	public $showprogress;
	public $progress;
	public $stage;
	public $progress_link;
	public $workid;
	public $excerpt;
	public $position;
	
	public static function AddNovelFromArray($arr,$index)
{
	$myNovel = new Novel();
	$myNovel->position=$index;
	$myNovel->title = $arr[util::$KEY_TITLE];
	
	$myNovel->showprogress = $arr[util::$KEY_SHOW_PROGRESS];
	$myNovel->progress = $arr[util::$KEY_PROGRESS];
	$myNovel->stage = $arr[util::$KEY_STAGE];
	$myNovel->progress_link = $arr[util::$LINK_FOR_PROGRESS];
	
	$myNovel->blurb = $arr["blurb"];
	$myNovel->preorder_state = $arr["preorder_state"];
	$myNovel->category=$arr["category"];
	//$myNovel->amazon_link=$arr["amazon_link"];
	//$myNovel->print_link=$arr["print_link"];
	$myNovel->type=$arr["type"];
	$myNovel->image=$arr["image"];
	$myNovel->image_alt=$arr["image_alt"];
	$myNovel->priority=$arr["priority"];
	$myNovel->web_link=$arr["web_link"];
	$myNovel->showwork=$arr["showwork"];
	$myNovel->isbn=$arr["isbn"];
	$myNovel->excerpt=$arr["excerpt"];
	
	$myNovel->workid=$arr[util::$WORKID];
	$myNovel->publishedat=$arr;/// ["publishedat"]; Made a big change and now we need to do hacky/comlicated stuff for Editor support
	return $myNovel;
}
}
?>
