<?
// NOTE: 
//
// Special template for use from other .template.php files.
//
// Method ::getText() is called statically from CCommonTask-derived parent.
//
// This template can not be created from CDynamicTemplateFactory, and should
// be used only when one needs to make a template of some presentation part,
// located in several .template.php files.
//
class CTemplate_Static_ItemsBuyButton
{
    function setData(&$data) {}

    // called staticall from CCommonTask-derived parent
    function getText()
    {
        $ui   =& $this->ui;
        $user =& $this->userData;
        $a    =& $this->argv;
        $r    =  $this->fields->getFields();

        $ret = "<td valign=top class=maintxt>";
        
        if ($r->in_stock > 0 || $r->in_shop > 0) // NOTE: [20.08.2007 16:42][lex] in_shop parameter added
        {
                $html_buy_button = '<img border=0 src="/pic1/'.$ui->item("ADD_TO_BASKET_PICTURE").
                                   '" alt="'.$ui->item("ADD_TO_BASKET_ALT").'">';
        }
        else
        {
                $html_buy_button = '<img border=0 src="/pic1/'.$ui->item("BTN_SHOPCART_LEAVE_ORDER_PICTURE").
                                   '" alt="'.$ui->item("BTN_SHOPCART_LEAVE_ORDER_ALT").'">';
        }

        $html_add_int_button = '<img border=0 src="/pic1/'.$ui->item("BTN_SHOPCART_ADD_SUSPEND_PICTURE").
                               '" alt="'.$ui->item("BTN_SHOPCART_ADD_SUSPEND_ALT").'">';

        $msg =  CDynamicTemplateFactory::createGetText(
                            DYNAMIC_TEMPLATE_FOR_ITEM_AVAILABILITY_TEXT, $r);
        
        $html_buy_text = sprintf($ui->item("ITEM_AVAIBILITY"), $msg);

        $html_buttons = '<div class="mb5">'.
                        '<a href="'.$r->buy_url.'">'.
                        $html_buy_button.
                        '</a></div>'.
                            '<a href="'.$r->buy_suspend_url.'">'.
                        $html_add_int_button.
                        '</a>';

        //
        // NOTE [13.08.2008 12:00][lex] do not show the price for items that are not in stock and don't have stock_id
        //



        if ($r->in_stock > 0 || $r->in_shop > 0 || $r->stock_id) 
        {
            if ($r->discount > 0 && $r->price > 0 && $r->discount != $r->price) // poslednee uslovie esli skidka == zene
            {
                $discount = (int) round( (1 - ($r->discount / $r->price)) * 100);
    
                $ret .= '<div class=mb5><a class=price style="font-size: 90%; color: #DD8888">'.
                        $ui->item("Price").
                        ':&nbsp;'.
                        $user->formatCurrency("3_letters_with_rounded_number", $r->price).
                        '</a></div>'.
                        '<div class=mb5><a class=price>'.
                        $ui->item("PRICE_DISCOUNT_FORMAT").
                        ' '.$discount.'%:&nbsp;<b>'.
                        $user->formatCurrency("3_letters_with_rounded_number", $r->discount).
                        '</b></a></div>';
            }
            else if(($discount = $user->getPersonalDiscount()) > 0 && $r->price > 0)
            {
                $price_with_discount = (100 - $discount) * $r->price / 100;
                
                $ret .= '<div class=mb5><a class=price style="font-size: 90%; color: #DD8888">'.
                        $ui->item("Price").
                        ':&nbsp;'.
                        $user->formatCurrency("3_letters_with_rounded_number", $r->price).
                        '</a></div>'.
                        '<div class=mb5><a class=price>'.
                        sprintf($ui->item("PRICE_WITH_PERSONAL_DISCOUNT"),$discount).
                        ':&nbsp;<b>'.
                        $user->formatCurrency("3_letters_with_rounded_number", $price_with_discount).
                        '</b></a></div>';
            }
            else
            {
                $ret .= '<div class=mb5><a class=price>'.
                        $ui->item("Price").
                        ':&nbsp;<b>'.
                        $user->formatCurrency("3_letters_with_rounded_number", $r->price).
                        '</b></a></div>';
            }
        }

        $ret .=
            '<div class="mb5" style="color:#0A6C9D">'.
            $html_buy_text.
            '</div>'.
            $html_buttons.
            //
            // NOTE: [05.02.2004 13:57][den] html fix: null.gif width must be equal to widest button
            //
            '<br><img src=/pic/null.gif width=180 height=1 border=0>'.
            '</td>';

        return $ret;
    }
}

?>