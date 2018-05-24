<?

class CTemplate_FormValidationErrors extends CCommonTask
{
    var $fields = NULL;

    function setData(&$r)
    {
        $this->fields = &$r;
    }

    function getText()
    {
        $f    =& $this->fields;

        $ret = "<tr><td><table border=0 cellspacing=3><tr><td valign=top><img src=/pic1/warning1.gif width=18 height=18></td>".
                   "<td class=maintxt width=100%>".$this->ui->item("MSG_FORM_VALIDATE_ERROR")."</td>".
                   "</tr><tr><td class=maintxt colspan=2><ul class=err1>";

        while($f->next())
        {
            $err = $f->item();
            if (strtolower(get_class($err)) == "clocalizederrorinfo")
            {
                $ret .= "<li class=err1>".
                        (
                          $err->sourceKey == NULL ? NULL :
                          sprintf($this->ui->item("MSG_FIELD_X"), $this->ui->item($err->sourceKey)).", "
                        ).
                        $this->ui->item($err->messageKey);
            }
        }

        $ret .= "</ul></td></tr></table></td></tr>".
                "<tr><td><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td></tr>";
        return $ret;
    }
}

return new CTemplate_FormValidationErrors();

?>