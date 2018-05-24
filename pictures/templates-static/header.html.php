<?
//
//
// FILE: output header HTML include.
// NOTE: script assumes some variable is scope are set. see code.
//
//

require_once("metatags_generator.class.php");

$keywords = null;

$categories_metatags = new CCategoriesMetatagsGenerator();
$resourceManager->setResources($categories_metatags);

if ( $categories_metatags->open() )
{
  $keywords = htmlspecialchars( $categories_metatags->getMetatagsKeywordsString() );
}

/* ------------------------------------------------------------------------------------------------------------------------- */

$var->saveMode = INTO_URL_STRING;

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
            $var->getSaveResult($var->getSaveEntriesWithout("language", "nocache"));
            
$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_RUSSIAN)).".html";
$ui->add($url, "A_HREF_LANG_RUSSIAN");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_ENGLISH)).".html";
$ui->add($url, "A_HREF_LANG_ENGLISH");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_TRANSLIT)).".html";
$ui->add($url, "A_HREF_LANG_TRANSLIT");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_FINNISH)).".html";
$ui->add($url, "A_HREF_LANG_FINNISH");


$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_GERMAN)).".html";
$ui->add($url, "A_HREF_LANG_GERMAN");

//
//ADDED [17.04.2006 16:13][Dain] french language added
//
$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_FRENCH)).".html";
$ui->add($url, "A_HREF_LANG_FRENCH");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_ESPANIOL)).".html";
$ui->add($url, "A_HREF_LANG_ESPANIOL");

//
//ADDED [19.03.2008 17:20] [lex] swedish language added
//
$url = $var->getSaveResult($url_part, $var->getSaveEntry("language", LANGUAGE_SWEDISH)).".html";
$ui->add($url, "A_HREF_LANG_SWEDISH");

$url = CATALOG_URL.
       $var->getSaveResult(
         $var->getSaveEntriesWithout("change_currency_to", "nocache"),
         $var->getSaveEntry("change_currency_to", CURRENCY_ID_EUR)
       ).".html";

$ui->add($url, "A_HREF_EUR");

$url = CATALOG_URL.
       $var->getSaveResult(
         $var->getSaveEntriesWithout("change_currency_to", "nocache"),
         $var->getSaveEntry("change_currency_to", CURRENCY_ID_USD)
       ).".html";

$ui->add($url, "A_HREF_USD");

$url = CATALOG_URL.
       $var->getSaveResult(
         $var->getSaveEntriesWithout("change_currency_to", "nocache"),
         $var->getSaveEntry("change_currency_to", CURRENCY_ID_GBP)
       ).".html";

$ui->add($url, "A_HREF_GBP");

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
            $var->getSaveResult($var->getSaveEntriesFor("session", "language"),
                                $var->getSaveEntry("context", CONTEXT_CATALOG_BROWSE));

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_BOOKS)).".html";
$ui->add($url, "A_HREF_GOTOBOOKS");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_PEREODICS)).".html";
$ui->add($url, "A_HREF_GOTOPEREODICALS");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_PRINTED)).".html";
$ui->add($url, "A_HREF_GOTOPRINTED");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_AUDIO)).".html";
$ui->add($url, "A_HREF_GOTOAUDIO");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_VIDEO)).".html";
$ui->add($url, "A_HREF_GOTOVIDEO");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_SHEETMUSIC)).".html";
$ui->add($url, "A_HREF_GOTOSHEETMUSIC");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_SOFT)).".html";
$ui->add($url, "A_HREF_GOTOSOFT");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_MUSIC)).".html";
$ui->add($url, "A_HREF_GOTOMUSIC");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("entity",  ENTITY_MAPS)).".html";
$ui->add($url, "A_HREF_GOTOMAPS");

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
            $var->getSaveResult($var->getSaveEntriesFor("session", "language", "entity"));

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", DEFAULT_CONTEXT)).".html";
$ui->add($url, "A_HREF_MAIN");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_SHOPCART)).".html";
$ui->add($url, "A_HREF_SHOPCART");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_CATALOG_SEARCH)).".html";
$ui->add($url, "A_HREF_SEARCH");

