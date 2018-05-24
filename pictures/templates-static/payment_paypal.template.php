<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentPaypal extends CCommonTask
{
        var $__cat = NULL;
        var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentPaypal() {}

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
        $orderPrice = number_format($price, 2, '.', '');
        $orderInvoice = $cat->getOrderInvoiceReferenceNumber();

        list($usec, $sec) = explode(" ",microtime());
        $orderStamp = $sec.str_replace(".", "", $usec);

        $paymentAccepted = CATALOG_HTTPS_URL.$var->getSaveResult
                           (
                                $var->getSaveEntriesFor("session", "language"),
                                $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_ACCEPTED),
                                $var->getSaveEntry("payment_reply_service_id", PAYMENT_SERVICE_PAYPAL)
                           ).".html";

        $paymentDeclined = CATALOG_HTTPS_URL.$var->getSaveResult
                           (
                                 $var->getSaveEntriesFor("session", "language"),
                                 $var->getSaveEntry("context", CONTEXT_PAYMENT_EXTERNAL_DECLINED)
                           ).".html";

        $currency = $cat->getOrderCurrencyObject();
        $currency_text = $currency->formatCurrency('3_letters');

        $orderDescription = "Ruslania Books Oy internet shop order No.".$orderNumber.", ".$orderPrice." ".$currency_text;

        $ret = $ui->item('MSG_PERSONAL_PAYMENT_PAYPAL_COMMENTS').
               '<form ';

        if ($this->__nw)
            $ret .= 'target=_new ';

        $ret .= 'method="post" action="'.PAYMENT_PAYPAL_URL.'">'.
                '<INPUT TYPE="hidden" NAME="cmd" VALUE="_ext-enter">'.
                '<INPUT TYPE="hidden" NAME="redirect_cmd" VALUE="_xclick">'.
                '<INPUT TYPE="hidden" NAME="business" VALUE="'.PAYMENT_PAYPAL_BUSINESS.'">'.
                '<INPUT TYPE="hidden" NAME="item_name" VALUE="'.$orderDescription.'">'.
                '<INPUT TYPE="hidden" NAME="item_number" VALUE="'.$orderNumber.'">'.
                '<INPUT TYPE="hidden" NAME="quantity" VALUE="1">'.
                '<INPUT TYPE="hidden" NAME="amount" VALUE="'.$orderPrice.'">'.
                '<INPUT TYPE="hidden" NAME="invoice" VALUE="'.$orderInvoice.'">'.
                '<INPUT TYPE="hidden" NAME="no_shipping" VALUE="1">'.
                '<INPUT TYPE="hidden" NAME="no_note" VALUE="0">'.
                '<INPUT TYPE="hidden" name="currency_code" value="'.$currency_text.'">'.
                '<input type="hidden" name="return" value="'.$paymentAccepted.'">'.
                '<input type="hidden" name="cancel_return" value="'.$paymentDeclined.'">'.
                '<input type="hidden" name="rm" value="2">'.
                '<INPUT TYPE="image" SRC="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" BORDER="0" NAME="submit" ALT="Make payments with PayPal - it\'s fast, free and secure!">'.
            '</form>';

        return $ret;
    }
}

return new CTemplate_PaymentPaypal();

?>