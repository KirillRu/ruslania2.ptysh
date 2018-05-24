<?

require_once("htmlcontrols.class.php");

class CTemplate_PaymentInshop extends CCommonTask
{
        var $__cat = NULL;
        var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

        function CTemplate_PaymentInshop() {}

        function setData(&$r)
        {
                $this->__cat =& $r;
        }

        function getText()
        {
                return $this->ui->item('MSG_PERSONAL_PAYMENT_INSHOP_COMMENTS');
        }
}

return new CTemplate_PaymentInshop();

?>