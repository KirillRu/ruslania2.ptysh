<?php

class DeliveryTime extends CMyActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'delivery_time_list';
    }
}
