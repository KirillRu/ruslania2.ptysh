<?

class CTemplate_CatalogAudioBrowseItems_TXT extends CCommonTask
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

    function txtConvertHTMLEntitiesToAnsi(&$s)
    {
        $r = str_replace(Array("&Auml;", "&auml;", "&Ouml;", "&ouml;"),
                         Array("Ä", "ä", "Ö", "ö"),
                         $s);
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
        $ext = ".txt";
        $fname_tmp =  PRICELIST_GENERATED_FILE_PATH.PRICELIST_GENERATED_FILE_PREFIX.$this->uid.".tmp";
        $fname_gen =  PRICELIST_GENERATED_FILE_PATH.PRICELIST_GENERATED_FILE_PREFIX.$this->uid.$ext;

        $f = fopen ($fname_tmp, "w");

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
                $buff = NULL;

                if (!empty($r->stock_id))
                {
                    $buff .= '#'.$r->stock_id.", ";
                }

                $buff .= $r->title."\r\n";

                if (strtolower(get_class($r->authors)) == "ccollection")
                {
                    $authors_buff = Array();
                    while($r->authors->next())
                    {
                        $ai = $r->authors->item();
                        $authors_buff[] = $ai->title;
                    }
                    $buff .= sprintf($ui->item("WRITTEN_BY"), join($authors_buff, ", "))."\r\n";
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

                $buff .= "\r\n";

                if (!empty($r->pages))
                {
                    $buff .= sprintf($ui->item("X_PAGES"), $r->pages);
                    if (!empty($r->binding_name)) $buff .= ', ';
                }

                if (!empty($r->binding_id))
                {
                    $buff .= sprintf ($ui->item("BINDING_TYPE_OF"), $r->binding_name);
                }

                $buff .= "\r\n";

                if (!empty($r->isbn))
                {
                    $buff .= $ui->item("ISBN").': '.str_replace("-", "", $r->isbn)."\r\n";
                }

                $msg =  CDynamicTemplateFactory::createGetText(
                            DYNAMIC_TEMPLATE_FOR_ITEM_AVAILABILITY_TEXT, $r);

                $buff .= sprintf($ui->item("ITEM_AVAIBILITY"), $msg)."\r\n";

                if ($r->discount > 0)
                {
                    $discount = (int) round( (1 - ($r->discount / $r->price)) * 100);

                    $buff .= $ui->item("PRICE_DISCOUNT_FORMAT").
                             ' '.$discount.'%: '.
                             $user->formatCurrency("3_letters_with_rounded_number", $r->discount).
                             "\r\n";
                }
                else
                {
                    $buff .= $ui->item("Price").
                             ': '.
                             $user->formatCurrency("3_letters_with_rounded_number", $r->price).
                             "\r\n";
                }

                $buff .= '-------------------------------------------------'."\r\n";
                $buff = $this->txtConvertHTMLEntitiesToAnsi($buff);

                fwrite($f, $buff);
                $buff = NULL;
            }
            $i++;
        }

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

return new CTemplate_CatalogAudioBrowseItems_TXT();

?>