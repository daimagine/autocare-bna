<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/22/12
 * Time: 4:47 PM
 * To change this template use File | Settings | File Templates.
 */

class SubAccountTrx extends Eloquent {

    public static $table = 'sub_account_trx';
    private static $accountTrxStatus = null;

    public function account_transaction() {
        return $this->belongs_to('AccountTransaction', 'account_trx_id');
    }

    public static function getByCriteria($criteria) {
        $ate=SubAccountTrx::join('account_transactions', 'sub_account_trx.account_trx_id', '=', 'account_transactions.id');
        $ate=$ate->where('sub_account_trx.approved_status', '=', $criteria['approved_status']);
        if(isset($criteria['id'])) {$ate=$ate->where('sub_account_trx.id', '=', $criteria['id']);}
        if(isset($criteria['account_trx_id'])) {$ate=$ate->where('sub_account_trx.account_trx_id', '=', $criteria['account_trx_id']);}
//        if(isset($criteria['account_trx_status'])) {$ate=$ate->where('account_transactions.status', '=', $criteria['account_trx_status']);}
        $ate=$ate->where('account_transactions.status', '=', $criteria['account_trx_status']);
//        $ate=SubAccountTrx::where('approved_status', '=', $criteria['approved_status']);
//        if($criteria['id']) {$ate=$ate->where('id', '=', $criteria['id']);}
//        if($criteria['account_trx_id']){$ate=$ate->where('account_trx_id', '=', $criteria['account_trx_id']);}
//        {{dd($criteria['approved_status']);}}
        return $ate->get('sub_account_trx.*');
    }

    public static function updateStatus($id, $status, $remarks) {
        $subAccountTrx = SubAccountTrx::where_id($id)->first();
        $subAccountTrx->approved_status = $status;
        $subAccountTrx->remarks = $remarks;
        $subAccountTrx->save();
        return $subAccountTrx->id;
    }

}