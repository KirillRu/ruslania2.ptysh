<?
class CTemplate_PersonalModifyUserForm extends CCommonTask
{
    var $fields = NULL;
    var $html   = NULL;

    function CTemplate_PersonalModifyUserForm()
    {
        $this->html = new HTMLControlsHelper();
    }

    function setData(&$r)
    {
        $this->fields = &$r;
    }

    function getText()
    {
        $ui   =& $this->ui;
        $f    =& $this->fields;
        $html =& $this->html;
        $var  =& $this->argv;

        $old_mode = $var->saveMode;
        $var->saveMode = INTO_NAMEVALUE_ARRAY;

        $ret = "<tr><td class=maintxt><form method=get action=".CATALOG_URL.">".
               "<table cellspacing=0 cellpadding=5 border=0>".
                   "<tr>".
                     "<td class=maintxt>".
                       "<span class=redtext>*</span>".
                       $ui->item("regform_email").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=text class=simpletext size=25",
                         $var->getSaveEntry("regform_email", $f->login)
                       ).
                     "</td><td></td>".
                     "</tr><tr>".
                     "<td class=maintxt>".
                       "<span class=redtext>*</span>".
                       $ui->item("regform_password").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=password class=simpletext size=25",
                         $var->getSaveEntry("regform_password", $f->pwd)
                       ).
                     "</td><td class=smalltxt1>".
                     "<img src=/pic1/arr3.gif width=8 height=7> ".
                       $ui->item("MSG_REGFORM_PASSWORD_TIP_1").
                     "</td>".
                     "</tr><tr>".
                     "<td class=maintxt>".
                       "<span class=redtext>*</span>".
                       $ui->item("regform_repeat_password").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=password class=simpletext size=25",
                         $var->getSaveEntry("regform_repeat_password", $f->pwd)
                       ).
                     "</td><td class=smalltxt1></td>".
                     "</tr><tr>".
                     "<td class=maintxt>".
                       $ui->item("regform_titlename").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=text class=simpletext size=10",
                         $var->getSaveEntry("regform_titlename", $f->title_name)
                       ).
                     "</td><td class=smalltxt1>".
                     "<img src=/pic1/arr3.gif width=8 height=7> ".
                       $ui->item("MSG_REGFORM_TITLENAME_TIP_1").
                     "</td>".
                     "</tr><tr>".
                     "<td class=maintxt>".
                       "<span class=redtext>*</span>".
                       $ui->item("regform_lastname").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=text class=simpletext size=25",
                         $var->getSaveEntry("regform_lastname", $f->last_name)
                       ).
                     "</td><td class=smalltxt1></td>".
                     "</tr><tr>".
                     "<td class=maintxt>".
                       "<span class=redtext>*</span>".
                       $ui->item("regform_firstname").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=text class=simpletext size=25",
                         $var->getSaveEntry("regform_firstname", $f->first_name)
                       ).
                     "</td><td class=smalltxt1></td>".
                     "</tr><tr>".
                     "<td class=maintxt>".
                       $ui->item("regform_middlename").
                     "</td><td class=maintxt-vat>".
                       $html->createSingle_INPUT
                       (
                         "type=text class=simpletext size=25",
                         $var->getSaveEntry("regform_middlename", $f->middle_name)
                       ).
                     "</td><td class=smalltxt1></td>".
                     "</tr></table>".
                     "<tr><td><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td></tr>".
                     "<tr><td class=smalltxt1>".
                       "<input type=image src=/pic1/".$ui->item("SAVE_PICTURE").
                       " class=vat title=\"".$ui->item("SAVE_ALT").
                       "\"> &nbsp;&nbsp; ".
                       $ui->item("MSG_REGFORM_REQUIRED_TIP").
                     "</td></tr>".
                     $html->createMulitple_INPUT
                     (
                       "type=hidden",
                       $var->getSaveResult($var->getSaveEntriesFor("session", "context", "language"))
                     ).
                     "</form>";

        $var->saveMode = $old_mode;
        return $ret;
    }
}

return new CTemplate_PersonalModifyUserForm();

?>