<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adi
 * Date: 12/23/12
 * Time: 8:46 PM
 * To change this template use File | Settings | File Templates.
 */

class Seed_Access_account_2012_12_23 extends S2\Seed {

    public function grow() {
        $access = new Access();
        $access->name = 'Account';
        $access->description = 'Account Management';
        $access->action = 'account@index';
        $access->status = true;
        $access->parent = true;
        $access->visible = true;
        $access->type = 'M';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account List';
        $access->description = 'Account Management List';
        $access->action = 'account@list';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Add';
        $access->description = 'Account Management Add';
        $access->action = 'account@add';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Edit';
        $access->description = 'Account Management Edit';
        $access->action = 'account@edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Delete';
        $access->description = 'Account Management Delete';
        $access->action = 'account@delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Receivable';
        $access->description = 'Account Receivable';
        $access->action = 'account@account_receivable';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Payable';
        $access->description = 'Account Payable';
        $access->action = 'account@account_payable';
        $access->status = true;
        $access->parent = false;
        $access->visible = true;
        $access->type = 'S';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Pay Invoice';
        $access->description = 'Pay Invoice';
        $access->action = 'account@pay_invoice';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Invoice';
        $access->description = 'Account Invoice';
        $access->action = 'account@invoice_in';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Invoice Edit';
        $access->description = 'Account Invoice Edit';
        $access->action = 'account@invoice_edit';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

        $child = new Access();
        $child->parent_id = $access->id;
        $access->name = 'Account Invoice Delete';
        $access->description = 'Account Invoice Delete';
        $access->action = 'account@invoice_delete';
        $access->status = true;
        $access->parent = false;
        $access->visible = false;
        $access->type = 'L';
        $access->save();

    }

    public function order() {
        return 5;
    }
}