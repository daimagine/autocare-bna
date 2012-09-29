<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/29/12
 * Time: 11:34 PM
 * To change this template use File | Settings | File Templates.
 */

class Service extends Eloquent {

    public static $table = 'service';
    public static $timestamps = false;

    public function service_formula() {
        return $this->has_many('ServiceFormula', 'service_id')
            ->where('status', '=' , statusType::ACTIVE)->first(); //just got active price
    }


    public static function list_all($criteria) {
        $service = Service::where_in('status', $criteria['status']);
        $service=$service->get();
        return $service;
    }

    public static function create($data=array()) {
        $service = new Service();
        $service->name = $data['name'];
        $service->description = $data['description'];
        $service->status = $data['status'];
        $service->save();
        return $service->id;
    }

    public static function update($id, $data=array()) {
        $service = Service::find($id);
        $service->name = $data['name'];
        $service->description = $data['description'];
        $service->status = $data['status'];
        $service->save();
        return $service->id;
    }


    public static function remove($id) {
        $service =Service::find($id);
        $service->status = statusType::INACTIVE;
        $service->save();
        return $service->id;
    }
}