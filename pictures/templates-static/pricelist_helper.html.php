<?
//
// FILE: output pricelist generator HTML include.
// NOTE: script assumes some variable is scope are set. see code.
// NOTE: script must be called only from CONTEXT_CATALOG_BROWSE, CONTEXT_CATALOG_SEARCH, CONTEXT_CATALOG_FILTER
//

//
//
// NOTE: $cat->open() call made in template
//
if ($var->isDataExists("view_pricelist_run"))
{
    ignore_user_abort(TRUE);

    $content_length = 8192;
    $uid = md5(uniqid(""));

    $url = CATALOG_URL.
           $var->getSaveResult
           (
             $var->getSaveEntriesFor("session", "language", "view_pricelist_format"),
             $var->getSaveEntry("context",                       CONTEXT_INFO_PRICELIST_WATCHER),
             $var->getSaveEntry("view_pricelist_generating_uid", $uid),
             $var->getSaveEntry("view_pricelist_watcher_action", PRICELIST_WATCHER_WAIT)
           ).".html";

    header("Location: ".$url);
    header("Content-Length: ".$content_length);
    header("Connection: close", TRUE);

    //
    // NOTE: send $content_length bytes to emulate page open for Internet Explorer.
    // WARNING: not tested with other browsers
    //
    echo str_repeat(" ", $content_length);

    //
    // NOTE: from this point there is no browser interaction, user is redirected to another page
    //
    ob_end_flush();

    //
    // NOTE: activate generation, implemented as dynamic template.
    //

    $template = $dynTemplate->createInstance(DYNAMIC_TEMPLATE_FOR_ENTITY_CATALOG_ITEMS_HTML);
    $template->setData($cat);
    $template->setUid($uid);
    $template->getText();

    unset($template);
    //
    // NOTE: no browser interaction - no output or later processing, so exit
    //
    exit();

}
else
{
    header ($ui->item("HTTP_HEADER_CONTENTTYPE"), TRUE);

    $html = new HTMLControlsHelper();
    $var->saveMode = INTO_NAMEVALUE_ARRAY;

    echo
    '<html>',
    '<head>',
      '<title>',
        $ui->item("HTML_PAGE_TITLE"),
      '</title>',
      '<meta http-equiv="Expires" content="0">',
      '<meta http-equiv="pragma" content="no-cache">',
      '<meta http-equiv="Cache-control" content="no-cache">',
      '<base href="', RESOURCE_URL, '">',
      '<link rel="stylesheet" type="text/css" href="ruslania.css">',
      $ui->item("HTML_META_CONTENTTYPE"),
    '</head>',
    '<body bgcolor=#FFFFFF topmargin=10 leftmargin=10 rightmargin=0 marginwidth=0 marginheight=0>';

    echo
    '<table width=100% cellspacing=5 cellpadding=3>',
    '<form action="', CATALOG_URL, '" method=GET>',
    '<tr>',
        '<td width=100%><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td>',
    '</tr>',
    '<tr>',
      '<td class=maintxt>',
        $ui->item("MSG_PRICE_CHOOSE_PAGE_TYPE"),
        ':<br>',
        $html->createSingle_INPUT
        (
          'type=radio id=vppt_pa '.$html->setChecked($var->data->item("view_pricelist_page_type"), PRICELIST_PAGE_ALL),
          $var->getSaveEntry("view_pricelist_page_type", PRICELIST_PAGE_ALL)
        ),
        '<label for="vppt_pa">',
          $ui->item("MSG_PRICE_PAGE_TYPE_".PRICELIST_PAGE_ALL),
        '</label>',
        '<br>',
        $html->createSingle_INPUT
        (
          'type=radio id=vppt_pc '.$html->setChecked($var->data->item("view_pricelist_page_type"), PRICELIST_PAGE_CURRENT),
          $var->getSaveEntry("view_pricelist_page_type", PRICELIST_PAGE_CURRENT)
        ),
        '<label for="vppt_pc">',
          $ui->item("MSG_PRICE_PAGE_TYPE_".PRICELIST_PAGE_CURRENT),
        '</label>',
      '</td>',
    '</tr>',
    '<tr>',
        '<td width=100%><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td>',
    '</tr>',
    '<tr>',
        '<td class=maintxt>',
          $html->createMulitple_INPUT
          (
            "type=hidden",
            $var->getSaveResult
            (
              $var->getSaveEntriesWithout("view_pricelist_page_type", "view_pricelist_is_zipped", "view_pricelist_pages"),
              $var->getSaveEntry("view_pricelist_run", TRUE),
              $var->getSaveEntry("view_pricelist_format", PRICELIST_FORMAT_HTML)
            )
          ),
          '<input onclick="document.forms[0].submit(); this.disabled=true;" type=image src="/pic1/',
            $ui->item("MSG_PRICE_BTN_CONTINUE_SRC"),
            '" alt="',
            $ui->item("MSG_PRICE_BTN_CONTINUE_ALT"),
          '">',
          '</td>',
        '</tr>',
    '</table>',
    '</body>';

    $var->saveMode = INTO_URL_STRING;
}
?>