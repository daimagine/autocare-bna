<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:32 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_access_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'Access';
        $access->description = 'Access Management';
        $access->action = 'access@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Access Add';
        $access->description = 'Access Management Add';
        $access->action = 'access@add';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Access Edit';
        $access->description = 'Access Management Edit';
        $access->action = 'access@edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Access Delete';
        $access->description = 'Access Management Delete';
        $access->action = 'access@delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Access List';
        $access->description = 'Access Management List';
        $access->action = 'access@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

    }

    public function order() {
        return 2;
    }
}