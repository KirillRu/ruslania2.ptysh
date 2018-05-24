<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentCheck extends CCommonTask
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
                return $this->ui->item('MSG_PAYMENT_CHECK_COMMENT_FOR_BROWSE_ORDERS');
        }
}

return new CTemplate_PaymentCheck();

?>