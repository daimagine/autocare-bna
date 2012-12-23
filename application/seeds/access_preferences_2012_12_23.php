<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:32 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_preferences_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'Preferences';
        $access->description = 'Preferences';
        $access->action = 'preferences@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Preferences List';
        $access->description = 'Preferences List';
        $access->action = 'preferences@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Change Password';
        $access->description = 'Change Password';
        $access->action = 'preferences@change_password';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

    }

    public function order() {
        return 7;
    }
}