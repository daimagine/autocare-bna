<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/18/12
 * Time: 03:56 AM
 * To change this template use File | Settings | File Templates.
 */
class Member extends Eloquent {

    public static $table = 'membership';

    public static function listAll($criteria) {
        return Member::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $member = Member::where_id($id)
            ->where_status(1)
            ->first();
        $member->name = $data['number'];
        $member->status = $data['status'];
        $member->registration_date = @$data['registration_date'];
        $member->expiry_date = @$data['expiry_date'];
        if(isset($data['discount_id']) && $data['discount_id'] != '0') {
            $member->discount_id = $data['discount_id'];
        }
        //save
        $member->save();
        return $member->id;
    }

    public static function create($data = array()) {
        $member = new Member;
        $member->name = $data['number'];
        $member->status = $data['status'];
        $member->registration_date = @$data['registration_date'];
        $member->expiry_date = @$data['expiry_date'];
        if(isset($data['discount_id']) && $data['discount_id'] != '0') {
            $member->discount_id = $data['discount_id'];
        }
        $member->save();
        return $member->id;
    }

    public static function remove($id) {
        $member = Member::find($id);
        $member->status = 0;
        $member->save();
        return $member->id;
    }

}
