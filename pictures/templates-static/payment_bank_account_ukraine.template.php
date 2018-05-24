<?

class CTemplate_PaymentBankAccountUkraine extends CCommonTask
{
    var $__cat = NULL;
    var $__nw  = FALSE;

    function setNewWindow($bool)
    {
        $this->__nw = $bool;
    }

    function CTemplate_PaymentBankAccountUkraine() {}

    function setData(&$r)
    {
        $this->__cat =& $r;
    }

    function getText()
    {
        return $this->ui->item('MSG_PAYMENT_TYPE_COMMENT_19');
    }
}

return new CTemplate_PaymentBankAccountUkraine();

?>