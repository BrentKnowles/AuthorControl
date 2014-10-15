<?php
// * COLORS
$background_color="#000000";
$border1_color="#94704D";
$innerbackground_color= "#333333";
$bookboxtext_color="#F0EDEB";
$boookboxborder_color="#A49586";
$brown="#5E4631";
$bookbox_title_background_color=$brown; 
$chalkboardgreen="#29472B";//"#3B653D";
$gold="#FFFFA3";// the yellow-gold
$bookbox_title_color=$gold; 
$link_mouseover_color=$gold;
?>
<style>
.closebutton2{
 background-color: rgba(255, 255, 255, 1);
 top: 5px; // don't want button above
 //right: 60px;
 //left:100px;
 right:20px;
 width: 30px;
 font-size:30px;
}
.popupoverride{
 width:40%;
 z-index: 100;
}
.card ul li {
//	text-color: rgba(0, 0, 0, 1);
//	text-color: #800080;
//	border: 3px solid #07839f;
//	line-height: 25px;
//	padding: 15px;
	height: 300px;
	text-shadow: black 0.2em 0.1em 0.2em;
}
.snake ul li:nth-child(6) { height:100px; width: 250px; margin: 100px 30px 50px 2px; vertical-align: middle; text-align: middle;}
.snake ul li:nth-child(1) { height:100px; width: 250px; margin: 100px 30px 50px 2px; vertical-align: middle; text-align: middle;}



/*
	0.3.0.1 - Tweaking to read Category (horror,scifi) from user data AND grab a proper read-able word to display (i.e., localization)
	0.3 - Despite comments to the contrary (14/09/2014) ISBN's on individual links can override the global ISBn on a product (if you have a print sku as well as an ebook)
REVISION  0.2 - Changing download links to an array
 REviSION 0.1 - simplying the design
 
*/
body{
background-color:<?php echo $background_color;?>;
font-family: 'Droid Serif', serif;
font-size:0.9em;
}
h1{
color:green;
}
p.subtitle{
color:red;
font-size:1.4em;
letter-spacing: .1em;
}

.sharebuttons a:visited{
color:white;
}
.sharebuttons{
margin-right:auto;
float:top;
float:right;
}
.sharebuttons a:link
{
color:white;
}
.nicelink:link{
color:white;
text-decoration: none;
}
.nicelink:visited{
color:white;
}
.nicelink:hover{
color:<?php echo $link_mouseover_color;?>;
}
.border1{
border: <?php echo $border1_color; ?> ridge 0.7em;
}
.data {
 -webkit-column-count: 2; /* Chrome, Safari, Opera */
    -moz-column-count: 2; /* Firefox */
    column-count: 2;
	-webkit-column-gap: 5px; /* Chrome, Safari, Opera */
    -moz-column-gap: 5px; /* Firefox */
    column-gap: 5px;
	margin: 1em;
}
.datacolrule{
-webkit-column-rule: 1px outset #ff00ff; /* Chrome, Safari, Opera */
    -moz-column-rule: 1px outset #ff00ff; /* Firefox */
    column-rule: 1px outset #ff00ff;
	
	 -webkit-column-rule-color: white; /* Chrome, Safari, Opera */
    -moz-column-rule-color: white; /* Firefox */
    column-rule-color: white;
	margin: 0.5em;
	padding:1em;
}
.centerelement{
	margin: auto;
   width: 65%;
   min-width:800px;
   
}
.innerbackground{
background-color:  <?php echo $innerbackground_color; ?>;
}
.imageboxattop{
height: 70%;
width: 50%;
float:right;
background-color:<?php echo $chalkboardgreen; ?>;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
padding: 0.05em;
margin:0.3em;
}
.ChalkBox{
height: auto;
width: 50%;
float:right;
background-color:<?php echo $chalkboardgreen; ?>;
}
.bookbox{
border: <?php echo $boookboxborder_color; ?> groove;
border-width:.1em .1em .1em .1em;
display: inline-block; /* this should provent content from breaking across COLUIMN boundaries*/
width: 95%;
height:auto;
color: <?php echo $bookboxtext_color; ?>;
padding:0.5em;
}
nav{
margin:1em;
color:white;
}
.booktitle{
margin: auto;
   width: 75%;
   height: auto;
   line-height:1em;
   background-color:<?php echo $bookbox_title_background_color;?>;
   color:<?php echo $bookbox_title_color;?>;
   margin: 1em; 
   align:center;
   padding:0.3em;
   vertical-align:middle;
}
.booktitle a{
color:<?php echo $bookbox_title_color;?>;
}
.bookimage{
float:left;
padding: 0.3em;
margin: 0em 1.2em 1.2em 1.2em;
}
.kindlebuttonimage{
margin: 2em 0.1em 0.1em 0.1em;
}
.titleandsubdiv{
margin:2em;
line-height:2em;
position:absolute; top:10%; height:1em; margin-top:-5em;
}
.title{
font-size:2.4em;
letter-spacing: .01em;
}
.divbuffer{
margin: 0.9em;
}
.topbox{
height: 15em;
}

.chalk{
color:white;
}
.gold{
color: <?php echo $gold;?>;
}
.gold:visited{
color: <?php echo $gold;?>;
}
.gold:link{
color: <?php echo $gold;?>;
}
.letterpress{
text-shadow: rgb(224, 224, 224) 1px 1px 0px;
}
.floatleftlinks{
text-align: left;
}
.floatrightlinks{
text-align: right;
}
.neon {
   color: #D0F8FF;
   text-shadow: 0 0 5px #A5F1FF, 0 0 10px #A5F1FF,
           0 0 20px #A5F1FF, 0 0 30px #A5F1FF,
           0 0 40px #A5F1FF;
}
.select{
text-decoration:underline;
}
.select:link{
text-decoration:underline;
}
.select:visited{
text-decoration:underline;
}
  .progresslabel {
    position: relative;
    left: 8px;
	top: -18px;
	white-space: nowrap;
    font-size: small;
	color:white;
}
progress {
	width: 90%;
	height: 20px;
	/* Important Thing */
	-webkit-appearance: none;
	border: none;
}
/* All good till now. Now we'll style the background */
progress::-webkit-progress-bar {
	background: black;
	border-radius: 25px;
	padding: 1px;
	box-shadow: 0 1px 0px 0 rgba(255, 255, 255, 0.2);
}

/* Now the value part */
progress::-webkit-progress-value {
	border-radius: 25px;
	box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.4);
	background:
		-webkit-linear-gradient(45deg, transparent, transparent 33%, rgba(0, 0, 0, 0.1) 33%, rgba(0, 0, 0, 0.1) 66%, transparent 66%),
		-webkit-linear-gradient(top, rgba(255, 255, 255, 0.25), rgba(0, 0, 0, 0.2)),
		-webkit-linear-gradient(left, #ba7448, #c4672d);
}
.specialoffer{
float: right;
height: 95%;
width:48%;

}
.limitedtime{
color:red;
}
.error{
color:red;
}
.faq {
	
}

.faq ul {
	
}

.faq ul li {
	display:block;
}

.faq ul li div {
	display:none;
}

.faq ul li div:target {
	display:block;
}
.orangebox{
    border: 2px solid;
    border-radius: 25px;
	padding: 10px;
	border-color: orange;
}
</style>
