<?

class CTemplate_PereodicsBooksItem extends CCommonTask
{
    var $fields = NULL;
    var $html = NULL;

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
        $this->html = new HTMLControlsHelper();
    }

    function getText()
    {
        $cat  =& $this->fields;
        $user =& $this->userData;
        $ui   =& $this->ui;
        $r    =& $cat->getFields();

        $user_discount = 0;
        $user_discount_affection = 0;
        if ($r->price > 0) {
            $user_discount = $user->getPersonalDiscount();
            if ($user_discount > 0)
                $user_discount_affection = (100 - $user_discount) / 100;
        }
        
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
            $ret .= "<a href=\"".$picture_file_bigname."\" target=_new>".
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

        if ($r->description != NULL)
        {
            $ret .= $r->full_description."</div><div class=mb5>";
        }

        if (!empty($r->type))
        {
            $ret.= sprintf ($ui->item("TYPE_OF"),
                   "<a href=\"".$r->filter_type_url.
                   "\" title=\"".
                   $ui->item("FILTER_PEREODICALS_TYPE").
                   "\" class=cprop>".
                   $r->type_name.
                   "</a> <br>");
        }

        if (!empty($r->issues_year))
        {
            
            $x_issues_in_year   = NULL;
            $issues_year        = NULL;
            
            $issues_year        .= $r->issues_year;
            
            if ( substr($issues_year, -1, 1) == "1" && 
                 substr($issues_year, -2) != "11" )
            {
                $x_issues_in_year = $ui->item("X_ISSUES_IN_YEAR_1");
            }
            elseif ( 
                ( substr($issues_year, -1, 1) == "2" && substr($issues_year, -2) != "12" ) || 
                ( substr($issues_year, -1, 1) == "3" && substr($issues_year, -2) != "13" ) || 
                ( substr($issues_year, -1, 1) == "4" && substr($issues_year, -2) != "14" )
            )
            {
                $x_issues_in_year = $ui->item("X_ISSUES_IN_YEAR_2");
            }
            else $x_issues_in_year = $ui->item("X_ISSUES_IN_YEAR_3");
            
            $ret .= sprintf($x_issues_in_year, $issues_year).", ";
        }

        $month  = $r->months_list->item();
        $month_ending = substr($month, -1, 1);
        
        if ( $month_ending == "1" && 
             $month != "11" )
        {
            $label_for_month = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_MONTH_1");
        }
        elseif ( 
            ($month_ending == "2" && $month != "12") || 
            $month_ending == "3" ||
            $month_ending == "4"
        )
        {
            $label_for_month = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_MONTH_2");
        }
        else $label_for_month = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_MONTH_3");

        $issues = 
            ($r->issues_year < 12) ? 
            $month / round(12 / $r->issues_year) : 
            round($r->issues_year / 12) * $month;
            
        $issues_ending = substr($issues, -1, 1);
        
        if ( $issues_ending == "1" && 
             substr($issues, -2) != "11" )
        {
            $label_for_issues = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_ISSUE_1");
        }
        elseif ( 
            ($issues_ending == "2" && substr($issues, -2) != "12") || 
            ($issues_ending == "3" && substr($issues, -2) != "13") || 
            ($issues_ending == "4" && substr($issues, -2) != "14")
        )
        {
            $label_for_issues = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_ISSUE_2");
        }
        else $label_for_issues = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_ISSUE_3");
                    
        $msg    = sprintf
               (
                 $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_TEMPLATE"),
                 $month, $label_for_month,
                 $issues, $label_for_issues
               );

        $ret .= $msg;

        if ($r->country_name != NULL)
        {
            $ret .= "<br>".sprintf($ui->item("COUNTRY_OF_ORIGIN"), $r->country_name);
        }
        
        if ($r->index != NULL)
        {
            $ret .= "<br>".sprintf($ui->item("PERIOD_INDEX"), $r->index);
        }
        
        // NOTE: [03.03.2008 17:26][lex] ISSN output added
        if (!empty($r->issn))
        {
            $ret .= "<br>"."ISBN ".$r->issn;
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

        if ($r->discount > 0)
        {
            $ret .=
              "<table cellspacing=1 cellpadding=5 border=0 class=mt5>".
              "<tr>".
                "<td class=graycell3>".
                  $ui->item("6_MONTHS_FOR_FINLAND").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_month * 6)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->discounted_price_fin_month * 6).
                "</td>".
                "<td class=graycell3>".
                  $ui->item("1_YEAR_FOR_FINLAND").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_year)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->discounted_price_fin_year).
                "</td>".
              "</tr>".
