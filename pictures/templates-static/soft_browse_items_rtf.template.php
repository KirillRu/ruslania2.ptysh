<?

class CTemplate_CatalogSoftBrowseItems_RTF extends CCommonTask
{
    var $fields = NULL;
    var $uid = NULL;

    function setData($r)
    {
        if (!is_a($r, "CCatalog"))
        {
            trigger_error("CTemplate::setData() accepts only php 'CCatalog' class as argument.", E_USER_ERROR);
        }
        $this->fields = &$r;
    }

    function setUid($uid)
    {
        $this->uid = $uid;
    }

    function rtfConvertAnsi(&$s)
    {
        $r = "";
        for ($i=0; $i<strlen($s); $i++)
        {
            $ch = $s{$i};
            $ch_int = ord($ch);
            $r .= ($ch_int > 127) ? "\\'".dechex($ch_int) : $ch;
        }

        $r = str_replace(Array("&Auml;", "&auml;", "&Ouml;", "&ouml;"),
                         Array("\u196?", "\u228?", "\u214?", "\u246?"),
                         $r);
        return $r;
    }

    function getText()
    {
        $cat   =& $this->fields;
        $user  =& $cat->userData;
        $ui    =& $this->ui;
        $a     =& $this->argv;
        $buff  = NULL;
        $pages = Array();

        if ($a->data->item("view_pricelist_page_type") == PRICELIST_PAGE_ALL)
            $cat->setIsLimited(FALSE);

        if ($a->data->item("view_pricelist_page_type") == PRICELIST_PAGE_EXPLICIT)
        {
            $pages = $this->makeExplicitPagesArray($a->data->item("view_pricelist_pages"));
            if (sizeof($pages) == 0) $pages[] = 1;

            $cat->setIsLimited(FALSE);
        }

        $cat->open();

        $ext = ".rtf";
        $fname_tmp =  PRICELIST_GENERATED_FILE_PATH.PRICELIST_GENERATED_FILE_PREFIX.$this->uid.".tmp";
        $fname_gen =  PRICELIST_GENERATED_FILE_PATH.PRICELIST_GENERATED_FILE_PREFIX.$this->uid.$ext;

        $f = fopen ($fname_tmp, "w");

        switch($this->argv->data->item("language"))
        {
            case LANGUAGE_RUSSIAN:
                $def_codepage = 'ansicpg1252\deff0\deflang1049';
                break;
            case LANGUAGE_FINNISH:
                $def_codepage = 'ansicpg1252\deff0\deflang1035';
                break;
            default:
                $def_codepage = 'ansicpg1252\deff0\deflang1035';
        }

        $buff = '{\rtf1\ansi\\'.$def_codepage.'{\fonttbl{\f0\fswiss\fprq2\fcharset0 Tahoma;}}'."\r\n".
            '{\colortbl ;\red128\green128\blue128;\red0\green0\blue0;}'."\r\n".
                '\pard\fs16'."\r\n";

        fwrite($f, $buff);

        $i = 0;
        $fetch = TRUE;


        while ($cat->moveNext())
        {
            if ($a->data->item("view_pricelist_page_type") == PRICELIST_PAGE_EXPLICIT)
            {
                if ($i % $a->data->item("results_perpage") == 0) $page++;

                if (in_array($page, $pages))
                    $fetch = TRUE;
                else
                    $fetch = FALSE;

                if ($page > max($pages))
                {
                    $cat->close();
                    break;
                }

            }

            if ($fetch)
            {
                    $r = $cat->getFields();

                $buff = '\b ';

                if (!empty($r->stock_id))
                {
                    $buff .= '#'.$r->stock_id.', ';
                }

                $buff .= $r->title.' \b0\par'."\r\n";

                if (strtolower(get_class($r->authors)) == "ccollection")
                {
                    $authors_buff = Array();
                    while($r->authors->next())
                    {
                        $ai = $r->authors->item();
                        $authors_buff[] = $ai->title;
                    }
                    $buff .= sprintf($ui->item("WRITTEN_BY"), join($authors_buff, ", ")).' \par'."\r\n";
                }

                if (!empty($r->publisher_name))
                {
                    $buff .= sprintf($ui->item("PUBLISHED_BY"), $r->publisher_name).' ';
                }

                if (!empty($r->year))
                {
                    $x = empty($r->publisher_name);
                    $buff .= sprintf($ui->item( ($x ? "PUBLISHED_IN_YEAR" : "IN_YEAR") ), $r->year);
                    unset($x);
                }

                $buff .= ' \par'."\r\n";

                if (!empty($r->pages))
                {
                    $buff .= sprintf($ui->item("X_PAGES"), $r->pages);
                    if (!empty($r->binding_name)) $buff .= ', ';
                }

                if (!empty($r->binding_id))
                {
                    $buff .= sprintf ($ui->item("BINDING_TYPE_OF"), $r->binding_name);
                }

                $buff .= ' \par\par'."\r\n";

                if (!empty($r->isbn))
                {
                    $buff .= $ui->item("ISBN").': '.str_replace("-", "", $r->isbn).' \par'."\r\n";
                }

                $msg =  CDynamicTemplateFactory::createGetText(
                            DYNAMIC_TEMPLATE_FOR_ITEM_AVAILABILITY_TEXT, $r);

                $buff .= sprintf($ui->item("ITEM_AVAIBILITY"), $msg).' \par'."\r\n";

                if ($r->discount > 0)
                {
                    $discount = (int) round( (1 - ($r->discount / $r->price)) * 100);

                    $buff .= $ui->item("PRICE_DISCOUNT_FORMAT").
                             ' '.$discount.'%: \b '.
                             $user->formatCurrency("3_letters_with_rounded_number", $r->discount).
                             ' \b0\par'."\r\n";
                }
                else
                {
                    $buff .= $ui->item("Price").
                             ': \b '.
                             $user->formatCurrency("3_letters_with_rounded_number", $r->price).
                             ' \b0\par'."\r\n";
                }

                $buff .= '\par ------------------------------------------------- \par'."\r\n";

                $buff = $this->rtfConvertAnsi($buff);
                fwrite($f, $buff);
                $buff = NULL;
            }
            $i++;
        }

        fwrite($f, "}");

        fclose($f);
        rename($fname_tmp, $fname_gen);

        return TRUE;
    }

    function makeExplicitPagesArray($s)
    {
        $b = explode(",", $s, 32);
        $r = Array();

        for($i = 0; $i < sizeof($b); $i++)
        {
            if (strstr($b[$i], "-"))
            {
                list($a1, $a2) = explode("-", $b[$i]);
                settype($a1, "integer");
                settype($a2, "integer");
                if ( $a1 > 0 && $a2 > 0 ) $r = array_merge($r, range($a1, $a2));
            }
            else
            {
                $j = $b[$i];
                settype($j, "integer");
                if ( $j > 0 ) $r[] = $j;
            }
        }
        $r = array_unique($r);
        sort($r, SORT_NUMERIC);
        return $r;
    }

}

return new CTemplate_CatalogSoftBrowseItems_RTF();

?>