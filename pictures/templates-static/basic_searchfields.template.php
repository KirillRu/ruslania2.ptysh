<?

class CTemplate_Basic_CatalogSearchFormFields extends CCommonTask
{
    var $fields;

    function setData(&$r) { $this->fields = $r;}

    function getText()
    {
        $ui  =& $this->ui;
        $var =& $this->argv;
        $cat =& $this->fields;

        $html = new HTMLControlsHelper();

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
        $optionsCollection->add(ENTITY_PRINTED,     $ui->item("A_GOTOPRINTED"));
        $optionsCollection->add(ENTITY_MAPS,     $ui->item("A_GOTOMAPS"));
        
        $ret =
               "<div class=mt5>".
                 $ui->item("A_BASIC_SEARCH_FIELD").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text style=\"width: 200px\" class=search1",
                 $var->getSaveEntry("basic_search_expression")
               ).
               "<div class=mt5>".
                 $ui->item("A_LEFT_WHERE_SEARCH").
               ":</div>".
               $html->createSingle_SELECT
               (
                 "class=search1  style=\"width: 200px\"", 
                 $var->getSaveResult($var->getSaveEntry("entity")), 
                 $optionsCollection
               );

            return $ret;
    }

}

return new CTemplate_Basic_CatalogSearchFormFields();