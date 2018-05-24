<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentSampo extends CCommonTask
{
    var $__cat = NULL;
        var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentSampo() {}

    function setData(&$r)
    {
        $this->__cat =& $r;
    }

    function getText()
    {
        $ui =& $this->ui;
        $var =& $this->argv;
        $cat =& $this->__cat;
        
        $html = new HTMLControlsHelper();

        $price = $cat->getOrderPrice();
        $orderPrice = number_format($price, 2, '.', '');
        $orderInvoice = $cat->getOrderInvoiceReferenceNumber();

        $sampoPaymentAccepted = CATALOG_HTTPS_URL.$var->getSaveResult
                                (
                                    $var->getSaveEntriesFor("session", "language"),
                                    $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_ACCEPTED),
                                            $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_SAMPO),
                                            $var->getSaveEntry("order_reference_number", $orderInvoice)
                                ).".html";
                            
        $sampoPaymentDeclined = CATALOG_HTTPS_URL.$var->getSaveResult
                                (
                                    $var->getSaveEntriesFor("session", "language"),
                                    $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_DECLINED)
                                ).".html";

        
        $orderVerCode = md5
                (
                  PAYMENT_SAMPO_SERVICE_PROVIDER_MAC.
                          $orderPrice.
                          $orderInvoice.
                          PAYMENT_SAMPO_SERVICE_PROVIDER_ID.
                          '2'.   
                          'EUR'. 
                          $sampoPaymentAccepted.
                          $sampoPaymentDeclined
                        );

        $ret = $ui->item('MSG_PERSONAL_PAYMENT_SAMPO_COMMENTS').
               '<form ';
        
        if ($this->__nw)
            $ret .= 'target=_new ';
        
        $ret .= 'method="post" action="'.PAYMENT_SAMPO_URL.'">'.
                         '<input name="KNRO" type="hidden" value="'.PAYMENT_SAMPO_SERVICE_PROVIDER_ID.'">'.
                         '<input name="SUMMA" type="hidden" value="'.$orderPrice.'">'.
                         '<input name="VIITE" type="hidden" value="'.$orderInvoice.'">'.
                         '<input name="VALUUTTA" type="hidden" value="EUR">'.
                         '<input name="VERSIO" type="hidden" value="2">'.
                         '<input name="OKURL" type="hidden" value="'.$sampoPaymentAccepted.'">'.
                         '<input name="VIRHEURL" type="hidden" value="'.$sampoPaymentDeclined.'">'.
                         '<input name="TARKISTE" type="hidden" value="'.$orderVerCode.'">'.
                         '<input name="kieli" type=hidden value="en_US">'.
                         '<input class=sort type=submit value="'.$ui->item('ORDER_BTN_PAY_SAMPO').'">'.
                       '</form>';
        
        return $ret;
    }
}

return new CTemplate_PaymentSampo();

?>