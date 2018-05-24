<?

require_once("catalog.template.factory.php");

class CTemplate_CatalogAllBrowseItems extends CCommonTask
{
    var $fields = NULL;
    var $__templateFactory = NULL;
    var $__templateInstance = NULL;
    
    function CTemplate_CatalogAllBrowseItems()
    {
        $this->__templateFactory = new CDynamicTemplateFactory();
        $this->__templateInstance = array();
    }

    function setData($r)
    {
        if (!is_a($r, "CCatalog"))
        {
            trigger_error("CTemplate::setData() accepts only php 'CCatalog' class as argument.", E_USER_ERROR);
        }
        $this->fields = &$r;
    }

    function getText()
    {
        $cat =& $this->fields;
        $ui  =& $this->ui;
        $a   =& $this->argv;
        $me  =  CATALOG_URL;
        $i = 0;
        
        while ($cat->moveNext())
        {
            $e = $cat->getCurrentEntity();
            if (NULL == $this->__templateInstance[$e])
            {
                $this->__templateInstance[$e] = 
                    $this->__templateFactory->createExplicitInstance(DYNAMIC_TEMPLATE_FOR_ENTITY_CATALOG_ITEMS, $e);
                
                $this->setResources($this->__templateInstance[$e]);
        
                $this->__templateInstance[$e]->setData($cat);
                
                $s = $cat->getEntityMetadata($e);

                $url = '/?context=16449&entity='.intVal($e).'&bsearch_expression='.urlencode(@$_GET['bsearch_expression']);
                
                $items_tables .= "<table width=100% cellspacing=1 cellpadding=5 border=0>".
                                 "<tr>".
                                       "<td width=31 class=index_entity_title1>".
                                       "<a href=\"".$s->url."\">".
                                       "<img border=0 src=\"/pic1/".$s->picture."\" width=31 height=31></a>".
                                       "</td>".
                                       "<td width=100% class=index_entity_title2>".
                                         "&nbsp;&nbsp;".
                                         "<a href=\"".$url."\" class=index_entity_title2>".$s->title."</a>".
                                       "</td>".
                                     "</tr>".
                                     "</table>";
            }

        
            $items_tables .= $this->__templateInstance[$e]->__getItemText($cat->getFields(),$i++ > 0);
        
        }

        $ret = $items_tables;

        return $ret;
    }
}

return new CTemplate_CatalogAllBrowseItems();

?>