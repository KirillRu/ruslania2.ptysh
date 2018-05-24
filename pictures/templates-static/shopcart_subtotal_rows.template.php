<?
//
// NOTE: used from shopcart and order details, hides
//       subtotal price message construction, 
//       discount message construction,
//       minimum order price message construction
//
class CTemplate_ShopcartSubtotalRows extends CCommonTask
{
    var $shopcart = NULL;

    function setData(&$r)
    {
        $this->shopcart = &$r;
    }

    /**
     *  @returns object for html template usage
     *           {
     *             string subtotal_name, 
     *             string subtotal_value, 
     *             bool have_discount
     *             string discount_name, 
     *             string discount_value, 
     *           }
     */
    function getFormattedData()
    {
        $ui =& $this->ui;
        $user =& $this->userData;
        $cat =& $this->shopcart;

        $ret = new StdClass();

        $user_discount = $user->getPersonalDiscount();
        $season_discount = $cat->getSeasonDiscount();

        $ret->subtotal_name = "";
        $ret->subtotal_value = "";
        $ret->have_discount = false;
        $ret->discount_name = "";
        $ret->discount_value = "";
        
        $ret->subtotal_name = $ui->item("CART_COL_TOTAL_PRICE").":";
        $ret->subtotal_value = $user->formatCurrency(
            "3_letters_with_rounded_number", 
            $cat->getTotalPriceWithoutDiscount() );
             
        if ($user_discount > 0 || $season_discount > 0)
        {
            if ($user_discount > 0)
            {
                $ret->discount_name .= sprintf(
                    $ui->item("CART_COL_PRICE_WITH_DISCOUNT"),
                    $user_discount);
                    
                if ($season_discount > 0) 
                    $ret->discount_name .= ", ";
            }

            if ($season_discount > 0)
            {
                $season_discount_info = $cat->getSeasonDiscountInfo();
                $format = $ui->item("CART_COL_PRICE_WITH_SEASON_DISCOUNT");
                if ($user_discount > 0)
                {
                    $format{0} = strtolower($format{0});
                }
                
                $ret->discount_name .= sprintf(
                    $format,                        
                    (int)$season_discount_info->discount,
                    $season_discount_info->title );
            }
            
            $ret->discount_name .= ":";
                     
            if ( $cat->getTotalPriceEx() < $user->getCurrencyMinimumOrderSumm() && 
                 $cat->getTotalPriceEx() > 0 )
            {
                    $ret->discount_name .= 
                        '<div style="font-weight:regular; color:#999999">('.
                         sprintf(
                             $ui->item('MSG_ORDER_MIN_SUMM'), 
                             $user->formatCurrency(
                                 "3_letters_with_rounded_number",
                                 $user->getCurrencyMinimumOrderSumm()
                                 )
                             ).
                         ')</div>';
            }

            $ret->discount_value = $user->formatCurrency(
                 "3_letters_with_rounded_number", 
                 $cat->getTotalPrice()
                 );

            $ret->have_discount = true;
        }
        else 
        {
                     
            if ( ($cat->getTotalPriceWithoutDiscountEx() < $user->getCurrencyMinimumOrderSumm()) && 
                 $cat->getTotalPriceWithoutDiscountEx() > 0 )
            {
                $ret->subtotal_name .=
                    '<div style="font-weight:regular;color: #999999">('.
                    sprintf(
                        $ui->item('MSG_ORDER_MIN_SUMM'), 
                        $user->formatCurrency(
                            "3_letters_with_rounded_number",
                            $user->getCurrencyMinimumOrderSumm()
                            )
                        );
            }
        }
        return $ret;
    }
}

return new CTemplate_ShopcartSubtotalRows;

?>