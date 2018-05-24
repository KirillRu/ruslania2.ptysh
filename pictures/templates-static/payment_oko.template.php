<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentOko extends CCommonTask
{
        var $__cat = NULL;
        var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentOko() {}

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
        $orderReferenceNumber = $cat->getOrderInvoiceReferenceNumber();

        $paymentAcceptedUrl = CATALOG_HTTPS_URL.$var->getSaveResult
                              (
                                $var->getSaveEntriesFor("session", "language"),
                                $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_ACCEPTED),
                                $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_OKO)
                              ).".html";

        $paymentCanceledUrl .= CATALOG_HTTPS_URL.$var->getSaveResult
                               (
                             $var->getSaveEntriesFor("session", "language"),
                                 $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_DECLINED)
                               ).".html";

        $price = $cat->getOrderPrice();

        $orderPrice = number_format($price, 2, '.', '');
        //
        // WARNING: [07.01.2004 17:03][den] may be, it is not the correct order description
        //
        $orderDescription = "Ruslania Books Oy internet shop order No.".$orderNumber.", ".$orderPrice." EUR";

        $orderChecksum =
            "1".                                    // 'VERSIO'
            $orderNumber.                           // 'MAKSUTUNNUS'
            PAYMENT_OKO_MYYJA.                      // 'MYYJA'
            $orderPrice.                            // 'SUMMA'
            $orderReferenceNumber.                  // 'VIITE'
            "EUR".                                  // 'VALUUTTALAJI'
            PAYMENT_OKO_TARKISTE_VERSIO.            // 'TARKISTE_VERSIO'
            PAYMENT_OKO_TARKISTE;

        $orderChecksum = strtoupper(md5($orderChecksum));


        $ret = $ui->item('MSG_PERSONAL_PAYMENT_OKO_COMMENTS').
               '<form ';

        if ($this->__nw)
            $ret .= 'target=_new ';

        $ret .=
            'method="post" action="'.PAYMENT_OKO_URL.'">'.
            '<input name="action_id" type="hidden" value="701">'.
            '<input name="VERSIO" type="hidden" value="1">'.
            '<input name="MAKSUTUNNUS" type="hidden" value="'.$orderNumber.'">'.
            '<input name="MYYJA" type="hidden" value="'.PAYMENT_OKO_MYYJA.'">'.
            '<input name="SUMMA" type="hidden" value="'.$orderPrice.'">'.
            '<input name="VIITE" type="hidden" value="'.$orderReferenceNumber.'">'.
            '<input name="VIESTI" type="hidden" value="'.$orderDescription.'">'.
            '<input name="TARKISTE-VERSIO" type="hidden" value="'.PAYMENT_OKO_TARKISTE_VERSIO.'">'.
            '<input name="TARKISTE" type="hidden" value="'.$orderChecksum.'">'.
            '<input name="PALUU-LINKKI" type="hidden" value="'.$paymentAcceptedUrl.'">'.
            '<input name="PERUUTUS-LINKKI" type="hidden" value="'.$paymentCanceledUrl.'">'.
            '<input name="VAHVISTUS" type="hidden" value="Y">'.
            '<input name="VALUUTTALAJI" type="hidden" value="EUR">'.
            '<input class=sort type=submit value="'.$ui->item('ORDER_BTN_PAY_OKO').'">'.
            '</form>';

            return $ret;
    }
}

return new CTemplate_PaymentOko();

?>