<?

require_once("htmlcontrols.class.php");

class CTemplate_CatalogBooksSortby extends CCommonTask
{
    var $sortbyTitles = NULL;
    var $fields = NULL;

    function CTemplate_CatalogBooksSortby()
    {
        $this->sortbyTitles = new CCollection();
    }

    function setData(&$r)
    {
        if (!is_array($r) && sizeof($r) > 0)
        {
            trigger_error("CTemplate_CatalogBooksSortby::setData(...) receives incorrect parameter. ".
                          "Second parameter must be an one-member NAME-VALUE array.",
                          E_USER_ERROR);
        }
        else
        {
            $this->fields =& $r;
        }
    }

    function getText()
    {
        $ui =& $this->ui;
        $s  =& $this->sortbyTitles;

        $s->add(SORTBY_ALL_TITLE_ASC,       $ui->item("SORTBY_ALL_TITLE_ASC"));
        $s->add(SORTBY_ALL_TITLE_DESC,      $ui->item("SORTBY_ALL_TITLE_DESC"));
        $s->add(SORTBY_ALL_PRICE_ASC,       $ui->item("SORTBY_ALL_PRICE_ASC"));
        $s->add(SORTBY_ALL_PRICE_DESC,      $ui->item("SORTBY_ALL_PRICE_DESC"));
        $s->add(SORTBY_ALL_POPULAR_DESC,    $ui->item("SORTBY_ALL_POPULAR_DESC"));
        $s->add(SORTBY_ALL_POPULAR_ASC,     $ui->item("SORTBY_ALL_POPULAR_ASC"));

        $html = new HTMLControlsHelper();

        return $html->createSingle_SELECT("class=sort", $this->fields, $s);
    }
}

return new CTemplate_CatalogBooksSortby();

?>