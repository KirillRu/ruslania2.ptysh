<?

class CTemplate_CatalogPageselect extends CCommonTask
{

    var $fields = NULL;

    function setData(&$r)
    {
        if (strtolower(get_class($r)) !== "ccollection" && $r !== NULL)
        {
            trigger_error("CTemplate::setData() accepts only ccollection class as argument", E_USER_ERROR);
        }
        else
        {
            $this->fields = &$r;
        }
    }

    function getText()
    {
        $plist = $this->fields;
        $ui    = $this->ui;
        $d     = $this->argv->data;

        $ret = '';

        if ($plist !== NULL && $plist->length() > 0)
        {
            $buff = NULL;
            while ($plist->next())
            {
                $s = $plist->item();
                $buff .= "<a href=\"".$s->url."\"";
                switch($s->type)
                {
                    case PGSELTYPE_NORMAL:
                        $buff .= " title=\"".sprintf($ui->item("PGSELTYPE_NORMAL"), $s->title).
                                 "\" class=mainpg>";
                        $buff .= "&nbsp;".$s->title."&nbsp;";
                        break;
                    case PGSELTYPE_CURRENT:
                        $buff .= " title=\"".sprintf($ui->item("PGSELTYPE_CURRENT"), $s->title).
                                 "\" class=mainpgcurr>";
                        $buff .= "<b>&nbsp;".$s->title."&nbsp;</b>";
                        break;
                    case PGSELTYPE_PREVIOUS:
                        $buff .= " title=\"".sprintf($ui->item("PGSELTYPE_PREVIOUS"), $d->item("results_perpage")).
                                 "\" class=mainpg>";
                        $buff .= "&nbsp;...&nbsp;";
                        break;
                    case PGSELTYPE_NEXT:
                        $buff .= " title=\"".sprintf($ui->item("PGSELTYPE_NEXT"), $d->item("results_perpage")).
                                 "\" class=mainpg>";
                        $buff .= "&nbsp;...&nbsp;";
                }
                $buff_s[] = $buff."</a>";
                $buff = NULL;
            }
            $ret = @join($buff_s, "<span class=mainpg2>&nbsp;|&nbsp;</span>");
            if ($ret)
               $ret = sprintf($ui->item("PAGES"), $ret);
        }

        return $ret;
    }
}

return new CTemplate_CatalogPageselect();

?>