<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:46 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_user_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'User';
        $access->description = 'User Management';
        $access->action = 'user@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'User List';
        $access->description = 'User Management List';
        $access->action = 'user@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'User Add';
        $access->description = 'User Management Add';
        $access->action = 'user@add';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'User Edit';
        $access->description = 'User Management Edit';
        $access->action = 'user@edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'User Delete';
        $access->description = 'User Management Delete';
        $access->action = 'user@delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'User Find';
        $access->description = 'User Management Find Ajax Name';
        $access->action = 'user@find';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

    }

    public function order() {
        return 3;
    }
}