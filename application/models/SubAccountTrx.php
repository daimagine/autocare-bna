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
        return $this->belongs_to('AccountTransaction', 'account_trx_id')
            ->where('status', '=', '1');
    }

    public static function getByCriteria($criteria) {
        $ate=SubAccountTrx::where('approved_status', '=', $criteria['approved_status']);
        if($criteria['id']) {$ate=$ate->where('id', '=', $criteria['id']);}
        if($criteria['account_trx_id']){$ate=$ate->where('account_trx_id', '=', $criteria['account_trx_id']);}
        return $ate->get();
    }

    public static function updateStatus($id, $status) {
        $subAccountTrx = SubAccountTrx::where_id($id)->first();
        $subAccountTrx->approved_status = $status;
        $subAccountTrx->save();
        return $subAccountTrx->id;
    }

}