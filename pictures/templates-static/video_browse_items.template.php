<?

require_once("templates/items_buy_button.template.php");

class CTemplate_CatalogVideoBrowseItems extends CCommonTask
{
    var $fields = NULL;

    function setData(&$r)
    {
        if (!is_a($r, "CCatalog"))
            trigger_error("CTemplate_CatalogSoftBrowseItems::setData() accepts only php 'CCatalog' class as argument.", E_USER_ERROR);
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
                        "<a class=ctitle href=\"".$r->details_url."\" title=\"".$ui->item("ITEM_MORE_INFO")."\">".
                        $r->title." (DVD)". // (DVD) part sould not be included in titles, it added to all the titles automatically
                        "</a>".
                    "</div>".
                    "<div class=mb5>";
        if ($r->description != NULL)
        {
            $item_table .= 
                $r->description."...".
                    "<a class=catlist href=\"".$r->details_url."\">".
                    "&nbsp;[".$ui->item("DESCRIPTION_MORE")."]&nbsp;".
                    "</a></div><div class=mb5>";
        }

        $was_flag = FALSE;

        if (strtolower(get_class($r->directors)) == "ccollection")
        {
            $directors_buff = Array();

            while($r->directors->next())
            {
                $ra = $r->directors->item();
                $ra->url = 
                    CATALOG_URL.
                    $a->getSaveResult
                    (
                        $cat->getUrlPart(),
                        $a->getSaveEntry("context", CONTEXT_CATALOG_FILTER),
                        $a->getSaveEntry("filter_director_id", $ra->id)
                    ).".html";
    
                $directors_buff[] = 
                    "<a title=\"".
                    $ui->item("FILTER_VIDEO_DIRECTOR").
                    "\" href=".
                    $ra->url.
                    " class=cprop>".
                    $ra->title.
                    "</a>";
            }
            $item_table .= sprintf($ui->item("DIRECTOR_IS"), join($directors_buff, ", ")."\n");
            $was_flag = TRUE;
        }

        if (strtolower(get_class($r->producers)) == "ccollection")
        {
            $prod_buff = Array();
            while($r->producers->next())
            {
                $ra = $r->producers->item();
                $ra->url = CATALOG_URL.
                    $a->getSaveResult
                    (
                        $cat->url_part,
                        $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                        $a->getSaveEntry("filter_producer_id", $ra->id)
                    ).".html";
    
                $prod_buff[] = "<a title=\"".
                    $ui->item("FILTER_VIDEO_PRODUCER").
                    "\" href=".
                    $ra->url.
                    " class=cprop>".
                    $ra->title.
                    "</a>";
            }
    
            if ($was_flag) $item_table .= "<br>";
            $item_table .= sprintf($ui->item("PRODUCED_BY"), join($prod_buff, ", ")."\n");
    
            $was_flag = TRUE;
        }
    
        if (strtolower(get_class($r->actors)) == "ccollection")
        {
            $actors_buff = Array();
    
            while($r->actors->next())
            {
                $ra = $r->actors->item();
                $ra->url = CATALOG_URL.
                    $a->getSaveResult
                    (
                        $cat->url_part,
                        $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                        $a->getSaveEntry("filter_actor_id", $ra->id)
                    ).".html";
    
                $actors_buff[] = "<a title=\"".
                    $ui->item("FILTER_VIDEO_ACTORS").
                    "\" href=".
                    $ra->url.
                    " class=cprop>".
                    $ra->title.
                    "</a>";
            }
    
            if ($was_flag) $item_table .= "<br>";
            $item_table .= sprintf($ui->item("VIDEO_ACTOR_IS"), join($actors_buff, ", ")."\n");
    
            $was_flag = TRUE;
        }
        
        if (strtolower(get_class($r->credits)) == "ccollection")
        {
            $credits_buff = Array();
    
            while($r->credits->next())
            {
                $ra = $r->credits->item();
                $ra->url = CATALOG_URL.
                    $a->getSaveResult
                    (
                        $cat->url_part,
                        $a->getSaveEntry("context",          CONTEXT_CATALOG_FILTER),
                        $a->getSaveEntry("filter_credits_id", $ra->id)
                    ).".html";
    
                $credits_buff[] = "<a title=\"".
                    $ui->item("FILTER_VIDEO_CREDITS").
                    "\" href=".
                    $ra->url.
                    " class=cprop>".
                    $ra->title.
                    "</a>";
            }
    
            if ($was_flag) $item_table .= "<br>";
            $item_table .= sprintf($ui->item("VIDEO_CREDITS_IS"), join($credits_buff, ", ")."\n");
    
            $was_flag = TRUE;
        }
        
        if ($was_flag) $item_table .= "<br>";
    
        if (!empty($r->year))
        {
            $item_table .= 
                sprintf($ui->item("VIDEO_PUBLISHED_IN_YEAR"), $r->year);
            unset($x);
        }
        
        //Added [15/04/2006 18:07] [Dain] vet_control_number output if current lang is finnish
        //
        //Removed [07.08.2008 18:30] [lex] not needed anymore
        //
        //if ( !empty($r->vet_control_number) && 
        //     LANGUAGE_FINNISH == $this->argv->data->item("language") )
        //{
        //  $item_table .= "<br>".
        //        sprintf($ui->item("MSG_VIDEO_VET_CONTROL_NUMBER"), $r->vet_control_number);
        //}
    
        //
        // NOTE: [29.05.2006 14:04][Dain] added eancode field value in output
        //      
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

        
        if (!empty($r->media_id))
        {
            $item_table .= "<br>".sprintf (
                $ui->item("MEDIA_TYPE_OF"),
                "<a href=\"".$r->media_url.
                "\" title=\"".
                $ui->item("FILTER_VIDEO_MEDIA").
                "\" class=cprop>".
                $r->media_name.
                "</a>"
                );
            
            //NOTE [15:54 07.04.2008][lex] Zone info added
            if (!empty($r->zone_id))
            {
                $item_table .= ", ".sprintf
                (
                    $ui->item("VIDEO_ZONE"),
                    "<a href=\"".$r->zone_url.
                    "\" title=\"".
                    $ui->item("FILTER_VIDEO_ZONE").
                    "\" class=cprop>".
                    $r->zone.
                    "</a> ".
                    "<a class=\"pointerhand\" ".
                    "onclick=\"window.open('".$r->zone_info_url."', ".
                        "'_blank', '".
                        "height=550, ".
                        "width=640, ".
                        "status=yes, ".
                        "toolbar=yes, ".
                        "menubar=yes, ".
                        "location=no, ".
                        "scrollbars=yes, ".
                        "resizable=1, ".
                        "status=1')\"".
                    ">".
                        "<img src=\"/pic1/q1.gif\"".
                        " width=\"16px\" height=\"16px\"".
                        " title=\"".$ui->item("MSG_SHOW_ZONE_INFO")."\"".
                        " style=\"position:relative;top:4px;left:10px;\"/>".
                    "</a>"
                );
            }
        }
        
        if ( !empty($r->dvds) )
        {
            $item_table .= "<br>DVDs:".$r->dvds;
        }

        if (!empty($r->age_limit_flag) && $a->data->item("language") == LANGUAGE_FINNISH)
        {
            $ret = "<br/>";

            $flag = $r->age_limit_flag;

            if(($flag & 1) == 1) $ret .= '<img src="/pic1/fi-sallittu.png" width="32" height="32" alt="Sallittu" title="Sallittu" /> ';
            if(($flag & 2) == 2) $ret .= '<img src="/pic1/fi-7.png" width="32" height="32"  alt="K-7" title="K-7"/> ';
            if(($flag & 4) == 4) $ret .= '<img src="/pic1/fi-12.png" width="32" height="32"  alt="K-12" title="K-12"/> ';
            if(($flag & 8) == 8) $ret .= '<img src="/pic1/fi-16.png" width="32" height="32"  alt="K-16" title="K-16"/> ';
            if(($flag & 16) == 16) $ret .= '<img src="/pic1/fi-18.png" width="32" height="32" alt="K-18" title="K-18" /> ';
            if(($flag & 32) == 32) $ret .= '<img src="/pic1/fi-ahdistus.png" width="32" height="32" alt="Ahdistus" title="Ahdistus" /> ';
            if(($flag & 64) == 64) $ret .= '<img src="/pic1/fi-paihteet.png" width="32" height="32" alt="P&auml;ihteet" title="P&auml;ihteet" /> ';
            if(($flag & 128) == 128) $ret .= '<img src="/pic1/fi-seksi.png" width="32" height="32" alt="Seksi" title="Seksi"/> ';
            if(($flag & 256) == 256) $ret .= '<img src="/pic1/fi-vakivalta.png" width="32" height="32" alt="Vakivalta" title="Vakivalta"/> ';

            $ret .= "<br/>";

            $item_table .= $ret;
            unset($ret);
        }



        if($a->data->item("language") == LANGUAGE_FINNISH && $r->agelimit == 12)
        {
            $item_table .= '<br/>Vapautettu luokittelusta<br/>';
        }
    
        $item_table .= "</div>";
    
        $item_table .= "<img src=/pic1/bluearr1.gif width=8 height=7>&nbsp;&nbsp;".
            $ui->item("Related categories_T1").": ".
            "<a ";
    
        if ($r->category_title)
        {
            $item_table .= "href=\"".$r->category_url."\" title=\"".
                $ui->item("DISPLAY_SUBCATEGORY_ITEMS").
                "\" class=catlist>".
                $r->category_title;
        }
        else
        {
            $item_table .=  "class=catlist>".
                $ui->item("MSG_NO_DATA");
        }
    
        $item_table .= "</a>";
    
        if(!empty($r->secondary_category_id))
        {
            $item_table .= ";&nbsp;<a href=\"".$r->secondary_category_url."\" title=\"".
                $ui->item("DISPLAY_SUBCATEGORY_ITEMS").
                "\" class=catlist>".$r->secondary_category_title."</a>";
        }
    
        if ($r->have_lookinside)
        {
            $item_table .= 
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
    
        $item_table .= '</td>'.
            CTemplate_Static_ItemsBuyButton::getText().
            '</tr></table>';
    
        return $item_table;
    }
}

return new CTemplate_CatalogVideoBrowseItems();

?>