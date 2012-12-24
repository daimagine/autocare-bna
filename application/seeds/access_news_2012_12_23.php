<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:32 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_news_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'News';
        $access->description = 'News Management';
        $access->action = 'news@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'News List';
        $access->description = 'News Management List';
        $access->action = 'news@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'News Add';
        $access->description = 'News Management Add';
        $access->action = 'news@add';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'News Edit';
        $access->description = 'News Management Edit';
        $access->action = 'news@edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'News Delete';
        $access->description = 'News Management Delete';
        $access->action = 'news@delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'News Detail';
        $access->description = 'News Management Detail';
        $access->action = 'news@detail';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'News All';
        $access->description = 'News Management All';
        $access->action = 'news@all';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

    }

    public function order() {
        return 7;
    }
}