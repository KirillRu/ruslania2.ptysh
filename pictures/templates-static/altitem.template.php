<?
//
// NOTE: used from item detailed view
//
class CTemplate_CatalogAlternativeItems extends CCommonTask
{
    var $fields = NULL;

    function setData(&$r)
    {
        $this->fields = &$r;
    }

    function getText()
    {
        $ui =& $this->ui;

        if ($this->fields->length() == 0) 
            return NULL;

        $ret = "<tr><td class=maintxt>".
                 "<div class=choose2>".
                   "<b>".$ui->item("ALTERNATIVE_ITEMS_TITLE")."</b>&nbsp;&nbsp;";
                 
        while($this->fields->next())
        {
            $r = $this->fields->item();

            $ret .= "<a class=\"ctitle1\" title=\"".$ui->item("ITEM_MORE_INFO")."\" ".
                    "href=\"".$r->details_url."\">".
                      CCatalog::getEntityDispayName($r->entity)."</a>,&nbsp;";
        }
        
        $ret =  substr($ret, 0, -7);
        
        $ret .= "</div></td></tr>";
        
        return $ret;
    }
}

return new CTemplate_CatalogAlternativeItems;

?>