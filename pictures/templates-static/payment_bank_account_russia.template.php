<?

class CTemplate_PaymentBankAccountRussia extends CCommonTask
{
    var $__cat = NULL;
    var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentBankAccountRussia() {}

    function setData(&$r)
    {
        $this->__cat =& $r;
    }

    function getText()
    {
        return $this->ui->item('MSG_PAYMENT_TYPE_COMMENT_14');
    }
}

return new CTemplate_PaymentBankAccountRussia();

?>