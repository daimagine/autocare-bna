<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/16/12
 * Time: 12:20 PM
 * To change this template use File | Settings | File Templates.
 */
class ItemType extends Eloquent{

    public static $table = 'item_type';

    public function item_category() {
        return $this->belongs_to('ItemCategory');
    }

    public static function listAll($criteria) {
        $itemType = ItemType::where('item_type.status', '=', 1)
            ->join('item_category', 'item_category.id', '=', 'item_type.item_category_id');
        if($criteria!=null) {
            if ($criteria['item_category_id']) {$itemType = $itemType->where('item_type.item_category_id', "=", $criteria['item_category_id']);}
        }
        $itemType = $itemType->get('item_type.*');
        return $itemType;
    }

    public static function update($id, $data=array()) {
        $item_type = ItemType::where_id($id)
            ->where_status(1)
            -first();
        $item_type->name=$data['name'];
        $item_type->description=$data['description'];
        $item_type->status=$data['status'];
        $item_type->save();
        return $item_type->id;
    }

    public static function create($data=array()) {
        $item_type = new ItemCategory();
        $item_type->name=$data['name'];
        $item_type->description=$data['description'];
        $item_type->status=$data['status'];
        $item_type->save();
        return $item_type->id;
    }

    public static function remove($id) {
        $item_type = ItemType::find($id);
        $item_type->status = 0;
        $item_type->save();
        return $item_type->id;
    }


}
