<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/8/12
 * Time: 1:14 AM
 * To change this template use File | Settings | File Templates.
 */

class Transaction extends Eloquent {

    public static $table = 'transaction';
    public static $timestamps = false;

    public static $sqlformat = 'Y-m-d H:i:s';
    public static $yyyymmdd_format = 'Ymd';

    public function transaction_service() {
        return $this->has_many('TransactionService');
    }

    public function transaction_item() {
        return $this->has_many('TransactionItem');
    }

    public function user_workorder() {
        return $this->has_many('UserWorkorder');
    }

    public function vehicle() {
        return $this->belongs_to('Vehicle');
    }

    public static function list_all($criteria) {
        $trx = Transaction::with(array('vehicle', 'vehicle.customer'));
        $trx = $trx->where_in('status', $criteria['status']);
        $trx = $trx->get();
        return $trx;
    }

    public static function get_detail_trx($id) {
        $trx = Transaction::with(array(
            'vehicle',
            'vehicle.customer',
            'vehicle.customer.membership',
            'transaction_service',
            'transaction_service.service_formula',
            'transaction_service.service_formula.service',
            'transaction_item',
            'transaction_item.item_price.item',
            'transaction_item.item_price.item.item_type',
            'transaction_item.item_price.item.item_category',
            'transaction_item.item_price.item.item_unit',
            'user_workorder',
            'user_workorder.user'));
        $trx = $trx->where('id', '=', $id);
        return $trx->first();
    }
    public static function create($data = array()){
        //prepare save to db
        $trx = new Transaction();
        $trx->vehicle_id = $data['vehiclesid'];
        $trx->status = statusWorkOrder::OPEN;
        $trx->payment_state = paymentState::INITIATE;
        $trx->date = date(static::$sqlformat);
        $trx->save();


        //define amount variable
        $amount=(double)0;
        //add service
        if(isset($data['services']) && is_array($data['services'])) {
            foreach($data['services'] as $service) {
                $trx->transaction_service()->insert($service);
                $servicePrice = (double)Service::find((int)$service['service_formula_id'])->service_formula()->price;
                $amount=$amount+$servicePrice;
            }
        }

        //add items if available
        if(isset($data['items']) && is_array($data['items'])) {
            foreach($data['items'] as $items) {
                $item_price = ItemPrice::getSingleResult(array('item_id' => $items['item_id']))->id;
                $items['item_price_id']=$item_price;
                $trx->transaction_item()->insert($items);
                $itemPrice = (double)Item::find((int)$items['item_id'])->price;
                $amount=$amount+$itemPrice;
            }
        }

        //add mechanic
        if(isset($data['users']) && is_array($data['users'])) {
            foreach($data['users'] as $user) {
                $trx->user_workorder()->insert($user);
            }
        }


        //GENERATE WORK ORDER NO
        $woNo = 'C'.$data['customerId'].'V'.$data['vehiclesid'].($trx->id);
        $trx->workorder_no = $woNo;
        $trx->amount = $amount;
        $trx->save();
        return $trx->id;
    }

}