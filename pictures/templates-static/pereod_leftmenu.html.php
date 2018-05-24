<?

//
// FILE: pereod_leftmenu.html.php
// INFO: static template
//
// DESCRIPTION: Output left menu HTML include file for pereod catalog.
//              Also defines some URL`s for left menu.


$var->saveMode = INTO_URL_STRING;

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
        $var->getSaveResult($var->getSaveEntriesFor("session", "language", "entity"));

$url = $var->getSaveResult
       (
           $url_part,
           $var->getSaveEntry("context", CONTEXT_CATALOG_CATEGORIES_TREE)
       ).".html";
$ui->add($url, "A_HREF_CATALOG_CATEGORIES_TREE");

/* ------------------------------------------------------------------------------------------------------------------------- */

// NOTE: ui const "A_HREF_SEARCH" defined in `header.html.php`
// NOTE: ui const "A_HREF_OFFLINE_ORDER" defined in `header.html.php`

?>

<!-- left menu wnd !-->
<table width=100% cellspacing=0 cellpadding=0 border=0>
<?

//
// NOTE: print search form
//
$leftMenu = $statTemplate->getPath(STATIC_TEMPLATE_FOR_SEARCH_FORM);
require($leftMenu);

//
// NOTE: print subcategories list
//
$scat_list = $cat->getSubcategoriesList();

if ($scat_list !== NULL)
{
    $template = $dynTemplate->createInstance(DYNAMIC_TEMPLATE_FOR_CHILD_CAT_LIST);
    $template->setData($scat_list);
    echo $template->getText();
    unset($template);
}

?>
<tr>
  <td class=leftmnutitle1>
    <table cellspacing=0 cellpadding=0 border=0>
    <tr>
      <td width=30 align=center><img src=/pic1/arr2.gif width=14 height=14></td>
      <td class=leftmnutitle1-table-txt>
      <?=$ui->item("LEFT_ADVANCED_FEATURES");?>
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr>
  <td class=leftmnu2>
    <table width=100% border=0 cellspacing=5 cellpadding=3>
    <tr>
      <td valign=top><img src=/pic/cl_f1.gif width=4 height=10></td>
      <td class=maintxt><a class=maintxt1
      href="<?=$ui->item("A_HREF_CATALOG_CATEGORIES_TREE");?>">
      <?=$ui->item("A_LEFT_PEREOD_CATTREE_PROPERTYLIST");?></a></td>
    </tr>
    <tr>
      <td valign=top><img src=/pic/cl_f1.gif width=4 height=10></td>
      <td class=maintxt><a class=maintxt1
      href="<?=$ui->item("A_HREF_SEARCH");?>">
      <?=$ui->item("A_LEFT_PEREOD_SEARCH");?></a></td>
    </tr>
  </table>
</td>
</tr>
<?
//
// NOTE: print entity catalog price list generator
//
$c = $var->data->item("context");

if ( $c == CONTEXT_CATALOG_BROWSE || $c == CONTEXT_CATALOG_SEARCH || $c == CONTEXT_CATALOG_FILTER )
{
    $url = CATALOG_URL.$var->getSaveResult($var->getAllSaveEntries(), $var->getSaveEntry("view_pricelist", TRUE)).".html";

    ?>
    <tr>
      <td class=leftmnutitlenp>
        <table width=100% border=0 cellspacing=5 cellpadding=3>
        <tr>
          <td><img src=/pic1/downprice1.gif width=18 height=31 border=0></td>
          <td class=maintxt>
            <a onclick="window.open('<?=$url;?>', '_blank', 'height=250,width=300,status=yes,toolbar=yes,menubar=yes,location=no'); return false;"
            href=#
                class=maintxt1><?=$ui->item("LEFT_GET_PRICELIST");?></a>
          </td>
        </tr>
        </table>
      </td>
    </tr>
    <?
}

$leftMenu = $statTemplate->getPath(STATIC_TEMPLATE_FOR_LEFTMENU_LOGINFORM);
require($leftMenu);

?>
</table>
<!-- left menu wnd !-->