<?
//
// NOTE: used from book detailed view
// NOTE: "ABI" in class name means "Also Buy Item"
//
class CTemplate_CatalogBooksItem_ABI extends CCommonTask
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

        if ($this->fields->length() <= 0) return NULL;

        $ret = "<tr><td class=maintxt>";

        while($this->fields->next())
        {
            $r = $this->fields->item();

            /*
            $ret .= "<a target=_blank ".
            "onmouseover=\"document.c".$this->i.".src='pic1/nwo.gif'\" ".
            "onmouseout=\"document.c".$this->i.".src='pic1/nw.gif'\" ".
            "href=\"".$r->details_url."\"><img ".
            "alt=\"".$ui->item("A_ALT_NEW_WINDOW")."\" ".
            "name=c".($this->i++)." src=pic1/nw.gif ".
            "width=16 height=9 border=0></a>";
            */

            $item = "<a class=ctitle1 title=\"".$ui->item("ITEM_MORE_INFO")."\" ".
                    "href=\"".$r->details_url."\">".
                      $r->title."</a>".
                    "<br>";

            /*
            if (get_class($r->authors) == "ccollection")
            {
                $buff = Array();
                while($r->authors->next())
                {
                    $ra = $r->authors->item();
                    $buff[] = "<a title=\"".
                          $ui->item("SEARCHFOR_AUTHOR_IN_BOOKS").
                          "\" href=".
                          $ra->url.
                          " class=cprop>".
                          $ra->title.
                          "</a>";
                }

                $item .= "<div class=mt5>".sprintf($ui->item("WRITTEN_BY"), join($buff, ", ")."</div>\n");
            }
            */
                    
            $img = CEntityCatalog::getEntityImage($r->entity);
            
            $item .= 
                "<div><nobr>".
                "<img src=\"/pic1/".$img["name"]."\" width=31 height=31 class=va>&nbsp;&nbsp;".
                "<a class=price>".
                $ui->item("Price").
                ":&nbsp;<b>".
                sprintf ($ui->item("PRICE_FORMAT"), $r->price).
                "&nbsp;".
                "</b></a>".
                "</div>";

            $items[] = $item;
        }

        $szTableCell = (int)(100 / $this->fields->length());

        $ret .= "<table border=0 cellspacing=5 cellpadding=0>".
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

return new CTemplate_CatalogBooksItem_ABI;

?>