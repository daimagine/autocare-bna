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

    public function item() {
        return $this->belongs_to('Item');
    }

    public function itemName() {
        if($this->item)
            return $this->item->name;
    }


    public static function listAll($criteria) {
        $subAte=ItemStockFlow::where('account_trx_id', '=', $criteria['account_trx_id']);
        return $subAte->get();
    }

}