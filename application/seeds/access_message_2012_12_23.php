<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:32 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_Message_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'Messages';
        $access->description = 'Messages';
        $access->action = 'conversation@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Message New';
        $access->description = 'Message New';
        $access->action = 'conversation@new';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Message Send';
        $access->description = 'Message Send';
        $access->action = 'conversation@send';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Message View';
        $access->description = 'Message View';
        $access->action = 'conversation@view';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

    }

    public function order() {
        return 6;
    }
}