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
        $user->role_id = $role->id;
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
        $user->role_id = $role->id;
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

    public static function check_permission($user, $uri) {
        $uri = str_replace('/', '@', $uri);
        $granted = false;
        $sql = 'select count(*) as res from access a inner join role_access ra on ra.access_id = a.id
                inner join role r on ra.role_id = r.id inner join user u on u.role_id = r.id
                where u.id = ? and a.action = ?';
        $count = DB::query($sql, array($user->id, $uri));

        if(intval($count[0]->res) > 0)
            $granted = true;
        return $granted;
    }

}