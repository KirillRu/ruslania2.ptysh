<?

require_once("templates/items_buy_button.template.php");

class CTemplate_CatalogPrintedBrowseItems extends CCommonTask
{
    var $fields = NULL;
    
    function setData($r)
    {
        if (!is_a($r, "CCatalog"))
            trigger_error("CTemplate_CatalogPrintedBrowseItems::setData() accepts only php 'CCatalog' class as argument.", E_USER_ERROR);
        else
            $this->fields = &$r;
    }
    
    function getText()
    {
        $cat =& $this->fields;
        $i = 0;
        $ret = '';
        
        while ( $cat->moveNext() )
        {
            $r =& $cat->getFields();
            $ret .= $this->__getItemText($r, $i++ > 0); // show separator for all records except first
        }
        
        $ret .= "\n<!-- items loop !-->\n";
        
        return $ret;
    }
    
    
    function __getItemText(&$r, $need_separator)
    {
        $cat =& $this->fields;
        $ui  =& $this->ui;
        $a   =& $this->argv;
        $me  =  CATALOG_URL;
        
        $item_table = NULL;
        
        $item_table =
            "<div ".($need_separator ? "class=\"itemsep3\"" : "").">".
            "<table cellspacing=\"0\" cellpadding=\"7\" border=\"0\">".
            "<tr>".
            "<td valign=\"top\" align=\"center\">";

        if ( !empty($r->image) )
        {
            $picture_file_thumbname = "/pictures/small/".$r->image;
            $picture_file_bigname   = "/pictures/big/".$r->image;
            
            $have_picture = TRUE;
        }
        else
        {
            $have_picture = FALSE;
        }
        
        if (!$have_picture)
        {
            $item_table .= "<img src=\"/pic1/nophoto.gif\" border=0>";
        }
        else
        {
            $item_table .=
            "<a href=\"".$picture_file_bigname."\" target=_new>".
            "<img src=\"".$picture_file_thumbname."\" ".
            "alt=\"".$ui->item("ITEM_IMG_ENLARGE")."\""." border=0></a>";
        }
        
        $item_table .=
            "</td>".
            "<td width=100% valign=top class=maintxt>".
            "<div class=mb5>".
                "<a class=ctitle href=\"".$r->details_url."\" ".
                "title=\"".$ui->item("ITEM_MORE_INFO")."\">".
                $r->title.
            "</a>".
            "</div>".
            "<div class=mb5>";
        
        if ( $r->description != NULL )
        {
            $item_table .= $r->description."...".
            "<a class=catlist href=\"".$r->details_url."\">".
            "&nbsp;[".$ui->item("DESCRIPTION_MORE")."]&nbsp;".
            "</a></div><div class=mb5>";
        }
        
        if (strtolower(get_class($r->authors)) == "ccollection")
        {
            $authors_buff = Array();
            while($r->authors->next())
            {
                $ra = $r->authors->item();
                
                $ra->url = $me.
                $a->getSaveResult(
                    $cat->getUrlPart(),
                    $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                    $a->getSaveEntry("filter_author_id", $ra->id)
                    ).
                    ".html";
                
                $authors_buff[] = 
                    "<a title=\"".$ui->item("FILTER_PRINTED_AUTHOR")."\" ".
                        "href=\"".$ra->url."\" ".
                        "class=cprop>".
                        $ra->title.
                    "</a>";
            }
        $item_table .= sprintf($ui->item("WRITTEN_BY"), join($authors_buff, ", ")."<br>\n");
        }
        
        if ( !empty($r->publisher_name) )
        {
            $item_table .= sprintf(
                $ui->item("PUBLISHED_BY"),
                "<a href=\"".$r->publisher_url."\" ".
                    "title=\"".$ui->item("FILTER_PRINTED_PUBLISHER")."\" class=cprop>".
                    $r->publisher_name.
                "</a> "
                );
        }
        
        if ( !empty($r->year) )
        {
            $x = empty($r->publisher_name);
            $item_table .= sprintf(
                $ui->item( ($x ? "PUBLISHED_IN_YEAR" : "IN_YEAR") ), 
                $r->year);
            unset($x);
        }
        
        if ( !empty($r->type) )
        {
            $item_table .= '<br>'.sprintf(
                $ui->item("TYPE_IS"),
                "<a href=\"".$r->type_url."\" ".
                    "title=\"".$ui->item("FILTER_PRINTED_SERIES")."\" class=cprop>".
                //$r->type_name.
                    $r->type_name.
                "</a>"
                );
        }
        
        if ( !empty($r->size) )
        {
            $item_table .= '<br>'.sprintf(
                $ui->item("PRINTED_SIZE"),
                $r->size
                );
        }
        
        if ( !empty($r->eancode) )
        {
            $item_table .= "<br>".sprintf($ui->item('MSG_ALL_EAN'), $r->eancode);
        }

        if(!empty($r->stock_id))
        {
            $item_table .= 
                "<br>".
                "StockID: ".
                $r->stock_id;
        }

        
        $item_table .= "</div>";
        
        $item_table .= 
            "<img src=/pic1/bluearr1.gif width=8 height=7>&nbsp;&nbsp;".
            $ui->item("Related categories").": ".
            "<a href=\"".$r->category_url."\" ".
                "title=\"".
                $ui->item("DISPLAY_SUBCATEGORY_ITEMS").
                "\" class=catlist>".$r->category_title."</a>";
        
        if ( $r->secondary_category_title )
        {
            $item_table .= 
                ";&nbsp;<a href=\"".$r->secondary_category_url."\" ".
                    "title=\"".
                    $ui->item("DISPLAY_SUBCATEGORY_ITEMS").
                    "\" class=catlist>".$r->secondary_category_title."</a>";
        }
        
        if ( $r->have_lookinside )
        {
            $item_table .=
                "<div class=mt5>".
                    "<a class=\"pointerhand\" ".
                        "onclick=\"window.open('".$r->lookinside_url."', '_blank', 'height=500, width=640, status=yes, toolbar=yes, menubar=yes, location=no, scrollbars=yes, resizable=1, status=1')\"".
                    ">".
                    "<img src=\"/pic1/".$this->ui->item('MSG_BTN_LOOK_INSIDE_PICTURE')."\" ".
                    "alt=\"".$this->ui->item('MSG_BTN_LOOK_INSIDE')."\" ".
                    "border=\"0\">".
                    "</a>".
                "</div>";
        }
        
        $item_table .= 
            '</td>'.
            CTemplate_Static_ItemsBuyButton::getText().
            '</tr></table>';
        
        return $item_table;
    }

}

return new CTemplate_CatalogPrintedBrowseItems();

?>