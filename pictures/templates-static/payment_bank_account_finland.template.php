<?

class CTemplate_PaymentBankAccountFinland extends CCommonTask
{
    var $__cat = NULL;
    var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentBankAccountFinland() {}

    function setData(&$r)
    {
        $this->__cat =& $r;
    }

    function getText()
    {
        return $this->ui->item('MSG_PAYMENT_TYPE_COMMENT_13');
    }
}

return new CTemplate_PaymentBankAccountFinland();

?>