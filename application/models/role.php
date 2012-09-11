<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/11/12
 * Time: 10:35 PM
 * To change this template use File | Settings | File Templates.
 */
class Role extends Eloquent {

    public static $table = 'role';

    public function users() {
        return $this->has_many('User', 'role_id');
    }

    public static function listAll($criteria) {
        return Role::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $role = Role::where_id($id)
            ->where_status(1)
            ->first();
        $role->description = $data['description'];
        $role->status = $data['status'];
        $role->name = $data['name'];
        $role->parent_id = @$data['parent_id'];
        $role->save();
        return $role->id;
    }

    public static function create($data = array()) {
        $role = new Role;
        $role->description = $data['description'];
        $role->status = $data['status'];
        $role->name = $data['name'];
        $role->parent_id = @$data['parent_id'];
        $role->save();
        return $role->id;
    }

    public static function remove($id) {
        $role = Role::find($id);
        $role->status = 0;
        $role->save();
        return $role->id;
    }

    public static function allSelect() {
        $roles = Role::where('status', '=', 1)->get();
        $selection = array();
        foreach($roles as $role) {
            $selection[$role->id] = $role->name;
        }
        return $selection;
    }
}
