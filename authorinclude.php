<?php
require_once "review.php";
require_once "novel.php";

class util
{
	/*
	0.0.0.7.0 - randomized progress bars (status)
	0.0.0.6.3 - Excerpt systems
	0.0.0.6.1 - allow footer text to overridden
	0.0.0.6.0 - Allow "behavior" control of State/Status fields (i.e., deciding which states behave as a 'done' state)
	0.0.0.5.8 - Able to edit the schema to add fields (providing admin flexibility)
	0.0.0.5.7 - adding status information to dashboard
	0.0.0.5.6 - giving novel its own class file (refactoring)
	0.0.0.5.2 - adding review editing (reviews.json)
		0.0.0.5.0 - adding Review System
		0.0.0.4 - adding ability to display individuals works EXAMPLE: index.php?workid=3
		0.0.0.3.9 - changing email backup to a user button with configurable email address field
		0.0.0.3 - a deployment test for 'games.brentknowles.com'
		0.0.0.2 - the "translation" version of the editor was displaying translated versions of the strings. Needed to suppress.
		0.0.0.1 - adoption of the version number system
	*/
	private static $VERSION= '0.0.0.6.3';

	//
	// CONTROL PANEL
	//
	private static $ip_test = '*'; 
	
	//
	// INTERNAL VARIABLES
	//
	private static $initialized = false;
	
	
	//
	// PUBLIC GETS
	//
	
		
	
	
		//
		// SPECIAL VALUES
		//
		public static $TRUE="true";
		public static $FALSE="false";
		//public static $DONE="done"; made this user configurable with 0.0.0.6.0
		public static $SKIP_ENTRY="^skip^";
		public static $STRING="_string";// used when we need a custom affix to define a "string lookup" into the language file
		//
		// BEHAVIOR VALUES
		//
		public static $BEHAVIOR_DONE="done";
	
		//
		// SCHEMA FIELDS
		//
		public static $TYPE="type";
		public static $HELP="help";
	
		//
		// KEY INDEXES INTO JSON FILES -- OPTIONS
		//
		public static $KEY_DO_WE_SHOW_ADD_LINK_BUTTON="show_add_link_button";
		public static $KEY_COLUMNS_FOR_WORKSCREATED="columns_works";
		public static $KEY_FOR_WORKSCREATED="works";
		public static $KEY_SCHEMA_FOR_WORKSCREATED="schema_works";
		public static $KEY_STYLE_SHEET="index_style_sheet";
		public static $IMAGE_WIDTH= "image_width";
		public static $IMAGE_HEIGHT = "image_height";
		public static $BLOG_LINK="blog_link";
		public static $SHOW_ANY_OPTION="show_any_option";
		public static $FACEBOOK_CODE="facebook_code";
		public static $GPLUS_CODE="gplus_code";
		public static $TWITTER_NAME="twitter_name";
		public static $FOOTER_ABOVE="footer_above";
		public static $FOOTER_BELOW="footer_below";
		public static $DEFAULT_CATEGORY="default_category";
		public static $SCHEMEORG_SCHEMA="schemeorg_schema";
		public static $BACKUP_EMAIL_ADDRESS="backup_email_address";
		public static $SHOW_REVIEWS = "show_reviews";
		public static $TYPESOFFIELDS = "typesoffields";
		public static $FOOTER="footer";
			//
			// SPECIAL INDEXES INTO WORK CREATED
			//
			public static $INDEX_SETTINGS_RECORD=-1;
		
			//
			// KEY INDEXES INTO "Options.json.WORKS"
			//
			public static $KEY_TITLE ="title";
			public static $KEY_SHOW_PROGRESS="showprogress";
			public static $KEY_PROGRESS="progress";
			public static $KEY_STAGE="stage";
			public static $LINK_FOR_PROGRESS="link_for_progress";
			public static $WORKID = "workid";
			public static $KEY_COMMENT="comment";
		
		
		//
		// KEY INDEX FOR TRANSLATION index.php
		//
		public static $KEY_LOOKS_PAGETITLE=	"pagetitle";
		public static $KEY_LOOKS_PAGETITLE2=	"subtitle";
		public static $KEY_LOOKS_PAGETITLE3="subtitle2";
		public static $KEY_LOOKS_AUTHOR=	"author";
		public static $KEY_LOOKS_PUBLISHER ="publisher";
		public static $KEY_LIMITEDTIME="limitedtime";
		public static $KEY_OFFER="offer";
		public static $SPECIAL_OFFER_TITLE="special_offer_title";
		public static $PROGRESS_TITLE="progress_title";
		public static $HIDDEN_TITLE = "hidden_title";
		public static $PAGE_DESCRIPTION = "page_description";
		public static $KEY_CATEGORIES = "enum_category";
		public static $KEY_CATEGORIES2 = "enum_type";
		public static $COLLECTION_NOTE="collection_note";
		public static $PREORDER_SOON="preorder_soon";
		public static $LIMITED_TIME="limited_time";
		public static $NOW_AVAILABLE="now_available";
		public static $BLOG_LINK_LABEL="blog_link_label";
		public static $PREORDER_ON_NOW="preorder_on_now";
		
		//
		// KEY INDEX FOR EDITOR TRANSLATION
		//
	
	
		//
		// KEY INDEX FOR REVIEW SYSTEM
		//
		public static $REVIEWTITLE="reviewtitle";
		public static $REVIEWBLURB="reviewblurb";
		public static $REVIEWSITE = "reviewsite";
		public static $REVIEWER = "reviewer";
		public static $REVIEW_WORKID="workid";
		public static $WORKNAME= "workname";
		public static $WORKLINK="worklink";
		public static $SHOWREVIEW="showreview";
	//
	// All methods should invoke this in case there's some setup needed
	//
    private static function initialize()
    {
    	if (self::$initialized)
    		return;


    	self::$initialized = true;
    }
	public static function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	
	//
	//
	//
	public static function GetIsBrowserFireFox()
	{
		if(isset($_SERVER['HTTP_USER_AGENT'])){
		$agent = $_SERVER['HTTP_USER_AGENT'];
				if (strlen(strstr($agent,"Firefox")) > 0)
				{
					return 1;
				}
		}
		return 0;

	}
	//
	//
	//
	public static function GetIsBrowserIOS()
	{
		if(isset($_SERVER['HTTP_USER_AGENT'])){
		$agent = $_SERVER['HTTP_USER_AGENT'];
		
		$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
		if( $iPod || $iPhone || $iPad){
		return 1;
		}
		}
		return 0;

	}
	
	//
	// Get the IP address that we use to test user authentication against
	//
	public static function GetIP()
	{
		self::initialize();
		return self::$ip_test;
	}
	//
	// Get the version number to display where needed
	//
	public static function GetVersionNumber()
	{
		self::initialize();
		return self::$VERSION;
	}
	//
	// Places a footer with version # and support information
	//
	public static function DrawFooterOnHTMLPage()
	{
		echo sprintf("<br/><b>Author Control</b> -- Version: %s | For support visit Brent Knowles's <a href='%s' class='nicelink'><u>Contact Page</u></a>",self::$VERSION,'http://blog.brentknowles.com/contactnewsletter/');
	}
}
?>
