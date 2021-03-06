<?php

class SortOptions
{
    const PriceLH  = 3;
    const PriceHL = 4;
    const TimeLH = 7;
    const TimeHL = 8;
    const NewLH = 11;
    const NewHL = 12;

    public static function GetSortData()
    {
        return array(
            self::PriceLH => Yii::app()->ui->item('SORTBY_ALL_PRICE_ASC'),
            self::PriceHL => Yii::app()->ui->item('SORTBY_ALL_PRICE_DESC'),
            self::TimeLH => Yii::app()->ui->item('SORTBY_ALL_DATE_ASC'),
            self::TimeHL => Yii::app()->ui->item('SORTBY_ALL_DATE_DESC'),
            self::NewLH => Yii::app()->ui->item('SORTBY_ALL_ADD_DATE_ASC'),
            self::NewHL => Yii::app()->ui->item('SORTBY_ALL_ADD_DATE_DESC'),
        );
    }

    public static function GetDefaultSort($sort)
    {
        $data = self::GetSortData();
        if(array_key_exists($sort, $data)) return $sort;
        return self::NewHL;
    }

    public static function GetSQL($sort, $lang, $entity=null)
    {
        switch($sort)
        {
            case self::NewHL : return ' t.add_date DESC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';//' t.in_stock DESC, t.add_date DESC ';
            case self::NewLH : return ' t.add_date ASC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
            case self::TimeLH :
                if($entity == Entity::PERIODIC) return ' t.id ASC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
                else return ' t.year ASC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
            case self::TimeHL :
                if($entity == Entity::PERIODIC) return ' t.id DESC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
                else return ' t.year DESC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
            case self::PriceLH :
                if($entity == Entity::PERIODIC) return ' t.sub_world_year ASC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
                else return ' t.brutto ASC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) ASC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
            case self::PriceHL :
                if($entity == Entity::PERIODIC) return ' t.sub_world_year DESC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
                else return ' t.brutto DESC, IF(t.in_shop < 5, FIELD(t.in_shop, 5,4,3,2,1), 0) DESC, 
                deliveryTime.delivery_unit ASC, deliveryTime.delivery_type_name ASC';
            default : throw new CException('Sort not implemented '.$sort);
        }
    }
}