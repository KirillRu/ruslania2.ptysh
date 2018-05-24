<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentLuottokunta extends CCommonTask
{
    var $__cat = NULL;
    var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentLuottokunta() {}

    function setData(&$r)
    {
        $this->__cat =& $r;
    }

    function getText()
    {
        $ui =& $this->ui;
        $var =& $this->argv;
        $cat =& $this->__cat;

        $orderNumber = $cat->getOrderId();

        $paymentAccepted =
            CATALOG_URL.$var->getSaveResult
            (
                $var->getSaveEntriesFor("session", "language"),
                $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_ACCEPTED),
                $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_LUOTTOKUNTA),
                $var->getSaveEntry("order_reference_number", $orderNumber)
            ).".html";

        $paymentDeclined =
            CATALOG_URL.$var->getSaveResult
            (
                $var->getSaveEntriesFor("session", "language"),
                $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_DECLINED),
                $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_LUOTTOKUNTA),
                $var->getSaveEntry("order_reference_number", $orderNumber)
            ).".html";

        $paymentCanceled =
            CATALOG_URL.$var->getSaveResult
            (
                $var->getSaveEntriesFor("session", "language"),
                $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_DECLINED),
                $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_LUOTTOKUNTA),
                $var->getSaveEntry("order_reference_number", $orderNumber)
            ).".html";

        $price = $cat->getOrderPrice();

        $formOrderPrice = number_format($price * 100 , 0, '', '');
        $orderPrice = number_format($price, 2, '.', '');
        //
        // WARNING: [07.01.2004 17:03][den] may be, it is not the correct order description
        //
        $orderDescription = "Ruslania Books Oy internet shop order No.".$orderNumber.", ".$orderPrice." EUR";

        //                
        // NOTE: [2007-06-28][den] new version of Luottokunta POS-interface (spec. "HTML Form Inteface ver.1.0")
        //
        // "Authentication_Mac is calculated from the following parameter values: 
        // Merchant_Number, Order_ID, Amount, Transaction_Type and the secret key 
        // provided by Luottokunta to the merchant."
        $orderMacChecksum =
              PAYMENT_LUOTTOKUNTA_MERCHANT_NUMBER.
              $orderNumber.
              $formOrderPrice.
              "1". // Transaction_Type
              PAYMENT_LUOTTOKUNTA_MAC;

        $orderMac2 = PAYMENT_LUOTTOKUNTA_MERCHANT_NUMBER.'&'
                   .$orderNumber.'&'
                   .$formOrderPrice.'&'
                   .'978&' // Currency_Code
                   .'1&' // Transaction_Type 
                   .PAYMENT_LUOTTOKUNTA_MAC;

        $orderMac2 = strtoupper(hash('sha256', $orderMac2));
        
        $orderMacChecksum = strtoupper(md5($orderMacChecksum));

//        mydump($orderMac2);
        
        $lng = NULL;
        
        switch($var->data->item("language"))
        {
            case LANGUAGE_FINNISH:
                $lng = "FI";
                break;
            default:
                $lng = "EN";
        }
        
        $ret = $ui->item('MSG_PERSONAL_PAYMENT_LUOTTOKUNTA_COMMENTS').
               '<form ';

        if ($this->__nw)
            $ret .= 'target=_new ';
            
        //                
        // NOTE: [2007-06-28][den] new version of Luottokunta POS-interface (spec. "HTML Form Inteface ver.1.0")
        //
        $ret .= 'method="post" action="'.PAYMENT_LUOTTOKUNTA_URL.'">'.
                '<input name="Merchant_Number" type="hidden" value="'.PAYMENT_LUOTTOKUNTA_MERCHANT_NUMBER.'">'.
                '<input name="Card_Details_Transmit" type="hidden" value="0">'.
                '<input name="Language" type="hidden" value="'.$lng.'">'.
                '<input name="Device_Category" type="hidden" value="1">'.
                '<input name="Order_ID" type="hidden" value="'.$orderNumber.'">'. 
                '<input name="Amount" type="hidden" value="'.$formOrderPrice.'">'.
                '<input name="Currency_Code" type="hidden" value="978">'.
                '<input name="Order_Description" type="hidden" value="'.$orderDescription.'">'.
                '<input name="Success_Url" type="hidden" value="'.$paymentAccepted.'">'.
                '<input name="Failure_Url" type="hidden" value="'.$paymentDeclined.'">'.
                '<input name="Cancel_Url" type="hidden" value="'.$paymentCanceled.'">'.
                '<input name="Transaction_Type" type="hidden" value="1">'.
                '<input name="Authentication_Mac" type="hidden" value="'.$orderMac2.'">'.
                '<input class=sort type=submit value="'.$ui->item('ORDER_BTN_PAY_LUOTTOKUNTA').'">'.
               '</form>';
               
            return $ret;
        }
}

return new CTemplate_PaymentLuottokunta();

?>