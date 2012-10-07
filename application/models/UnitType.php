<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/7/12
 * Time: 10:10 PM
 * To change this template use File | Settings | File Templates.
 */

class UnitType extends Eloquent{

    public static $table = 'unit_type';

    public function item_category() {
        return $this->belongs_to('ItemCategory');
    }

    public static function listAll($criteria) {
        $unitType = UnitType::join('item_category', 'item_category.id', '=', 'unit_type.item_category_id');
        if($criteria!=null) {
            if ($criteria['item_category_id']) {$unitType = $unitType->where('unit_type.item_category_id', "=", $criteria['item_category_id']);}
        }
        $unitType = $unitType->get('unit_type.*');
        return $unitType;
    }
}