<?

class CTemplate_SearchNothingWasFound extends CCommonTask
{
    var $fields = NULL;

    function CTemplate_CatalogNothingWasFound() {}
    function setData(&$r) {}

    function getText()
    {
        $ui =& $this->ui;

        $buff = "<tr>".
                "<td class=maintxt>".
              "<div class=choose1><b>".$ui->item("MSG_SEARCH_NOTHING_WAS_FOUND0")."</b></div>".
                          "<ul class=mt5>".
                            "<li class=help1>".
                              $ui->item("MSG_SEARCH_NOTHING_WAS_FOUND1").
                            "<li class=help1>".
                              $ui->item("MSG_SEARCH_NOTHING_WAS_FOUND2").
                          "</ul>".
                        "</td>".
                        "</tr>";

                return $buff;
    }
}

return new CTemplate_SearchNothingWasFound();

?>