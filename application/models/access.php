<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/13/12
 * Time: 12:56 AM
 * To change this template use File | Settings | File Templates.
 */
class Access extends Eloquent {


    public static $table = 'access';

    public static function listAll($criteria) {
        return Access::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $access = Access::where_id($id)
            ->where_status(1)
            ->first();
        $access->description = $data['description'];
        $access->status = $data['status'];
        $access->name = $data['name'];
        $access->url = $data['url'];
        $access->viewable = $data['viewable'];
        $access->parent_id = @$data['parent_id'];
        $access->save();
        return $access->id;
    }

    public static function create($data = array()) {
        $access = new Access;
        $access->description = $data['description'];
        $access->status = $data['status'];
        $access->name = $data['name'];
        $access->url = $data['url'];
        $access->viewable = $data['viewable'];
        $access->parent_id = @$data['parent_id'];
        $access->save();
        return $access->id;
    }

    public static function remove($id) {
        $access = Access::find($id);
        $access->status = 0;
        $access->save();
        return $access->id;
    }

    public static function allSelect($id = -1) {
        $accesss = Access::where('status', '=', 1)
            ->where('parent_id', '=', '0')
            ->where('id', '<>', $id)
            ->get();
        $selection = array(
            0 => 'Select Below'
        );
        foreach($accesss as $access) {
            $selection[$access->id] = $access->name;
        }
        return $selection;
    }

}
