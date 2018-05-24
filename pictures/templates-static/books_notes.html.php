<?

if (!$user->isAuthorized() && strlen($ui->item("MSG_BOOKS_NOTE")) > 0)
{

?>
<tr>
  <td class=maintxt valign=middle>
    <table width=100% cellspacing=3 cellpadding=0 border=0>
    <tr>
      <td width=25 align=center valign=middle><img src=/pic1/info1.gif width=17 height=17></td>
      <td class=maintxt style="font-size: 60%; font-color: #BBBBBB; line-height: 140%">
        <?
        echo $ui->item("MSG_BOOKS_NOTE");
        ?>
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr><td><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td></tr>
<?

}

?>