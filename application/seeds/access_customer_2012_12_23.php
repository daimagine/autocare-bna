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
        $access->name = 'Customer';
        $access->description = 'Customer Management';
        $access->action = 'customer@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Customer List';
        $access->description = 'Customer Management List';
        $access->action = 'customer@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Customer Add';
        $access->description = 'Customer Management Add';
        $access->action = 'customer@add';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Customer Edit';
        $access->description = 'Customer Management Edit';
        $access->action = 'customer@edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Customer Delete';
        $access->description = 'Customer Management Delete';
        $access->action = 'customer@delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

    }

    public function order() {
        return 4;
    }
}