$url_part = CATALOG_URL.$var->getSaveResult($var->getSaveEntriesFor("session", "language"));

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_INFO_ABOUT)).".html";
$ui->add($url, "A_HREF_ABOUTUS");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_INFO_CONTACTUS)).".html";
$ui->add($url, "A_HREF_CONTACTUS");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_INFO_FAQ)).".html";
$ui->add($url, "A_HREF_FAQ");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_INFO_PARTNERS)).".html";
$ui->add($url, "A_HREF_PARTNERS");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_INFO_LINKS)).".html";
$ui->add($url, "A_HREF_LINKS");

$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_INFO_FREE)).".html";
$ui->add($url, "A_HREF_FREE");

//NOTE [18.04.2006 22:51][Dain]: added link for page offers_firms
$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_OFFERS_FRMS)).".html";
$ui->add($url, "A_HREF_OFFERS_FRMS");

//NOTE [18.04.2006 22:51][Dain]: added link for page offers_libraries
$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_OFFERS_LIBS)).".html";
$ui->add($url, "A_HREF_OFFERS_LIBS");

//NOTE [15:32 24.05.2006][Dain]: added link for page offers_univercity
$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_OFFERS_UNIVERCITY)).".html";
$ui->add($url, "A_HREF_OFFERS_UNIVERCITY");

//NOTE [15:32 24.05.2006][Dain]: added link for page offers_partners
$url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_OFFERS_PARTNERS)).".html";
$ui->add($url, "A_HREF_OFFERS_PARTNERS");

/*
// 1- GIF, 2 - JPEG, 3 - not an image
function get_image_type($file_name)
{
    $formats_indicators = array(
        1 => array(0x47, 0x49, 0x46, 0x38, 0x39, 0x61),
        2 => array(0xFF, 0xD8, 0xFF, 0xE0, 0x00, 0x10, 0x4A, 0x46, 0x49)
    );
    $max_indicator_size = 10;

    $f = fopen($file_name, "rb")
    $buff = fread($f, $max_indicator_size);
    
    foreach($format_indicators as $type => $format_indicator)
    {
        $format_indicator &= $formats_indicators[$i];
        $matched_bytes = 0;
        for($j = 0; $j < $max_indicator_size; $j++ )
        {
            if ($format_indicator[$j] == $buff[$j])
            {
                $matched_bytes++;
            }
        }
        if ($matched_bytes == sizeof($format_indicator))
            return $type;
    }
    fclose($f);
}
*/

//
//  NOTE [17:49 07.08.2006][Dain]: image filename generator for menu output
//
//  WARNING!!! 
//    In order to save quality, input images must be proportionally to
//    59px in width and 81px in height
//
function is_image($file_name = null)
{
    $ret = false;
    if ( $file_name != null )
    {
        $image_allowed_extensions = array(
            "gif", "jpg", "jpeg",
            "GIF", "JPG", "JPEG"  // in_array() function is case-sensitive
        )
        ;
        $ext = substr( strrchr($file_name, "."), 1 );  // extension without dot
        if ( in_array($ext, $image_allowed_extensions) )
        {
            $ret = true;
        }
    }
    return $ret;
}

function get_menu_preview_image_name()
{
    $ret = "/pic1/gif_place.jpg";   // static image
    $image_files = array();
    
    $files = glob("/pictures/menu_images/*.*");  // sets a massive, filed with all filenames found in a pattern
    
    foreach ( $files as $file )
    {
        if ( is_image($file) )
            $image_files[] = $file;   // filling new massive with image files only (jpg, gif)
    }
    unset($file);
    
    // randomly selects and returns filename from image files massive 
    if ( $image_files && count($image_files) > 0 )
    {
        $img_num = mt_rand( 0, count($image_files) - 1 );
        $ret = $image_files[$img_num];
    }
    return $ret;
}

