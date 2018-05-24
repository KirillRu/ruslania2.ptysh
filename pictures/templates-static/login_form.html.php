<?

//
// FILE: login_form.html.php
// INFO: static template
//
// DESCRIPTION: Output left menu HTML input form.
//

if ( !$user->isAuthorized())
{

require_once("htmlcontrols.class.php");

$oldSaveMode = $var->saveMode;
$var->saveMode = INTO_NAMEVALUE_ARRAY;

$html = new HTMLControlsHelper();

/* ------------------------------------------------------------------------------------------------------------------------- */

$saveEntryCommon = $var->getSaveResult
(
  $var->getSaveEntriesFor("session", "language"),
  $var->getSaveEntry("context", CONTEXT_PERSONAL_LOGIN)
);

$html_input_username = $html->createSingle_INPUT("type=text class=search1", $var->getSaveEntry("user_login"));
$html_input_userpass = $html->createSingle_INPUT("type=password class=search1", $var->getSaveEntry("user_password"));
$html_input_hidden   = $html->createMulitple_INPUT("type=hidden", $saveEntryCommon);

$var->saveMode = $oldSaveMode;

//NOTE [27.04.2006 22:37][Dain]: url for remind password page creation
$url = 
    CATALOG_URL.
    $var->getSaveResult
    (
        $var->getSaveEntriesFor("language"),
        $var->getSaveEntry("context", CONTEXT_PERSONAL_REMIND_PASS)
    ).
    ".html";
$ui->add($url, "A_HREF_REMIND_PASS");

?>

<tr>
  <td class=leftmnutitle1>
    <table cellspacing=0 cellpadding=0 border=0>
    <tr>
      <td width=30 align=center><img src=/pic1/arr2.gif width=14 height=14></td>
      <td class=leftmnutitle1-table-txt>
      <?=$ui->item("MSG_USER_LOGIN");?>
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr>
  <form action="<?=CATALOG_URL;?>" method=GET>
  <td class=leftmnu2>
    <!-- login form begin !-->
    <table width=100% border=0 cellspacing=5 cellpadding=0>
    <tr>
      <td class=maintxt>
      <?=$ui->item("A_LOGINFORM_EMAIL");?>:<br>
      <?
      echo $html_input_username;
      ?>
      </td>
    </tr>
    <tr>
      <td class=maintxt>
      <?=$ui->item("A_LOGINFORM_PASSWORD");?>:<br>
      <?
      echo $html_input_userpass;
      echo $html_input_hidden;
      ?>
      </td>
    </tr>
    <tr>
      <td class=maintxt>
      <a class=maintxt href='<?php echo $ui->item("A_HREF_REMIND_PASS");?>' title='<?php echo $ui->item("A_TITLE_REMIND_PASS");?>'>
      <?php echo $ui->item("A_REMIND_PASS");?>
      </a>
      </td>
    </tr>
    <tr>
      <td class=maintxt>
      <?
            echo "<input type=image src=\"/pic1/".$ui->item("USER_LOGIN_PICTURE").
                 "\" alt=\"".$ui->item("USER_LOGIN_ALT")."\">";
      ?>
      </td>
    </tr>
    </form>
    </table>
    <!-- login form end !-->
  </td>
</tr>

<?
} // if ( !$user->isAuthorized() )
?>