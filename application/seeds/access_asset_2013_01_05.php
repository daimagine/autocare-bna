<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 1/5/13
 * Time: 6:48 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_asset_2013_01_05 extends S2\Seed {

    public function grow() {
        $parent = new Access();
        $parent->name = 'Asset';
        $parent->description = 'Asset index';
        $parent->action = 'asset@index';
        $parent->status = true;
        $parent->parent = true;
        $parent->visible = true;
        $parent->type = 'M';
        $parent->save();

        $s = new Access();
        $s->name = 'Asset Approved Invoice';
        $s->description = 'Asset Approved Invoice';
        $s->action = 'asset@list_approved';
        $s->status = true;
        $s->parent = false;
        $s->visible = true;
        $s->type = 'S';
        $s->parent_id = $parent->id;
        $s->save();

        $s = new Access();
        $s->name = 'Asset List';
        $s->description = 'Asset List';
        $s->action = 'asset@list';
        $s->status = true;
        $s->parent = false;
        $s->visible = true;
        $s->type = 'S';
        $s->parent_id = $parent->id;
        $s->save();

        $l = new Access();
        $l->name = 'Asset Approved Detail';
        $l->description = 'Asset Approved Detail';
        $l->action = 'asset@detail_approved';
        $l->status = true;
        $l->parent = false;
        $l->visible = false;
        $l->type = 'L';
        $l->parent_id = $parent->id;
        $l->save();

        $l = new Access();
        $l->name = 'Asset Approved Process';
        $l->description = 'Asset Approved Process';
        $l->action = 'asset@approved_action';
        $l->status = true;
        $l->parent = false;
        $l->visible = false;
        $l->type = 'L';
        $l->parent_id = $parent->id;
        $l->save();

//        $l = new Access();
//        $l->name = 'Asset Add New Approved Asset';
//        $l->description = 'Put Asset For Approved';
//        $l->action = 'asset@putnewitem';
//        $l->status = true;
//        $l->parent = false;
//        $l->visible = false;
//        $l->type = 'L';
//        $l->parent_id = $parent->id;
//        $l->save();

        $l = new Access();
        $l->name = 'Asset Edit';
        $l->description = 'Asset Edit';
        $l->action = 'asset@edit';
        $l->status = true;
        $l->parent = false;
        $l->visible = false;
        $l->type = 'L';
        $l->parent_id = $parent->id;
        $l->save();

        $l = new Access();
        $l->name = 'Asset Delete';
        $l->description = 'Asset Delete';
        $l->action = 'asset@delete';
        $l->status = true;
        $l->parent = false;
        $l->visible = false;
        $l->type = 'L';
        $l->parent_id = $parent->id;
        $l->save();

        $l = new Access();
        $l->name = 'Asset Add List Approved Asset';
        $l->description = 'Asset Add List Approved Asset';
        $l->action = 'asset@add_approved_asset';
        $l->status = true;
        $l->parent = false;
        $l->visible = false;
        $l->type = 'L';
        $l->parent_id = $parent->id;
        $l->save();

//        $l = new Access();
//        $l->name = 'Asset List approved';
//        $l->description = 'Asset List approved';
//        $l->action = 'asset@lst_item';
//        $l->status = true;
//        $l->parent = false;
//        $l->visible = false;
//        $l->type = 'L';
//        $l->parent_id = $parent->id;
//        $l->save();
    }

    public function order() {
        return 1;
    }
}