if ( !$user->isAuthorized() )
{
    $url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_LOGIN)).".html";
    $ui->add($url, "A_HREF_LOGIN");

    $url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_ADDUSER)).".html";
    $ui->add($url, "A_HREF_REGISTER");
}
else
{
    $url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_LOGOUT)).".html";
    $ui->add($url, "A_HREF_LOGOUT");

    $url = $var->getSaveResult($url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_MAIN)).".html";
    $ui->add($url, "A_HREF_PERSONAL_MAIN");
}

/* ------------------------------------------------------------------------------------------------------------------------- */

header('Content-type: text/html; charset=utf-8');

?>
<html>
<head>
  <title><?=$ui->item("HTML_PAGE_TITLE");?></title>
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="Cache-control" content="no-cache">
  <meta name="Keywords" content="<?=$keywords;?>">
  <META name="verify-v1" content="eiaXbp3vim/5ltWb5FBQR1t3zz5xo7+PG7RIErXIb/M=" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
  <script language="JavaScript" type="text/javascript" src="<?=RESOURCE_URL;?>various.js"></script>
  <link rel="stylesheet" type="text/css" href="<?=RESOURCE_URL;?>ruslania.css">
  <link rel="shortcut icon" type="image/x-icon" href="/pic1/favicon.ico">
  <base href="<?=RESOURCE_URL;?>">
