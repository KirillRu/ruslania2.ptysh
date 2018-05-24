<?

require_once("templates/items_buy_button.template.php");
//CTemplate_Static_ItemsBuyButton::getText().

class CTemplate_CatalogMusicItem extends CCommonTask
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

                $ui  =& $this->ui;
                $r   =& $cat->getFields();
                $a   =& $this->argv;

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

        $ret .=
                         "</td>".
                         "<td width=100% valign=top class=maintxt>".
                         "<div class=mb5>".
                           "<a class=ctitle href=\"".$r->details_url."\" title=\"".$ui->item("ITEM_MORE_INFO")."\">".
                             $r->title. //." (CD)". // (CD) part sould not be included in titles, it added to all the titles automatically
                           "</a>".
                         "</div>".
                         "<div class=mb5>";

                if ($r->full_description != NULL)
                {
                        $ret .= $r->full_description."</div><div class=mb5>";
                }

                $was_flag = FALSE;

                if (strtolower(get_class($r->authors)) == "ccollection")
                {
                        $authors_buff = Array();
                        while($r->authors->next())
                        {
                                $ra = $r->authors->item();
                                $ra->url = 
                                             $a->getSaveResult
                                             (
                                                 $cat->url_part,
                                                 $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                                                 $a->getSaveEntry("filter_author_id", $ra->id)
                                             ).".html";

                                $authors_buff[] = "<a title=\"".
                                                  $ui->item("FILTER_MUSIC_AUTHOR").
                                                  "\" href=".
                                                  $ra->url.
                                                  " class=cprop>".
                                                  $ra->title.
                                                  "</a>";
                        }
                        $ret .= sprintf($ui->item("WRITTEN_BY"), join($authors_buff, ", ")."\n");

                        $was_flag = TRUE;
                }

                if (strtolower(get_class($r->performers)) == "ccollection")
                {
                        $perf_buff = Array();
                        while($r->performers->next())
                        {
                                $ra = $r->performers->item();
                                $ra->url = 
                                             $a->getSaveResult
                                             (
                                                 $cat->url_part,
                                                 $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                                                 $a->getSaveEntry("filter_performer_id", $ra->id)
                                             ).".html";

                                $perf_buff[] = "<a title=\"".
                                               $ui->item("FILTER_MUSIC_PERFORMER").
                                               "\" href=".
                                               $ra->url.
                                               " class=cprop>".
                                               $ra->title.
                                               "</a>";
                        }

                        if (strtolower(get_class($r->authors)) == "ccollection") $ret .= ", ";

                        $ret .= sprintf($ui->item("READ_BY"), join($perf_buff, ", ")."\n");

                        $was_flag = TRUE;
                }

                if ($was_flag) $ret .= "<br>";

                if (!empty($r->publisher_name))
                {
                        $ret .= sprintf
                                (
                                  $ui->item("PUBLISHED_BY"),
                                  "<a href=\"".$r->publisher_url.
                                  "\" title=\"".
                                  $ui->item("FILTER_MUSIC_PUBLISHER").
                                  "\" class=cprop>".
                                  $r->publisher_name.
                                  "</a> "
                                );
                }

                if (!empty($r->year))
                {
                        $x = empty($r->publisher_name);
                        $ret .= sprintf($ui->item( ($x ? "PUBLISHED_IN_YEAR" : "IN_YEAR") ), $r->year);
                        unset($x);
                }
                
                if (!empty($r->catalogue))
                {
                    $ret .= "<br>Catalogue #: ".$r->catalogue;
                    $was_flag = TRUE;
                }
                
                if (!empty($r->isbn))
                {
                    $ret .= 
                        "<br>ISBN ".
                        $r->isbn;
                }
        
                //
                // NOTE: [15.04.2006 19:37][Dain] added eancode field value in output
                //      
                if ( !empty($r->eancode) )
                {
                    $ret .= "<br>".sprintf($ui->item('MSG_ALL_EAN'), $r->eancode);
                }
                
                if (!empty($r->media_id))
                {
                        $ret .= "<br>".
                                sprintf
                                (
                                  $ui->item("MEDIA_TYPE_OF"),
                                  "<a href=\"".$r->media_url.
                                  "\" title=\"".
                                  $ui->item("FILTER_MUSIC_MEDIA_TYPE").
                                  "\" class=cprop>".
                                  $r->media_name.
                                  "</a> "
                                );
                }
                
            if (!empty($r->cds))
                {
                    $ret .= 
                        "<br>CDs: ".
                        $r->cds;
                }

                $ret .= "</div>";

                $ret .= "<img src=/pic1/bluearr1.gif width=8 height=7>&nbsp;&nbsp;".
                        $ui->item("Related categories").": ".
                        "<a ";

                if ($r->category_title)
                {
                        $ret .= "href=\"".$r->category_url."\" title=\"".$ui->item("DISPLAY_SUBCATEGORY_ITEMS")."\" class=catlist>".
                                $r->category_title;
                }
                else
                {
                        $ret .=  'class=catlist>'.
                                 $ui->item('MSG_NO_DATA');
                }

                $ret .= '</a>';

                if(!empty($r->secondary_category_id))
                {
                        $ret .= ';&nbsp;<a href="'.$r->secondary_category_url.'" title="'.
                                $ui->item('DISPLAY_SUBCATEGORY_ITEMS').
                                '" class=catlist>'.$r->secondary_category_title.'</a>';
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
                            'src="/pic1/'.$this->ui->item('MSG_BTN_CD_HEAR_IT_PICTURE').'" '.
                            'alt="'.$this->ui->item('MSG_BTN_CD_HEAR_IT').'" '.
                            'border="0">'.
                          "</a>".
                        "</div>";
        }

                $ret .= '</td>'.
                        CTemplate_Static_ItemsBuyButton::getText().
                        '</tr></table>'.
                        '</td></tr>';

                return $ret;
        }
}

return new CTemplate_CatalogMusicItem();

?>