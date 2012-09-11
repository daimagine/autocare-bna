<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/10/12
 * Time: 4:08 AM
 * To change this template use File | Settings | File Templates.
 */
class User extends Eloquent {

    public static $table = 'user';

    public function role() {
        return $this->belongs_to('Role');
    }

    public static function listAll($criteria) {
        return User::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $user = User::where_id($id)
            ->where_status(1)
            ->first();
        $role = Role::find($data['role_id']);
        $user->role = $role;
        $user->login_id = $data['login_id'];
        $user->status = $data['status'];
        $user->name = $data['name'];
        $user->staff_id = $data['staff_id'];
        $user->address1 = $data['address1'];
        $user->address2 = $data['address2'];
        $user->city = $data['city'];
        $user->phone1 = $data['phone1'];
        $user->phone2 = $data['phone2'];
        $user->save();
        return $user->id;
    }

    public static function create($data = array()) {
        $user = new User;
        $role = Role::find($data['role_id']);
        $user->role = $role;
        $user->login_id = $data['login_id'];
        $user->password = Hash::make($data['password']);
        $user->status = $data['status'];
        $user->name = $data['name'];
        $user->staff_id = $data['staff_id'];
        $user->address1 = $data['address1'];
        $user->address2 = $data['address2'];
        $user->city = $data['city'];
        $user->phone1 = $data['phone1'];
        $user->phone2 = $data['phone2'];
        $user->save();
        return $user->id;
    }

    public static function remove($id) {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return $user->id;
    }

}