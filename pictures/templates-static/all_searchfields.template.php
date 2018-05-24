<?

class CTemplate_CatalogAllSearchFormFields extends CCommonTask
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
                 $ui->item("MSG_SEARCH_COMPLEX_0").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_complex_0")
               ).
               "<div class=mt5>".
                 $ui->item("MSG_SEARCH_COMPLEX_1").
               ":</div>".
               $html->createSingle_INPUT
               (
                 "type=text class=search1",
                 $var->getSaveEntry("search_complex_1")
               ).
               "<div class=mt5>".
                 $ui->item("Sort by").
               ":</div>";

               return $ret;
    }
}

return new CTemplate_CatalogAllSearchFormFields();