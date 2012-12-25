<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:32 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_settlement_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'Settlement';
        $access->description = 'Settlement Management';
        $access->action = 'settlement@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Settlement List';
        $access->description = 'Settlement Management List';
        $access->action = 'settlement@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Settlement Add';
        $access->description = 'Settlement Management Add';
        $access->action = 'settlement@add';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Settlement Edit';
        $access->description = 'Settlement Management Edit';
        $access->action = 'settlement@edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Settlement Delete';
        $access->description = 'Settlement Management Delete';
        $access->action = 'settlement@delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

    }

    public function order() {
        return 11;
    }
}