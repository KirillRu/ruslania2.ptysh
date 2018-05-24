<?
//
// NOTE: used from several places, not only .output.php
//       used for getting an item availability message text
//        _without_ formatting, based on item fields from DB
//
class CTemplate_ItemAvailabilityText extends CCommonTask
{
    var $fields = NULL;

    function setData(&$r)
    {
        $this->fields = &$r;
    }

    function getText()
    {
        $ui =& $this->ui;
        $r =& $this->fields;
        
        $msg = "";

        $entity = isset($r->entity) ? $r->entity : null;
        
        if ($r->in_shop > 0)
        {
            if ($r->in_shop <= CONST_ITEM_QUANTITY_AVAIBLE_LESS_THAN_5 &&
                // NOTE: [08.06.2004 12:51] [den] newspaper and magazines subscription are always in stock
                //
                (!empty($entity) || $entity != ENTITY_PEREODICS))
            {
                $msg = $ui->item("ITEM_AVAIBLE_STATUS_AVAIBLE_LESS_5");
            }
            else
            {
                $msg = $ui->item("ITEM_AVAIBLE_STATUS_AVAIBLE_SHOP");
            }
        }
        else if ($r->in_stock > 0)
        {
            $msg = $ui->item("ITEM_AVAIBLE_STATUS_AVAIBLE_STOCK");
        }
        else 
        {
            if (empty($r->stock_id))
                $msg = $ui->item("ITEM_AVAIBLE_STATUS_NOT_AVAILABLE_AT_ALL");
            else
                $msg = $ui->item("ITEM_AVAIBLE_STATUS_NOT_AVAIBLE");
        }
        
        return $msg;
    }
}

return new CTemplate_ItemAvailabilityText;

?>