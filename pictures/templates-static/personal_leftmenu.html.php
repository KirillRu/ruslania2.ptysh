<?

//
// FILE: personal_leftmenu.html.php
// INFO: static template
//
// DESCRIPTION: Output left menu HTML include file for 'personal' area of shop.
//              Also defines some URL`s for left menu.


$var->saveMode = INTO_URL_STRING;

/* ------------------------------------------------------------------------------------------------------------------------- */

$url_part = CATALOG_URL.
        $var->getSaveResult($var->getSaveEntriesFor("session", "language"));

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_SHOPCART) ).".html",
  "A_HREF_CONTEXT_PERSONAL_SHOPCART"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_LOGIN) ).".html",
  "A_HREF_CONTEXT_PERSONAL_LOGIN"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_LOGOUT) ).".html",
  "A_HREF_CONTEXT_PERSONAL_LOGOUT"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_ADDUSER) ).".html",
  "A_HREF_CONTEXT_PERSONAL_REGISTRATION"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_MODIFYUSER) ).".html",
  "A_HREF_CONTEXT_PERSONAL_MODIFYUSER"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_BROWSE_ADDRESS) ).".html",
  "A_HREF_CONTEXT_PERSONAL_BROWSE_ADDRESS"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_BROWSE_ORDERS) ).".html",
  "A_HREF_CONTEXT_PERSONAL_BROWSE_ORDERS"
);

$ui->add
(
  $var->getSaveResult( $url_part, $var->getSaveEntry("context", CONTEXT_PERSONAL_BROWSE_REQUESTS) ).".html",
  "A_HREF_PERSONAL_NOTAVAIBLE_ORDERS"
);

/* ------------------------------------------------------------------------------------------------------------------------- */

echo
"<!-- left menu wnd !-->",
"<table width=100% cellspacing=0 cellpadding=0 border=0>",
"<tr>",
  "<td class=leftmnutitle1>",
    "<table cellspacing=0 cellpadding=0 border=0>",
    "<tr>",
      "<td width=30 align=center><img src=\"/pic1/arr2.gif\" width=14 height=14></td>",
      "<td class=leftmnutitle1-table-txt>",
      $ui->item("LEFT_PERSONAL_FEATURES"),
      "</td>",
    "</tr>",
    "</table>",
  "</td>",
"</tr>",
"<tr>",
  "<td class=leftmnu2>",
    "<table width=100% border=0 cellspacing=5 cellpadding=2>";

if ( $user->isAuthorized() )
{

    echo
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_SHOPCART"), "\">",
        $ui->item("A_LEFT_PERSONAL_SHOPCART"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_BROWSE_ORDERS"), "\">",
        $ui->item("A_LEFT_PERSONAL_ORDERS"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_PERSONAL_NOTAVAIBLE_ORDERS"), "\">",
        $ui->item("A_LEFT_PERSONAL_NOTAVAIBLE_ORDERS"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_BROWSE_ADDRESS"), "\">",
        $ui->item("A_LEFT_PERSONAL_ADDRESSES"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_MODIFYUSER"), "\">",
        $ui->item("A_LEFT_PERSONAL_USERDATA"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_LOGOUT"), "\">",
        $ui->item("A_LEFT_PERSONAL_LOGOUT"),
        "</a>",
      "</td>",
    "</tr>",
    NULL;
}
else
{

  echo
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_SHOPCART"), "\">",
        $ui->item("A_LEFT_PERSONAL_SHOPCART"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_LOGIN"), "\">",
        $ui->item("A_LEFT_PERSONAL_LOGIN"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1 href=\"", $ui->item("A_HREF_CONTEXT_PERSONAL_REGISTRATION"), "\">",
        $ui->item("A_LEFT_PERSONAL_REGISTRATION"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1d.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1d>",
        $ui->item("A_LEFT_PERSONAL_ORDERS"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1d.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1d>",
        $ui->item("A_LEFT_PERSONAL_ADDRESSES"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1d.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1d>",
        $ui->item("A_LEFT_PERSONAL_USERDATA"),
        "</a>",
      "</td>",
    "</tr>",
    "<tr>",
      "<td valign=top align=center><img src=\"/pic/cl_f1d.gif\" width=4 height=10></td>",
      "<td class=maintxt>",
        "<a class=maintxt1d>",
        $ui->item("A_LEFT_PERSONAL_LOGOUT"),
        "</a>",
      "</td>",
    "</tr>",

    NULL;

}

echo
  "</table>",
"</td>",
"</tr>",
"</table>";

if ( !$user->isAuthorized() )
{
    echo "<div class=p10>",
           "<div class=notes1header>",
             $ui->item("A_LEFT_PAY_ATTENTION"),
           "</div>",
           "<div class=notes1body>",
             $ui->item("LEFT_INFO_CONTEXT_PERSONAL_NOT_AUTHORIZED"),
           "</div>",
         "</div>";
}
else
{
    if ( !$user->haveDeliveryAddress() )
    {
        echo "<div class=p10>",
               "<div class=notes1header>",
                 $ui->item("A_LEFT_PAY_ATTENTION"),
               "</div>",
               "<div class=notes1body>",
                 $ui->item("LEFT_INFO_CONTEXT_PERSONAL_NO_DEFAULT_ADDRESS"),
               "</div>",
             "</div>";
    }
}

switch($var->data->item("context"))
{
    case CONTEXT_PERSONAL_BROWSE_ADDRESS:
    echo "<div class=p10>",
               "<div class=notes1header>",
                 $ui->item("A_LEFT_INFO_CONTEXT"),
               "</div>",
               "<div class=notes1body>",
                 $ui->item("LEFT_INFO_CONTEXT_PERSONAL_BROWSE_ADDRESS"),
               "</div>",
             "</div>";
    break;
}

"<!-- left menu wnd !-->";
?>