<?php
class util
{
	/*
		0.0.0.3 - a deployment test for 'games.brentknowles.com'
		0.0.0.2 - the "translation" version of the editor was displaying translated versions of the strings. Needed to suppress.
		0.0.0.1 - adoption of the version number system
	*/
	private static $VERSION= '0.0.0.3.4';

	//
	// CONTROL PANEL
	//
	private static $ip_test = '*.*.*.*';
	
	//
	// INTERNAL VARIABLES
	//
	private static $initialized = false;
	
	
	//
	// PUBLIC GETS
	//
	
		//
		// SPECIAL INDEXES INTO WORK CREATED
		//
		public static $INDEX_SETTINGS_RECORD=-1;
	
	
	
		//
		// SPECIAL VALUES
		//
		public static $TRUE="true";
		public static $DONE="done";
		public static $SKIP_ENTRY="^skip^";
	
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
		//
		// KEY INDEXES INTO "WORKS"
		//
		public static $KEY_TITLE ="title";
		public static $KEY_SHOW_PROGRESS="showprogress";
		public static $KEY_PROGRESS="progress";
		public static $KEY_STAGE="stage";
		public static $LINK_FOR_PROGRESS="link_for_progress";
		
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
		
		
		//
		// KEY INDEX FOR EDITOR TRANSLATION
		//
	
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
