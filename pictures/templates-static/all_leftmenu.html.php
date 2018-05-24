<?

//
// FILE: books_leftmenu.html.php
// INFO: static template
//
// DESCRIPTION: Output left menu HTML include file for books catalog.
//              Also defines some URL`s for left menu.


$var->saveMode = INTO_URL_STRING;

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
        $var->getSaveResult($var->getSaveEntriesFor("session", "language", "entity"));

$url = $var->getSaveResult
       (
           $url_part,
           $var->getSaveEntry("context", CONTEXT_CATALOG_CATEGORIES_TREE)
       ).
       ".html";
$ui->add($url, "A_HREF_CATALOG_CATEGORIES_TREE");

$url = $var->getSaveResult
       (
           $url_part,
           $var->getSaveEntry("context", CONTEXT_CATALOG_SERIES_LIST)
       ).
       ".html";
$ui->add($url, "A_HREF_CATALOG_SERIES_LIST");

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
        $var->getSaveResult
        (
            $var->getSaveEntriesFor("session", "language", "entity"),
            $var->getSaveEntry("context", CONTEXT_CATALOG_AZ_PROPERTYLIST)
        );

$url = $var->getSaveResult
       (
            $url_part,
            $var->getSaveEntry("propertylist_type", PROPERTYLIST_FOR_PUBLISHERS)
       ).
       ".html";
$ui->add($url, "A_HREF_PROPERTYLIST_FOR_PUBLISHERS");


$url = $var->getSaveResult
       (
           $url_part,
           $var->getSaveEntry("propertylist_type", PROPERTYLIST_FOR_AUTHORS)
       ).
       ".html";
$ui->add($url, "A_HREF_PROPERTYLIST_FOR_AUTHORS");

/* ------------------------------------------------------------------------------------------------------------------------- */

// NOTE: ui const "A_HREF_SEARCH" defined in `header.html.php`

?>
<!-- left menu wnd !-->
<table width=100% cellspacing=0 cellpadding=0 border=0>
<?

//
// NOTE: print search form
//
$leftMenu = $statTemplate->getPath(STATIC_TEMPLATE_FOR_SEARCH_FORM);
require($leftMenu);

$leftMenu = $statTemplate->getPath(STATIC_TEMPLATE_FOR_LEFTMENU_LOGINFORM);
require($leftMenu);

?>
</table>
<!-- left menu wnd !-->
