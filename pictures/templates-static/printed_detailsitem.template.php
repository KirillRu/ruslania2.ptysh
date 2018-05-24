<?

require_once("templates/items_buy_button.template.php");

class CTemplate_CatalogPrintedItem extends CCommonTask
{
    var $fields = NULL;

    function setData(&$r)
    {
        if (!is_a($r, "CCatalog"))
        {
            trigger_error("CTemplate::setData() accepts only php 'CCatalog' class as argument.", E_USER_ERROR);
        }
        else
        {
            $this->fields = &$r;
        }
        $this->fields = &$r;
    }

    function getText()
    {
        $cat =& $this->fields;
        $a   =& $this->argv;

        $ui  =& $this->ui;
        $r   =& $cat->getFields();

        $ret = "\n<!-- items loop !-->\n".
               "<tr><td>".
               "<table width=100% cellspacing=0 cellpadding=7 border=0>".
               "<tr>".
                 "<td valign=top align=center>";

        if (!empty($r->image))
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
                $ret .= "<img src=\"/pic1/nophoto.gif\" border=0>";
        }
        else
        {
                $ret .=
                        "<a href=\"".$picture_file_bigname."\" target=_new>".
                        "<img src=\"".$picture_file_thumbname."\" ".
                        "alt=\"".$ui->item("ITEM_IMG_ENLARGE")."\""." border=0></a>";
        }

        $ret .= "</td>".
            "<td width=100% valign=top class=maintxt>".
              "<div class=mb5>".
                "<a class=ctitle>".
                $r->title.
                "</a>".
              "</div>".
              "<div class=mb5>";

        if ($r->full_description != NULL)
        {
            $ret .= $r->full_description."</div><div class=mb5>";
        }

        if (strtolower(get_class($r->authors)) == "ccollection")
        {
            $buff = Array();
            while($r->authors->next())
            {
                $ra = $r->authors->item();

                $ra->url = 
                    CATALOG_URL.
                    $a->getSaveResult(
                        $cat->url_part,
                        $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                        $a->getSaveEntry("filter_author_id", $ra->id)
                    ).".html";

                $buff[] = "<a title=\"".
                      $ui->item("FILTER_PRINTED_AUTHOR").
                      "\" href=".
                      $ra->url.
                      " class=cprop>".
                      $ra->title.
                      "</a>";
            }

            $ret .= sprintf($ui->item("WRITTEN_BY"), join($buff, ", ")."<br>\n");
        }

        if (!empty($r->publisher_name))
        {
            $ret .= sprintf ($ui->item("PUBLISHED_BY"),
                         "<a href=\"".$r->publisher_url.
                         "\" title=\"".
                         $ui->item("FILTER_PRINTED_PUBLISHER").
                         "\" class=cprop>".
                         $r->publisher_name.
                         "</a> ");
        }

        if (!empty($r->year))
        {
            $x = empty($r->publisher_name);
            $ret .= sprintf($ui->item( ($x ? "PUBLISHED_IN_YEAR" : "IN_YEAR") ), $r->year);
            unset($x);
        }

        if (!empty($r->type))
        {
            $ret .= '<br>'.sprintf (
                    $ui->item("TYPE_IS"),
                            "<a href=\"".$r->type_url.
                            "\" title=\"".
                            $ui->item("FILTER_PRINTED_SERIES").
                            "\" class=cprop>".
                            $r->type_name.
                            "</a>"
                            );
        }
        
        if ( !empty($r->size) )
        {
            $ret .= '<br>'.sprintf($ui->item("PRINTED_SIZE"),
                                   $r->size);
        }

        $ret .= "</div>";

        $ret .= "<img src=/pic1/bluearr1.gif width=8 height=7>&nbsp;&nbsp;".
                $ui->item("Related categories").": ".
                "<a href=\"".$r->category_url."\" title=\"".
                $ui->item("DISPLAY_SUBCATEGORY_ITEMS").
                "\" class=catlist>".$r->category_title."</a>";

        if(!empty($r->secondary_category_id))
        {
            $ret .= ";&nbsp;<a href=\"".$r->secondary_category_url."\" title=\"".
                $ui->item("DISPLAY_SUBCATEGORY_ITEMS").
                "\" class=catlist>".$r->secondary_category_title."</a>";
        }

        if (!empty($r->stock_id))
        {
            $ret .= "<div class=mt5 style=\"font-weight: bold\">#".
                    $r->stock_id.
                    "</div>";
        }

        if ($r->have_lookinside)
        {
            $ret .=
                        '<div class=mt5>'.
                          '<a class="pointerhand" '.
                          'onclick="window.open(\''.$r->lookinside_url.'\', \'_blank\', \'height=500, width=640, status=yes, toolbar=yes, menubar=yes, location=no, scrollbars=yes, resizable=1, status=1\')"'.
                          '>'.
                          '<img '.
                            'src="/pic1/'.$this->ui->item('MSG_BTN_LOOK_INSIDE_PICTURE').'" '.
                            'alt="'.$this->ui->item('MSG_BTN_LOOK_INSIDE').'" '.
                            'border="0">'.
                          "</a>".
                        "</div>";
        }

        $ret .= "</td>".
                CTemplate_Static_ItemsBuyButton::getText().
                "</tr>".
            "</table>".
            "</td></tr>";

        $ret .= "\n<!-- items loop !-->\n";

        return $ret;
    }
}

return new CTemplate_CatalogPrintedItem();

?>