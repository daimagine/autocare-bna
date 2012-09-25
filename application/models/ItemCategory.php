<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/16/12
 * Time: 12:01 PM
 * To change this template use File | Settings | File Templates.
 */
class ItemCategory  extends Eloquent
{
    public static $table = 'item_category';

    public static function listAll($criteria) {
        $item_category = ItemCategory::where('status', '=', 1);
        if($criteria != null) {
            if($criteria['id']) {
                $item_category = $item_category->where('id', '=', $criteria['category_id']);
            }
        }
        $item_category = $item_category->get();
        return $item_category;
    }

    public static function getCategoryById($category_id) {
        $item_category = ItemCategory::where('status', '=', 1);
        if($category_id!=null) {
            $item_category = $item_category->where('id', '=', $category_id);
        }
        $item_category = $item_category->first();
        return $item_category;
    }

    public static function update($id, $data=array()) {
        $item_category = ItemCategory::where_id($id)
            ->where_status(1)
            -first();
        $item_category->name=$data['name'];
        $item_category->description=$data['description'];
        $item_category->status=$data['status'];
        $item_category->save();
        return $item_category->id;
    }

    public static function create($data=array()) {
        $item_category = new ItemCategory();
        $item_category->name=$data['name'];
        $item_category->description=$data['description'];
        $item_category->status=$data['status'];
        $item_category->save();
        return $item_category->id;
    }

    public static function remove($id) {
        $item_category = ItemCategory::find($id);
        $item_category->status = 0;
        $item_category->save();
        return $item_category->id;
    }

}