</head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <!-- logo part (sun) -->
        <td class="topbg" width="165">
            <a href="<?=$ui->item("A_HREF_MAIN");?>"><img 
            border="0" src="/pic1/toplogo3.gif" width="165" height="118" alt="<?$ui->item("IMG_ALT_TOPLOGO")?>"></a>
        </td>
        <!-- main menus part -->
        <td class="topbg" style="align: left">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <!-- main entities menu part -->
                <tr>
                    <td background="/pic1/menu_bg_1.gif" valign="middle">
                        <table height="31" border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="padding-left: 10px;" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOBOOKS");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOBOOKS");?>">
                                    <?=$ui->item("A_GOTOBOOKS");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOSHEETMUSIC");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOMUSICSHEETS");?>">
                                    <?=$ui->item("A_GOTOMUSICSHEETS");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOPEREODICALS");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOPEREODICALS");?>">
                                    <?=$ui->item("A_GOTOPEREODICALS");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOMUSIC");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOMUSIC");?>">
                                    <?=$ui->item("Music catalog");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOAUDIO");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOAUDIO");?>">
                                    <?=$ui->item("A_GOTOAUDIO");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOVIDEO");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOVIDEO");?>">
                                    <?=$ui->item("A_GOTOVIDEO");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOSOFT");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOSOFT");?>">
                                    <?=$ui->item("A_GOTOSOFT");?>
                                    </a>
                                </td>
                                <td width="13%"></td>
                                <td align="left" style="padding-right: 10px;" nowrap>
                                    <a class="topenttxt"
                                    href="<?=$ui->item("A_HREF_GOTOMAPS");?>"
                                    title="<?=$ui->item("A_TITLE_GOTOMAPS");?>">
                                    <?=$ui->item("A_GOTOMAPS");?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- submenu part -->
                <tr>
                    <td height="57">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="topmnutxt">
                                    <!-- 
                                    <a href="<?//=$ui->item("A_HREF_SEARCH");?>" class="topmnutxt">
                                    <?//=$ui->item("A_SEARCH");?>
                                    </a><br>
                                    -->
                                    <a href="<?=$ui->item("A_HREF_SHOPCART");?>" class="topmnutxt">
                                    <?=$ui->item("A_SHOPCART");?>
                                    </a><br>
                                    <? if ( !$user->isAuthorized() ) { ?>
                                    <a href="<?=$ui->item("A_HREF_LOGIN");?>" class="topmnutxt">
                                    <?=$ui->item("A_SIGNIN");?>
                                    </a><br>
                                    <a href="<?=$ui->item("A_HREF_REGISTER");?>" class="topmnutxt">
                                    <?=$ui->item("A_REGISTER");?>
                                    </a><br>
                                    <? } else { ?>
                                    <a href="<?=$ui->item("A_HREF_PERSONAL_MAIN");?>" class="topmnutxt">
                                    <?=$ui->item('YM_CONTEXT_PERSONAL_MAIN');?>
                                    </a><br>
                                    <a href="<?=$ui->item("A_HREF_LOGOUT");?>" class="topmnutxt">
                                    <?=$ui->item('A_LEFT_PERSONAL_LOGOUT');?>
                                    </a>
                                    <? } ?>
                                </td>
                                <td class="topmnutxt">
                                    <a href="<?=$ui->item("A_HREF_FAQ");?>" class="topmnutxt">
                                    <?=$ui->item("A_FAQ");?>
                                    </a><br>
                                    <a href="<?=$ui->item("A_HREF_ABOUTUS");?>" class="topmnutxt">
                                    <?=$ui->item("A_ABOUTUS");?>
                                    </a><br>
                                    <a href="<?=$ui->item("A_HREF_CONTACTUS");?>" class="topmnutxt">
                                    <?=$ui->item("YM_CONTEXT_CONTACTUS");?>
                                    </a>
                                </td>
                                <td class="topmnutxt">
                                    <a href="<?=$ui->item("A_HREF_PARTNERS");?>" class="topmnutxt">
                                    <?=$ui->item("A_PARTNERS");?>
                                    </a><br>
                                    <a href="<?=$ui->item("A_HREF_LINKS");?>" class="topmnutxt">
                                    <?=$ui->item("A_LINKS");?>
                                    </a><br>
                                    <a href="<?=$ui->item("A_HREF_FREE");?>" class="topmnutxt">
                                    <?=$ui->item("A_FREE");?>
                                    </a>
                                </td>
                                <td class="topmnutxt" align="center">
                                    <?=$ui->item("A_OFFERS");?>
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td class="subtopmnutxt">
                                                <a href="<?=$ui->item("A_HREF_OFFERS_FRMS");?>" class="topmnutxt">
                                                &ndash;&nbsp;<?=$ui->item("A_OFFERS_FRMS");?>
                                                </a><br>
                                                <a href="<?=$ui->item("A_HREF_OFFERS_LIBS");?>" class="topmnutxt">
                                                &ndash;&nbsp;<?=$ui->item("A_OFFERS_LIBS");?>
                                                </a>
                                            </td>
                                            <td class="subtopmnutxt">
                                                <a href="<?=$ui->item("A_HREF_OFFERS_UNIVERCITY");?>" class="topmnutxt">
                                                &ndash;&nbsp;<?=$ui->item("A_OFFERS_UNIVERCITY");?>
                                                </a><br>
                                                <a href="<?=$ui->item("A_HREF_OFFERS_PARTNERS");?>" class="topmnutxt">
                                                &ndash;&nbsp;<?=$ui->item("A_OFFERS_PARTNERS");?>
                                                </a><br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- language and currency select area -->
                <tr>
                    <td background="pic1/menu_bg_2.gif">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td height="30" style="padding-left: 5px; padding-right: 5px;" nowrap>
                                    <?php /*
                                    <a class="topmnu1txt" style="font-weight: bold;">
                                    <?=$ui->item("CATALOGINDEX_CHANGE_LANGUAGE");?>:
                                    </a> */
                                    ?>
                                    <img src="/pic/null.gif" width="1" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_RUSSIAN");?>">
                                    <img src="/pic1/ru.gif" width="18" height="12" border="0" alt="ru" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_RUSSIAN");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_TRANSLIT");?>">
                                    <img src="/pic1/ru.gif" width="18" height="12" border="0" alt="ru" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_TRANSLIT");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_FINNISH");?>">
                                    <img src="/pic1/fi.gif" width="18" height="12" border="0" alt="fi" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_FINNISH");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_ENGLISH");?>">
                                    <img src="/pic1/us.gif" width="18" height="12" border="0" alt="us" style="vertical-align: text-bottom;">
                                    <img src="/pic1/uk.gif" width="18" height="12" border="0" alt="uk" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_ENGLISH");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_GERMAN");?>">
                                    <img src="/pic1/de.gif" width="18" height="12" border="0" alt="de" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_GERMAN");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_FRENCH");?>">
                                    <img src="/pic1/fr.gif" width="18" height="12" border="0" alt="fr" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_FRENCH");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_ESPANIOL");?>">
                                    <img src="/pic1/es.gif" width="18" height="12" border="0" alt="es" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_ESPANIOL");?>
                                    </a>
                                    <img src="/pic/null.gif" width="3" height="1">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_LANG_SWEDISH");?>">
                                    <img src="/pic1/se.gif" width="18" height="12" border="0" alt="se" style="vertical-align: text-bottom;">
                                    <?=$ui->item("A_LANG_SWEDISH");?>
                                    </a>
                                </td>
                                <td style="padding-right: 10px;" nowrap>
                                    <img src="/pic/null.gif" width="1" height="12">
                                    <a class="topmnu1txt" style="font-weight: bold;">
                                    <?=$ui->item("MSG_TOP_CHOOSE_CURRENCY");?>
                                    </a>
                                    <img src="/pic/null.gif" width="1" height="12">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_EUR");?>">
                                    <?=$ui->item("MSG_TOP_CHOOSE_CURRENCY_CHANGE_TO_EUR");?>
                                    </a>
                                    <img src="/pic/null.gif" width="1" height="12">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_USD");?>">
                                    <?=$ui->item("MSG_TOP_CHOOSE_CURRENCY_CHANGE_TO_USD");?>
                                    </a>
                                    <img src="/pic/null.gif" width="1" height="12">
                                    <a class="topmnu1txt" href="<?=$ui->item("A_HREF_GBP");?>">
                                    <?=$ui->item("MSG_TOP_CHOOSE_CURRENCY_CHANGE_TO_GBP");?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <!-- "new" separator-->
        <td width="9" bgcolor="#AC0000" valign="bottom">
            <img src="/pic1/new.gif" width="9" height="27" alt="new">
        </td>
        <!-- "new" menu -->
        <td bgcolor="#9BA6B3" style="padding-left: 10px;">
            <table cellpadding="0" cellspacing="0" border="0" height="100%">
                <tr>
                    <td class="newmnutxt" height="31" style="padding-top: 6px;">
                        <a class="topenttxt"
                        href="<?=$ui->item("A_HREF_GOTOPRINTED");?>"
                        title="<?=$ui->item("A_TITLE_GOTOPRINTED");?>">
                        <?=$ui->item("A_GOTOPRINTED");?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0">
                            <td class="newmnutxt">
                                <a 
                                href="<?=$ui->item("A_HREF_GOTOPRINTED");?>"
                                title="<?=$ui->item("A_TITLE_GOTOPRINTED");?>"><img
                                src="<?=get_menu_preview_image_name();?>" width="59" height="81" border="0"></a>
                            </td>
                            <td class="newmnutxt" nowrap align="left" style="padding-left: 10px;">
                                <font class="newmnutxt">
                                &ndash;&nbsp;<?=$ui->item("A_GOTOPRINTED_1");?><br>
                                &ndash;&nbsp;<?=$ui->item("A_GOTOPRINTED_2");?><br>
                                &ndash;&nbsp;<?=$ui->item("A_GOTOPRINTED_3");?><br>
                                &ndash;&nbsp;<?=$ui->item("A_GOTOPRINTED_4");?><br>
                                &ndash;&nbsp;<?=$ui->item("A_GOTOPRINTED_5");?><br>
                                &ndash;&nbsp;<?=$ui->item("A_GOTOPRINTED_6");?><br>
                                </font>
                            </td>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- top menu wnd !-->
<!-- main wnd !-->