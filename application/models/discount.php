<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/18/12
 * Time: 03:56 AM
 * To change this template use File | Settings | File Templates.
 */
class Discount extends Eloquent {

    public static $table = 'discount';

    public static function listAll($criteria=array()) {
        return Discount::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $discount = Discount::where_id($id)
            ->where_status(1)
            ->first();
        $discount->code = $data['code'];
        $discount->description = @$data['description'];
        $discount->status = $data['status'];
        $discount->value = $data['value'];
		$discount->registration_fee = $data['registration_fee'];
		$discount->duration = $data['duration'];
		$discount->duration_period = $data['duration_period'];
        //save
        $discount->save();
        return $discount->id;
    }

    public static function create($data = array()) {
        $discount = new Discount;
        $discount->code = $data['code'];
        $discount->description = @$data['description'];
        $discount->status = $data['status'];
        $discount->value = $data['value'];
		$discount->registration_fee = $data['registration_fee'];
		$discount->duration = $data['duration'];
		$discount->duration_period = $data['duration_period'];
		//save
        $discount->save();
        return $discount->id;
    }

    public static function remove($id) {
        $discount = Discount::find($id);
        $discount->status = 0;
        $discount->save();
        return $discount->id;
    }

}
