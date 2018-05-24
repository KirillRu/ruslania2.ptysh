<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentNordea extends CCommonTask
{
        var $__cat = NULL;
        var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

        function CTemplate_PaymentNordea() {}

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
                $price = $cat->getOrderPrice();
                $orderPrice = number_format($price, 2, ',', '');
                $orderInvoice = $cat->getOrderInvoiceReferenceNumber();
                                
                list($usec, $sec) = explode(" ",microtime()); 
                $orderStamp = $sec.str_replace(".", "", $usec);
                
                $paymentAccepted = CATALOG_HTTPS_URL.$var->getSaveResult
                                   (
                                        $var->getSaveEntriesFor("session", "language"),
                                        $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_ACCEPTED),
                                        $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_NORDEA),
                                        $var->getSaveEntry("order_reference_number", $orderInvoice)
                                   ).".html";
                
                $paymentDeclined = CATALOG_HTTPS_URL.$var->getSaveResult
                                   (
                                         $var->getSaveEntriesFor("session", "language"),
                                         $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_DECLINED)
                                   ).".html";
                
                //
                // WARNING: [07.01.2004 17:03][den] may be, it is not the correct order description
                //
                $orderDescription = "Ruslania Books Oy internet shop order No.".$orderNumber.", ".$orderPrice." EUR";
                
                $orderMacChecksum = "0003"."&".                               // 'SOLOPMT_VERSION'      AN 4
                                    $orderStamp."&".                          // 'SOLOPMT_STAMP'        N 20
                                    PAYMENT_NORDEA_RCV_ID."&".                // 'SOLOPMT_RCV_ID'       AN 15
                                    $orderPrice."&".                          // 'SOLOPMT_AMOUNT'       AN 19
                                    $orderInvoice."&".                        // 'SOLOPMT_REF'          AN 20
                                    "EXPRESS"."&".                            // 'SOLOPMT_DATE'         AN 10
                                    "EUR"."&".                                // 'SOLOPMT_CUR'          A 3
                                    PAYMENT_NORDEA_RCV_MAC."&";               // 'Service Provider's MAC'   
                
                $orderMacChecksum = strtoupper(md5($orderMacChecksum));

                $lng = NULL;
                
                switch($var->data->item("language"))
                {
                        case LANGUAGE_FINNISH:
                                $lng = "1"; // FI
                                break;
                        default:
                                $lng = "3"; // EN
                }
                
                $ret = $ui->item('MSG_PERSONAL_PAYMENT_NORDEA_COMMENTS').
                       '<form ';
        
        if ($this->__nw)
            $ret .= 'target=_new ';
        
        $ret .= 'method="post" action="'.PAYMENT_NORDEA_URL.'">'.
                         '<input name="SOLOPMT_VERSION" type="hidden" value="0003">'.
                         '<input name="SOLOPMT_STAMP" type="hidden" value="'.$orderStamp.'">'.
                         '<input name="SOLOPMT_RCV_ID" type="hidden" value="'.PAYMENT_NORDEA_RCV_ID.'">'.
                         '<input name="SOLOPMT_RCV_ACCOUNT" type="hidden" value="'.PAYMENT_NORDEA_RCV_ACCOUNT.'">'.
                         '<input name="SOLOPMT_LANGUAGE" type="hidden" value="'.$lng.'">'.
                         '<input name="SOLOPMT_AMOUNT" type="hidden" value="'.$orderPrice.'">'.
                         '<input name="SOLOPMT_REF" type="hidden" value="'.$orderInvoice.'">'.
                         '<input name="SOLOPMT_DATE" type="hidden" value="EXPRESS">'.
                         '<input name="SOLOPMT_MSG" type="hidden" value="'.$orderDescription.'">'.
                         '<input name="SOLOPMT_RETURN" type="hidden" value="'.$paymentAccepted.'">'.
                         '<input name="SOLOPMT_CANCEL" type="hidden" value="'.$paymentDeclined.'">'.
                         '<input name="SOLOPMT_REJECT" type="hidden" value="'.$paymentDeclined.'">'.
                         '<input name="SOLOPMT_MAC" type="hidden" value="'.$orderMacChecksum.'">'.
                         '<input name="SOLOPMT_CONFIRM" type="hidden" value="YES">'.
                         '<input name="SOLOPMT_KEYVERS" type="hidden" value="'.PAYMENT_NORDEA_RCV_MAC_VERSION.'">'.
                         '<input name="SOLOPMT_CUR" type="hidden" value="EUR">'.
                         '<input class=sort type=submit value="'.$ui->item('ORDER_BTN_PAY_NORDEA').'">'.
                       '</form>';

                return $ret;
        }
}

return new CTemplate_PaymentNordea();

?>