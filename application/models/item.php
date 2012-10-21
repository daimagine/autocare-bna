<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/16/12
 * Time: 8:44 AM
 * To change this template use File | Settings | File Templates.
 */

class Item extends Eloquent {

    public static $table = 'item';
    public static $timestamps = false;

    private static $REF_PREFIX = 'ITM';
    private static $REF_LENGTH = 10;



    public function item_category() {
        return $this->belongs_to('ItemCategory');
    }

    public function item_unit() {
        return $this->belongs_to('UnitType', 'unit_id');
    }

    public function item_type() {
        return $this->belongs_to('ItemType');
    }

    public function item_stock_flow() {
        return $this->has_many_and_belongs_to('AccountTransactions', 'item_stock_flow')
            ->with('sequence');
    }

    public static function listAll($criteria) {
        $item = Item::where('status', '=', 1);
        if(isset($criteria['item_category_id'])){$item = $item->where('item_category_id', '=', $criteria['item_category_id']);}
        $item=$item->get();
        return $item;

    }

    public static function update($id, $data=array()) {
        $item = Item::where_id($id)
            ->where_status(1)
            ->first();
        if(isset($data['item_type_id'])){
            $item_type= ItemType::find($data['item_type_id']);
            $item->item_type_id=$item_type->id;
        }
        if(isset($data['item_category_id'])){
            $item_category= ItemCategory::find($data['item_category_id']);
            $item->item_category_id = $item_category->id;
        }
        if(isset($data['unit_id'])){
            $unit_type = UnitType::find($data['unit_id']);
            $item->unit_id=$unit_type->id;
        }
        if(isset($data['stock'])){$item->stock=$data['stock'];}
        if(isset($data['name'])){$item->name=$data['name'];}
        if(isset($data['code'])){$item->code=$data['code'];}
        if(isset($data['description'])){$item->description=$data['description'];}
        if(isset($data['price'])){$item->price=$data['price'];}
        if(isset($data['purchase_price'])){$item->purchase_price=$data['purchase_price'];}
        if(isset($data['vendor'])){$item->vendor=$data['vendor'];}
        if(isset($data['status'])){$item->status=$data['status'];}
        $item->save();
        return $item->id;
    }

    public static function create($data=array()) {
        $item = new Item();
        if (isset($data['item_type_id'])) {
            $item_type= ItemType::find($data['item_type_id']);
            $item->item_type_id=$item_type->id;
        }
        $item_category= ItemCategory::find($data['item_category_id']);
        $item->item_category_id = $item_category->id;
        $unit_type = UnitType::find($data['unit_id']);
        $item->unit_id=$unit_type->id;
        $item->name=$data['name'];
        $item->name=$data['name'];
        $item->code=$data['code'];
        $item->description=$data['description'];
        if(isset($data['stock'])) {
//            $item->stock=$data['stock'];
        }
        if(isset($data['stock_opname'])) {
            $item->stock=$data['stock_opname'];
        }
        $item->price=$data['price'];
        $item->purchase_price=$data['purchase_price'];
        $item->vendor=$data['vendor'];
        $item->status=$data['status'];
//        $item->date=$data['date'];
//        $item->expiry_date=$data['expiry_date'];
        $item->save();
        return $item->id;
    }

    public static function remove($id) {
        $item = Item::find($id);
        $item->status = 0;
        $item->save();
        return $item->id;
    }

    public static function updateStock($id, $stock) {
        $item = Item::where_id($id)
            ->where_status(1)
            ->first();
        $item->stock=$stock;
        $item->save();
        return $item->id;
    }

    public static function code_new_item() {
        $count = DB::table(static::$table)->order_by('id', 'desc')->take(1)->only('id');
        $count++;
        $suffix = sprintf('%0' . static::$REF_LENGTH . 'd', $count);
        return static::$REF_PREFIX . $suffix;
    }
}