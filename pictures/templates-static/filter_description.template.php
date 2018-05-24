<?

class CTemplate_FilterDescription extends CCommonTask
{
        var $fields = NULL;

        function setData(&$r)
        {
                $this->fields = &$r;
        }

        function getText()
        {
                $cat       = &$this->fields;
                $ret       = NULL;
                $fileName  = NULL;
                $haveFile  = FALSE;
                
                if (CONTEXT_CATALOG_BROWSE == $this->argv->data->item("context"))
                {
                        if ($this->argv->isDataExists("category_id"))
                        {
                            $fileName = $cat->getCategoryDescriptionFile();
                            $haveFile = is_file($fileName);
                        }
                }
                else if (CONTEXT_CATALOG_FILTER == $this->argv->data->item("context"))
                {
                        $entity = $this->argv->data->item("entity");
                        if ($entity == ENTITY_AUDIO ||
                            $entity == ENTITY_BOOKS ||
                            $entity == ENTITY_MUSIC)
                        {
                                $fileName = $cat->getFilterDescriptionFile();
                                $haveFile = is_file($fileName);
                        }
                }
                
                if ($haveFile)
                {
                        $ret = "<tr><td>".
                               "<table width=100% cellspacing=0 cellpadding=0 border=0>".
                               "<tr>".
                                 "<td width=100% class=maintxt>";

                        $ret .= file_get_contents($fileName);

                        $ret .=
                                 "</td>".
                               "</tr>".
                               "</table>".
                               "</td></tr>".
                               "<tr><td><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td></tr>";
                }
                return $ret;
        }
}

return new CTemplate_FilterDescription();

?>