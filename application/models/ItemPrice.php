<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/25/12
 * Time: 1:25 AM
 * To change this template use File | Settings | File Templates.
 */

class ItemPrice extends Eloquent {

    public static $table = 'item_price';
    public static $timestamps = false;

    public function users() {
        return $this->belongs_to('User', 'configured_by');
    }

    public function item() {
        return $this->belongs_to('Item', 'item_id');
    }

    public static function listAll($criteria) {
        $itemPrice = ItemPrice::with(array(
            'item' => function($query) {
                if(isset($criteria['item_id'])) {
                   $query->where('id', '=', $criteria['item_id']);
                }
            },
            'item.item_category' => function($query){
                if(isset($criteria['item_category_id'])) {
                    $query->where('id', '=', $criteria['item_category_id']);
                }
            },
            'users'
        ));
        $itemPrice=$itemPrice->get();
//        {{dd($itemPrice);}}
        return $itemPrice;
    }

    public static function getSingleResult($criteria) {
        $itemPrice = ItemPrice::where('status', '=', 1);
        if(isset($criteria['item_id'])) {$itemPrice = $itemPrice->where('item_id', '=', $criteria['item_id']);}
        $itemPrice=$itemPrice->first();
        return $itemPrice;
    }

    public static function create($data=array()) {
        $itemPrice = new ItemPrice();
        $item = Item::find($data['item_id']);
        $itemPrice->item_id = $item->id;
        $itemPrice->price = $item->price;
        $itemPrice->status = statusType::ACTIVE;
        $itemPrice->configured_by = Auth::user()->id;
        $itemPrice->save();
        return $itemPrice->id;
    }

    public static function update($id, $criteria) {
        $itemPrice=ItemPrice::where_id($id)
            ->where_status(statusType::ACTIVE)
            ->first();
        if(isset($criteria['status'])){$itemPrice->status = $criteria['status'];}
        $itemPrice->save();
        return $itemPrice->id;
    }
}