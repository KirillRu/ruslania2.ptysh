<?

class CTemplate_CatalogNothingWasFound extends CCommonTask
{
    var $fields = NULL;

    function CTemplate_CatalogNothingWasFound() {}
    function setData(&$r) {}

    function getText()
    {
        $ui =& $this->ui;

        $buff = "<tr>".
                "<td class=maintxt>".
              "<div class=choose1><b>".$ui->item("MSG_NO_ITEMS").".</b></div>".
                          "<ul class=mt5>".
                            "<li class=help1>".
                              $ui->item("MSG_CATALOG_NOTHING_WAS_FOUND1").
                            "<li class=help1>".
                              sprintf($ui->item("MSG_CATALOG_NOTHING_WAS_FOUND2"), "http://www.ruslania.com").
                          "</ul>".
                        "</td>".
                        "</tr>";

                return $buff;
    }
}

return new CTemplate_CatalogNothingWasFound();

?>