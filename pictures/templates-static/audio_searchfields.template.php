<?

class CTemplate_CatalogAudioSearchFormFields extends CCommonTask
{
    var $fields;

    function setData(&$r) { $this->fields = $r;}

    function getText()
    {
        $ui  =& $this->ui;
        $var =& $this->argv;
        $cat =& $this->fields;

        $html = new HTMLControlsHelper();

        $ret =
               "<div class=mt5>".
                 $ui->item("Title").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_title")
               ).
               "<div class=mt5>".
                 $ui->item("Description").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_description")
               ).
               "<div class=mt5>".
                 $ui->item("Author").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_author")
               ).
               "<div class=mt5>".
                 $ui->item("Performer").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_performer")
               ).
               "<div class=mt5>".
                 $ui->item("Publisher").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_publisher")
               );

        $type_col = $cat->getShortNamedAttributeCollection("audio_media");

        if ($type_col !== NULL)
        {
            $type_col->add("-1", $ui->item("NOT_MEANING"));
            $type_col->sortByValues();

            $ret .=
                     "<div class=mt5>".
                       $ui->item("Media").
                     ":</div>".
                     $html->createSingle_SELECT
                     (
                       "style=\"width: 100%\" class=sort",
                       $var->getSaveResult( $var->getSaveEntry("search_type") ),
                       $type_col
                     );
        }
        
        $categories_list_coll = new CCollection();
        $categories_list_coll->add("-1", $ui->item("NOT_MEANING"));
        
        $categories = $cat->getFirstLevelCategoriesList();
        while($categories->next())
        {
            $c = $categories->item();       
            $categories_list_coll->add( $c->id, $c->title );
        }
                        
        $ret .=  "<div class=mt5>".
                   $ui->item("Related categories").
                 ":</div>".
                 $html->createSingle_SELECT
                 (
                   "style=\"width: 100%\" class=sort",
                   $var->getSaveResult( $var->getSaveEntry("search_category") ),
                   $categories_list_coll
                 );

         $ret .=
               "<div class=mt5>".
                 $ui->item("ISBN").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_isbn")
               ).
               "<div class=mt5>".
                 $ui->item("EAN").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_ean")
               ).
               "<div class=mt5>".
                 $ui->item("Stock_id").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_stock_id")
               ).
               
               "<div class=mt5>".
                   "<label class=\"for_radio\" for=\"search_in_stock\">".
                     $ui->item("SEARCH_IN_STOCK").
                   "</label>".
                   
                   $html->createSingle_INPUT
                   (
                     "type=checkbox id=\"search_in_stock\"",
                     $var->getSaveEntry("search_in_stock")
                   ).
               "</div>".

               "<div class=mt5>".
                 $ui->item("Sort by").
               ":</div>";

               return $ret;
    }
}

return new CTemplate_CatalogAudioSearchFormFields();