/*
              "<tr>".
                "<td class=graycell3>".
                  $ui->item("6_MONTHS_FOR_WORLD").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_world_month * 6)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->discounted_price_world_month * 6).
                "</td>".
                "<td class=graycell3>".
                  $ui->item("1_YEAR_FOR_WORLD").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_world_year)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->discounted_price_world_year).
                "</td>".
              "</tr>".
*/
              "</table>";
        }
        else if ($user_discount > 0)
        {
            $ret .=
              "<table cellspacing=1 cellpadding=5 border=0 class=mt5>".
              "<tr>".
                "<td class=graycell3>".
                  $ui->item("6_MONTHS_FOR_FINLAND").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_month * 6)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_month * $user_discount_affection * 6).
                "</td>".
                "<td class=graycell3>".
                  $ui->item("1_YEAR_FOR_FINLAND").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_year)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_year * $user_discount_affection).
                "</td>".
              "</tr>".
/*
              "<tr>".
                "<td class=graycell3>".
                  $ui->item("6_MONTHS_FOR_WORLD").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_world_month * 6)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_world_month * $user_discount_affection * 6).
                "</td>".
                "<td class=graycell3>".
                  $ui->item("1_YEAR_FOR_WORLD").
                "</td>".
                "<td class=graycell4 nowrap>".
                  "<s>".$user->formatCurrency("3_letters_with_rounded_number", $r->price_world_year)."</s><br>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_world_year * $user_discount_affection).
                "</td>".
              "</tr>".
*/
              "</table>";
        }
        else
        {
            $ret .=
              "<table cellspacing=1 cellpadding=5 border=0 class=mt5>".
              "<tr>".
                "<td class=graycell3>".
                  $ui->item("6_MONTHS_FOR_FINLAND").
                "</td>".
                "<td class=graycell4 nowrap>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_month * 6).
                "</td>".
                "<td class=graycell3>".
                  $ui->item("1_YEAR_FOR_FINLAND").
                "</td>".
                "<td class=graycell4 nowrap>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_fin_year).
                "</td>".
              "</tr>".
/*
              "<tr>".
                "<td class=graycell3>".
                  $ui->item("6_MONTHS_FOR_WORLD").
                "</td>".
                "<td class=graycell4 nowrap>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_world_month * 6).
                "</td>".
                "<td class=graycell3>".
                  $ui->item("1_YEAR_FOR_WORLD").
                "</td>".
                "<td class=graycell4 nowrap>".
                  $user->formatCurrency("3_letters_with_rounded_number", $r->price_world_year).
                "</td>".
              "</tr>".
*/
              "</table>";
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
            "<td valign=top class=maintxt align=left>";

        //
        // NOTE: generate HTML form elements begin
        //
        $oldSaveMode = $this->argv->saveMode;
        $this->argv->saveMode = INTO_NAMEVALUE_ARRAY;

        // NOTE: [22.02.2008 12:48] [lex] To show  by default price for
        //                                12 (maximum) months reversing array
        $r->months_list->reverse();
        $saveResult = $this->argv->getSaveResult
                      (
                        $this->argv->getSaveEntry("cart_add_quantity", Array($r->id => $r->months_list->item()))
                      );
        $r->months_list->reverse();

        $js_unique_name = "sp".($this->__i++);

        $selectStyle =
          "class=sort_red ".
          "style=\"margin-top: 5px\" ".
          "onchange=\"".
            "v = this.options[this.selectedIndex].value; ".
            "document.getElementById('price_".$js_unique_name."').innerHTML = ".
              "(v == 12) ".
              " ? roundToPrecision(".$r->locale_price_year.", 2) ".
              " : roundToPrecision(".$r->locale_price_month." * v, 2);";

        if ($r->discount > 0)
        {
            $selectStyle .=
              "document.getElementById('discounted_".$js_unique_name."').innerHTML = ".
                "(v == 12) ".
                " ? roundToPrecision(".$r->locale_discounted_price_year.", 2) ".
                " : roundToPrecision(".$r->locale_discounted_price_month." * v, 2);";
        }
        else if ($user_discount > 0)
        {
            $selectStyle .=
              "document.getElementById('discounted_".$js_unique_name."').innerHTML = ".
                "(v == 12) ".
                " ? roundToPrecision(".$r->locale_price_year * $user_discount_affection.", 2) ".
                " : roundToPrecision(".$r->locale_price_month * $user_discount_affection." * v, 2);";
        }

        $selectStyle .= "\"";

        $r->months_list->reset();

        $localizedMonths = new CCollection();
        while($r->months_list->next())
        {
            $month = $r->months_list->item();
            $month_ending = substr($month, -1, 1);
            
            if ( $month_ending == "1" && 
                 $month != "11" )
            {
                $label_for_month = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_MONTH_1");
            }
            elseif ( 
                ($month_ending == "2" && $month != "12") || 
                $month_ending == "3" ||
                $month_ending == "4"
            )
            {
                $label_for_month = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_MONTH_2");
            }
            else $label_for_month = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_MONTH_3");
    
            $issues = ($r->issues_year < 12) 
                        ? $month / round(12 / $r->issues_year) 
                        : round($r->issues_year / 12) * $month;

//            mydump($r->issues_year);
//            mydump(round($r->issues_year / 12));
//            mydump($issues);
                
            $issues_ending = substr($issues, -1, 1);
            
            if ( $issues_ending == "1" && 
                 $issues != "11" )
            {
                $label_for_issues = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_ISSUE_1");
            }
            elseif ( 
                ($issues_ending == "2" && substr($issues, -2) != "12") || 
                ($issues_ending == "3" && substr($issues, -2) != "13") || 
                ($issues_ending == "4" && substr($issues, -2) != "14")
            )
            {
                $label_for_issues = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_ISSUE_2");
            }
            else $label_for_issues = $ui->item("MIN_FOR_X_MONTHS_Y_ISSUES_ISSUE_3");

            $msg = $month."&nbsp;".$label_for_month; //."&nbsp;/&nbsp;".$issues."&nbsp;".$label_for_issues;

            $localizedMonths->add($month, $msg);
        }

//        mydump($localizedMonths);

        $month_select_html = $this->html->createSingle_SELECT($selectStyle, $saveResult, $localizedMonths);

        $saveResult = $this->argv->getSaveResult
                      (
                        $this->argv->getSaveEntriesFor("session", "language"),
                        $this->argv->getSaveEntry("context",           CONTEXT_PERSONAL_SHOPCART),
                        $this->argv->getSaveEntry("cart_add_entity",   Array($r->id => ENTITY_PEREODICS) )
                      );

        $form_hidden_html = $this->html->createMulitple_INPUT("type=hidden", $saveResult);

        $saveResult = $this->argv->getSaveResult
                  (
                    $this->argv->getSaveEntriesFor("session", "language"),
                    $this->argv->getSaveEntry("context",                   CONTEXT_PERSONAL_SHOPCART),
                    $this->argv->getSaveEntry("cart_add_entity",               Array($r->id => ENTITY_PEREODICS) ),
                    $this->argv->getSaveEntry("cart_add_suspended_quantity",   Array($r->id => 1) )
                  );

        $form_hidden_html_suspended = $this->html->createMulitple_INPUT("type=hidden", $saveResult);

        $this->argv->saveMode = $oldSaveMode;

        //
        // NOTE: generate HTML form elements end
        //

        if ($r->discount > 0)
        {
            //
            // NOTE: [17.05.2005 14:00][den] html fix: set default form margins for IE
            //
            $ret .=
              '<form method=get style="margin-top: 0; margin-bottom: 0;">'.
              '<div class="mb5">'.
                '<span class="price" style="font-size: 90%; color: #DD8888">'.
                  $ui->item("Price").': '.
                '</span>'.
                '<span id="price_'.$js_unique_name.'" '.
                  'class="price" style="font-weight: bold; font-size: 90%; color: #DD8888">'.
                  $user->formatCurrency("rounded_number", $r->price).
                '</span> '.
                '<span class="price" style="font-weight: bold; font-size: 90%; color: #DD8888">'.
                  $user->formatCurrency("3_letters").
                '</span>'.
              '</div>'.
              '<div>'.
                '<span class="price">'.
                  $ui->item("PRICE_DISCOUNT_FORMAT").' '.($r->discount * 100).'%: '.
                '</span>'.
                '<span id="discounted_'.$js_unique_name.'" class="price" '.
                  'style="font-weight: bold">'.
                  $user->formatCurrency("rounded_number", $r->discounted_price).
                '</span> '.
                '<span class=price style="font-weight: bold">'.
                  $user->formatCurrency("3_letters").
                '</span>'.
              '</div>';
        }
        else if ($user_discount > 0)
        {
            $ret .=
              '<form method=get style="margin-top: 0; margin-bottom: 0;">'.
              '<div class="mb5">'.
                '<span class="price" style="font-size: 90%; color: #DD8888">'.
                  $ui->item("Price").': '.
                '</span>'.
                '<span id="price_'.$js_unique_name.'" '.
                  'class="price" style="font-weight: bold; font-size: 90%; color: #DD8888">'.
                  $user->formatCurrency("rounded_number", $r->price).
                '</span> '.
                '<span class="price" style="font-weight: bold; font-size: 90%; color: #DD8888">'.
                  $user->formatCurrency("3_letters").
                '</span>'.
              '</div>'.
              '<div>'.
                '<span class="price">'.
                  sprintf($ui->item("PRICE_WITH_PERSONAL_DISCOUNT"),$user_discount).': '.
                '</span>'.
                '<span id="discounted_'.$js_unique_name.'" class="price" '.
                  'style="font-weight: bold">'.
                  $user->formatCurrency("rounded_number", $r->price * $user_discount_affection).
                '</span> '.
                '<span class=price style="font-weight: bold">'.
                  $user->formatCurrency("3_letters").
                '</span>'.
              '</div>';
        }
        else
        {
            $ret .=
              '<form method=get style="margin-top: 0; margin-bottom: 0;">'.
              '<div>'.
                '<span class="price">'.
                  $ui->item("Price").': '.
                '</span>'.
                '<span id="price_'.$js_unique_name.'" class="price" '.
                  'style="font-weight: bold">'.
                  $user->formatCurrency("rounded_number", $r->price).
                '</span> '.
                '<span class="price" style="font-weight: bold">'.
                  $user->formatCurrency("3_letters").
                '</span>'.
              '</div>';
        }

        $ret .=
          "\n".
          '<div class="maintxt" style="margin-bottom: 10px; margin-top: 5px;">'.
            $ui->item("CALC_SUSCRIPTION_PRICE").
            '<br>'.
            $month_select_html.
            $form_hidden_html.
          '</div>';

        $ret .=
          '<div class="mb5">'.
            '<input '.
              'type="image" '.
              'alt="'.$ui->item('ADD_TO_BASKET_ALT').'" '.
              'src="/pic1/'.$ui->item("ADD_TO_BASKET_PICTURE").'">'.
          '</div>'.
          '</form>'.
          '<form method="get" style="margin-top: 0; margin-bottom: 0;">'.
            $form_hidden_html_suspended.
            '<input '.
              'type="image" '.
              'alt="'.$ui->item("BTN_SHOPCART_ADD_SUSPEND_ALT").'" '.
              'src="/pic1/'.$ui->item("BTN_SHOPCART_ADD_SUSPEND_PICTURE").'">'.
          '</form>'.
          //
          // NOTE: [05.02.2004 13:57][den] html fix: null.gif width must be equal to widest button
          //
          '<br><img src=/pic/null.gif width=180 height=1 border=0>';

        $ret .= "</td></tr></table>\n<!-- items loop !-->\n";

        return $ret;
    }
}

return new CTemplate_PereodicsBooksItem();

?>