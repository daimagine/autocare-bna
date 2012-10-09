<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jauhaf
 * Date: 9/22/12
 * Time: 8:15 AM
 * To change this template use File | Settings | File Templates.
 */

class ItemStockFlow extends Eloquent {

    public static $table = 'item_stock_flow';
    public static $timestamps = false;

    public function item() {
        return $this->belongs_to('Item', 'item_id');
    }

    public function sub_account_trx() {
        return $this->belongs_to('SubAccountTrx', 'sub_account_trx_id');
    }

    public function user() {
        return $this->belongs_to('User', 'configured_by');
    }

    public function itemName() {
        if($this->item)
            return $this->item->name;
    }


    public static function listAll($criteria) {
        $its=ItemStockFlow::where_in('item_stock_flow.status', $criteria['status']);
        $its=$its->join('item', 'item.id', '=', 'item_stock_flow.item_id');
        $its=$its->join('item_category', 'item_category.id', '=', 'item.item_category_id');
        $its=$its->join('user', 'user.id', '=', 'item_stock_flow.configured_by');
        $its=$its->join('sub_account_trx', 'sub_account_trx.id', '=', 'item_stock_flow.sub_account_trx_id');
        if(isset($criteria['sub_account_trx_id'])) {
            $its=$its->where('item_stock_flow.sub_account_trx_id', '=', $criteria['sub_account_trx_id']);
        }
        if(isset($criteria['item_category_id'])) {
            $its = $its->where('item.item_category_id', '=', $criteria['item_category_id']);
        }
        return $its->get('item_stock_flow.*');
    }

    public static function create($data=array()) {
        $itemStockFlow = new ItemStockFlow();
//        {{dd($data);}}
        $item= Item::find($data['item_id']);
        $subAccountTrx = SubAccountTrx::find($data['sub_account_trx_id']);
        $itemStockFlow->item_id = $item->id;
        $itemStockFlow->sub_account_trx_id = $subAccountTrx->id;
        $itemStockFlow->quantity = $data['quantity'];
        $itemStockFlow->type = 'O'; //.....??????
        $itemStockFlow->status = itemStockFlowStatus::ADD_TO_LIST;
        $itemStockFlow->configured_by = Auth::user()->id;
        $itemStockFlow->save();
        return $itemStockFlow->id;
    }

    public static function updateStatus($id, $status) {
        $itemStockFlow =  ItemStockFlow::where_id($id)->first();
        $itemStockFlow->status = $status;
        $itemStockFlow->save();
        return $itemStockFlow->id;
    }

    public static function deleteItemStockFlow($id) {
        $affected = DB::table('item_stock_flow')
            ->where('id', '=', $id)
            ->delete();
    }

}