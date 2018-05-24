<?
//
// NOTE: used from book detailed view
// NOTE: "ABI" in class name means "Also Buy Item"
//
class CTemplate_CatalogVideoItem_ABI extends CCommonTask
{
    var $fields = NULL;

    //var $i = 0;

    function setData(&$r)
    {
        $this->fields = &$r;
    }

    function getText()
    {
        $ui =& $this->ui;

        if ( $this->fields->length() <= 0 ) return NULL;

        $ret = "<tr><td width=100% class=maintxt>";
        
        while($this->fields->next())
        {
            $r = $this->fields->item();
            
            $item = "<a class=ctitle1 title=\"".$ui->item("ITEM_MORE_INFO")."\" ".
                    "href=\"".$r->details_url."\">".
                      $r->title."</a>".
                    "<br>";
                    
            $img = CEntityCatalog::getEntityImage($r->entity);
            
            $item .= 
                "<div><nobr>".
                "<img src=\"/pic1/".$img["name"]."\" width=31 height=31 class=va>&nbsp;&nbsp;".
                "<a class=price>".
                $ui->item("Price").
                ":&nbsp;<b>".
                $this->userData->formatCurrency("3_letters_with_rounded_number", $r->price).
                "&nbsp;".
                "</b>".
                "</a>".
                "</nobr></div>";

            $items[] = $item;
        }

        $szTableCell = (int)(100 / $this->fields->length());

        $ret .= "<table width=100% border=0 cellspacing=5 cellpadding=0>".
                "<tr>".
                  "<td colspan=10>".
                    "<div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div>".
                  "</td>".
                "</tr>".
                "<tr>".
                  "<td class=maintxt-vat>".
                    @join(
                            $items, "</td><td class=itemsep1-v><img src=/pic/null.gif width=1 height=1>".
                                    "</td><td class=maintxt-vat width=".$szTableCell."%>"
                          ).
                  "</td>".
                "</tr>".
                "<tr>".
                  "<td colspan=10>".
                    "<div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div>".
                  "</td>".
                "</tr>".
                "</table>".
                  "</td>".
                "</tr>";

        return $ret;
    }
}

return new CTemplate_CatalogVideoItem_ABI();

?>