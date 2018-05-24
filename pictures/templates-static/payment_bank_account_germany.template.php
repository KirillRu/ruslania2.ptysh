<?

class CTemplate_PaymentBankAccountGermany extends CCommonTask
{
    var $__cat = NULL;
    var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentBankAccountGermany() {}

    function setData(&$r)
    {
        $this->__cat =& $r;
    }

    function getText()
    {
        return $this->ui->item('MSG_PAYMENT_TYPE_COMMENT_21');
    }
}

return new CTemplate_PaymentBankAccountGermany();

?>