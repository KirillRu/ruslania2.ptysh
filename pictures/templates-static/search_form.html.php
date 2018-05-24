<?
//
// FILE: search_form.html.php
// INFO: static template
//
// DESCRIPTION: Output left menu HTML search form.
//

if (CONTEXT_CATALOG_BASIC_SEARCH != $var->data->item("context") && 
    CONTEXT_CATALOG_SEARCH != $var->data->item("context") )
{

require_once("htmlcontrols.class.php");

$oldSaveMode = $var->saveMode;
$var->saveMode = INTO_NAMEVALUE_ARRAY;

$html = new HTMLControlsHelper();

/* ------------------------------------------------------------------------------------------------------------------------- */

$saveEntryCommon = $var->getSaveResult
(
  $var->getSaveEntriesFor("session", "language"),
  $var->getSaveEntry("context", CONTEXT_CATALOG_BASIC_SEARCH)
);

$optionsCollection = new CCollection();

$optionsCollection->add(ENTITY_ALL,         $ui->item("A_GOTOEVERYWHERE"));
$optionsCollection->add(ENTITY_BOOKS,       $ui->item("A_GOTOBOOKS"));
$optionsCollection->add(ENTITY_SHEETMUSIC,  $ui->item("A_GOTOMUSICSHEETS"));
$optionsCollection->add(ENTITY_PEREODICS,   $ui->item("A_GOTOPEREODICALS"));
$optionsCollection->add(ENTITY_AUDIO,       $ui->item("A_GOTOAUDIO"));
$optionsCollection->add(ENTITY_VIDEO,       $ui->item("A_GOTOVIDEO"));
$optionsCollection->add(ENTITY_MUSIC,       $ui->item("Music catalog"));
$optionsCollection->add(ENTITY_SOFT,        $ui->item("A_GOTOSOFT"));
$optionsCollection->add(ENTITY_MAPS,        $ui->item("A_GOTOMAPS"));

//NOTE [20.04.2006 22:30][Dain]: added
$optionsCollection->add(ENTITY_PRINTED,     $ui->item("A_GOTOPRINTED"));


$html_input = $html->createSingle_INPUT(
    "type=text class=search1", 
    $var->getSaveEntry("basic_search_expression") );
    
$html_input_hidden = $html->createMulitple_INPUT(
    "type=hidden", 
    $saveEntryCommon);

if( CONTEXT_CATALOG_MAIN == $var->data->item("context") )
{
    $select_current_entity = $var->getSaveResult($var->getSaveEntry("entity", ENTITY_ALL));
}
else 
{
    $select_current_entity = $var->getSaveResult($var->getSaveEntry("entity"));
}
    
$html_select = $html->createSingle_SELECT(
    "class=search1", 
    $select_current_entity, 
    $optionsCollection);

$var->saveMode = $oldSaveMode;
?>

<tr>
  <td class=leftmnutitle1>
    <table cellspacing=0 cellpadding=0 border=0>
    <tr>
      <td width=30 align=center><img src=pic1/arr2.gif width=14 height=14></td>
      <td class=leftmnutitle1-table-txt>
      <?=$ui->item("A_LEFT_SEARCH_WIN");?>
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr>
  <form action="<?=CATALOG_URL;?>" method=GET>
  <td class=leftmnu2>
    <!-- login form begin !-->
    <table width=100% border=0 cellspacing=5 cellpadding=0>
    <tr>
      <td class=maintxt>
      <?=$ui->item("A_LEFT_I_SEARCH");?>:<br>
      <?=$html_input;?>
      </td>
    </tr>
    <tr>
      <td class=maintxt style="width: 40%">
      <?=$ui->item("A_LEFT_WHERE_SEARCH");?>:<br>
      <?=$html_select;?>
      </td>
    </tr>
    <tr>
      <td class=maintxt>
      <?
            echo '<input type=image src="pic1/'.$ui->item("BTN_SEARCH_PICTURE").
                 '" alt="'.$ui->item("BTN_SEARCH_ALT").'">'.
             $html_input_hidden;
      ?>
      </td>
    </tr>
    <?php
    if ($var->data->item("context") != CONTEXT_CATALOG_MAIN) {
    ?>
    <tr>
      <td class=maintxt style="padding-top: 1px; padding-bottom: 3px">
        <a class=maintxt href="<?=$ui->item("A_HREF_SEARCH");?>">
        <?=$ui->item("A_ADVANCED_SEARCH");?>
        </a>
      </td>
    </tr>
    <?php
    }
    ?>
    </form>
    </table>
    <!-- login form end !-->
  </td>
</tr>

<?
} // if (CONTEXT_CATALOG_BASIC_SEARCH != $var->data->item("context") && 
  //     CONTEXT_CATALOG_SEARCH != $var->data->item("context") )
?>