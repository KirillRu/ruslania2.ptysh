<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentInvoice extends CCommonTask
{
        var $__cat = NULL;
        var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

        function CTemplate_PaymentInvoice() {}

        function setData(&$r)
        {
                $this->__cat =& $r;
        }

        function getText()
        {
                return $this->ui->item('MSG_PERSONAL_PAYMENT_INVOICE_COMMENTS');
        }
}

return new CTemplate_PaymentInvoice();

?>