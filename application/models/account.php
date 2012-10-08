<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/18/12
 * Time: 03:56 AM
 * To change this template use File | Settings | File Templates.
 */
class Account extends Eloquent {

    public static $table = 'account';


    public function sub_account_transaction() {
        return $this->has_many('SubAccountTrans', 'account_type_id');
    }

    public static function listAll($criteria) {
        return Account::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $account = Account::where_id($id)
            ->where_status(1)
            ->first();
        $account->name = $data['name'];
        $account->description = @$data['description'];
        $account->type = @$data['type'];
        $account->status = $data['status'];
        //save
        $account->save();
        return $account->id;
    }

    public static function create($data = array()) {
        $account = new Account;
        $account->name = $data['name'];
        $account->description = @$data['description'];
        $account->type = @$data['type'];
        $account->status = $data['status'];
        $account->save();
        return $account->id;
    }

    public static function remove($id) {
        $account = Account::find($id);
        $account->status = 0;
        $account->save();
        return $account->id;
    }

    public static function allSelect() {
        $accounts = Account::where('status', '=', 1)->get();
        $selection = array();
        foreach($accounts as $a) {
            $selection[$a->id] = $a->name;
        }
        return $selection;
    }
}
