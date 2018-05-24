<?
$var->saveMode = INTO_URL_STRING;

$href_conditions =
    CATALOG_URL.$var->getSaveResult
    (
      $var->getSaveEntriesFor("session", "language"),
      $var->getSaveEntry("context", CONTEXT_INFO_CONDITIONS)
    ).
    ".html";

$href_conditions_order =
    CATALOG_URL.$var->getSaveResult
    (
      $var->getSaveEntriesFor("session", "language"),
      $var->getSaveEntry("context", CONTEXT_INFO_CONDITIONS_ORDER)
    ).
    ".html";

$href_conditions_sub =
    CATALOG_URL.$var->getSaveResult
    (
      $var->getSaveEntriesFor("session", "language"),
      $var->getSaveEntry("context", CONTEXT_INFO_CONDITIONS_SUBSCRIPTION)
    ).
    ".html";

$href_contactus =
    CATALOG_URL.$var->getSaveResult
    (
      $var->getSaveEntriesFor("session", "language"),
      $var->getSaveEntry("context", CONTEXT_INFO_CONTACTUS)
    ).
    ".html";
    
$href_legal_notice =
    CATALOG_URL.$var->getSaveResult
    (
      $var->getSaveEntriesFor("session", "language"),
      $var->getSaveEntry("context", CONTEXT_INFO_LEGAL_NOTICE)
    ).
    ".html";
    
$href_privacy_policy =
    CATALOG_URL.$var->getSaveResult
    (
      $var->getSaveEntriesFor("session", "language"),
      $var->getSaveEntry("context", CONTEXT_INFO_PRIVACY_POLICY)
    ).
    ".html";

?>
<!-- main wnd !-->
<table cellspacing=0 cellpadding=0 border=0 width=100%>
<tr>
  <td width=100%><div
  class=itemsep><img src="/pic/null.gif" width=1 height=1
  border=0></div></td>
</tr>
<tr>
  <td width=100%>
    <table cellspacing=10 cellpadding=0 border=0>
    <tr>
      <td width=100% class=maintxt>
        <a class=maintxt href="<?=$href_conditions;?>"><?=$ui->item("MSG_CONDITIONS_OF_USE");?></a>
        &nbsp;&nbsp;|
        <a class=maintxt href="<?=$href_conditions_order;?>"><?=$ui->item("YM_CONTEXT_CONDITIONS_ORDER_ALL");?></a>
        &nbsp;&nbsp;|
        <a class=maintxt href="<?=$href_conditions_sub;?>"><?=$ui->item("YM_CONTEXT_CONDITIONS_ORDER_PRD");?></a>
        &nbsp;&nbsp;|
        <a class=maintxt href="<?=$href_contactus;?>"><?=$ui->item("YM_CONTEXT_CONTACTUS");?></a>
        &nbsp;&nbsp;|
        <a class=maintxt href="<?=$href_legal_notice;?>"><?=$ui->item("YM_CONTEXT_LEGAL_NOTICE");?></a>
        &nbsp;&nbsp;|
        <?php
        if ($var->data->item("language") == LANGUAGE_FINNISH)
        {
            ?>
        <a class=maintxt href="<?=$href_privacy_policy;?>"><?=$ui->item("YM_CONTEXT_PRIVACY_POLICY");?></a>
        &nbsp;&nbsp;|
            <?php
        }
        ?>
        &nbsp;&nbsp;&copy; <?=date("Y"); ?>, Ruslania Books OY&nbsp;&nbsp;&nbsp;&nbsp;<a class=maintxt href="mailto:generalsupports@ruslania.com" title="mail to Ruslania Books"><?=$ui->item("A_MAIL_TO_RUSLANIA");?></a>
      </td>
      <td width=100% align=right class=maintxt>
        <a href="<?=$var->data->item("request_uri");?>#top" class=maintxt><img align=center border=0 src="/pic1/movetop.gif"><?=$ui->item("MSG_MOVE_TOP");?></a>
      </td>
    </tr>
    </table>
  </td>
</tr>
</table>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27359361-1']);
  _gaq.push(['_setDomainName', 'ruslania.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>

