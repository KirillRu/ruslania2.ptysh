<?

class CTemplate_ChildCatList extends CCommonTask
{
    var $fields = NULL;

    function setData(&$r)
    {
        if (!is_a($r,"ccollection"))
        {
            trigger_error("CTemplate_ChildCatList::setData() accepts only ccollection class derived instance as argument", E_USER_ERROR);
        }
        else
        {
            $this->fields =& $r;
        }
    }

    function getText()
    {
        $buff = NULL;
        $slist = &$this->fields;
        $ui = &$this->ui;

        if ($slist->length() > 0)
                {

                        $buff = "<!-- subcatlist !-->".
                                "<tr>".
                                  "<td class=leftmnutitle1>".
                                    "<table cellspacing=0 cellpadding=0 border=0>".
                                    "<tr>".
                                      "<td width=30 align=center><img src=/pic1/arr2.gif width=14 height=14></td>".
                                      "<td class=leftmnutitle1-table-txt>".
                                        $ui->item("Choose a subcategory").
                                      "</td>".
                                     "</tr>".
                                    "</table>".
                                  "</td>".
                                "</tr>".
                                "<tr>".
                                  "<td class=leftmnu2>".
                                    "<table width=100% border=0 cellspacing=5 cellpadding=3>";

                        while ($slist->next())
                        {
                                $s = $slist->item();

                                $buff .= "<tr>".
                                           "<td valign=top><img src=/pic/cl_f1d.gif width=4 height=10></td>".
                           "<td class=maintxt><a class=maintxt1 ".
                                           "href=\"".$s->url."\">".
                                           $s->title.
                                           "</a></td>".
                                         "</tr>";

                        }

                       $buff .= "</table></td></tr>";
                }
        return $buff;
    }

    /*
    function getText()
    {
        $buff = NULL;
        $slist = &$this->fields;
        $ui = &$this->ui;

        if ($slist->length() > 0)
                {

                    $half = FALSE;

                        $buff = "<!-- subcatlist !-->".
                                "<tr>".
                                  "<td class=maintxt>".
                                    "<div class=choose2><b>".
                                      $ui->item("Choose a subcategory").
                                      ":</b>".
                                    "<div>".
                                  "</td>".
                                "</tr>".
                                "<tr>".
                                  "<td class=maintxt>".
                                    "<table width=100% cellspacing=0 cellpadding=0 border=0 class=mb5>".
                                      "<tr>".
                                        "<td><img src=pic/null.gif width=10 height=1></td>".
                                        "<td valign=top nowrap>";

                        $i = 0;
                        $half = FALSE;

            $szList = $slist->length();

                        while ($slist->next())
                        {
                                $s = $slist->item();

                                $buff .= "<div class=catlist><a class=catlist href=\"".
                                         $s->url.
                                         "\"><img src=pic/cl_m.gif width=3 height=5 border=0>&nbsp;&nbsp;".
                                         $s->title.
                                         "</a></div>\n";

                                if (!$half && @($szList / ++$i) < 2 && $szList > 4)
                                {
                                        $buff .= "</td>".
                                                 "<td width=10><img src=pic/null.gif width=30 height=1></td>".
                                                 "<td nowrap valign=top>";
                                        $half = TRUE;
                                }

                        }

                       $buff .= "</td><td width=100%>&nbsp;</td></table>".
                                "</td></tr>".
                                "<!-- subcatlist !-->".
                                "<tr><td><div class=itemsep1><img src=pic/null.gif width=1 height=1 border=0></div></td></tr>";
                }
        return $buff;
    }
    */
}

return new CTemplate_ChildCatList();

?>