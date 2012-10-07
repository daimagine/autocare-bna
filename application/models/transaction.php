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

    public static function create($data = array()){
        $trx = new Transaction();
        $trx->vehicle_id = $data['vehiclesid'];
        $trx->status = statusWorkOrder::OPEN;
        $trx->date = date(static::$sqlformat);
        $trx->amount = 0;//temp
        $trx->save();

        //add service
        if(isset($data['services']) && is_array($data['services'])) {
            foreach($data['services'] as $service) {
                $trx->transaction_service()->insert($service);
            }
        }

        //add items
        if(isset($data['items']) && is_array($data['items'])) {
            foreach($data['items'] as $items) {
                $trx->transaction_item()->insert($items);
            }
        }

        //add mechanic
        if(isset($data['users']) && is_array($data['users'])) {
            foreach($data['users'] as $user) {
                $trx->user_workorder()->insert($user);
            }
        }

        return $trx->id;
    }

}