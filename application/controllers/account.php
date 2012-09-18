<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/18/12
 * Time: 03:35 AM
 */
class Account_Controller extends Secure_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
        Session::put('active.main.nav', 'account@index');
    }

    public function get_index() {
        $this->get_list();
    }

    public function get_list() {
        $criteria = array();
        $account = Account::listAll($criteria);
        return $this->layout->nest('content', 'account.index', array(
            'account' => $account
        ));
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('account/index');
        }
        $account = Account::find($id);
        return $this->layout->nest('content', 'account.edit', array(
            'account' => $account,
        ));
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null) {
            return Redirect::to('account/index');
        }
        $accountdata = Input::all();
        $success = Account::update($id, $accountdata);
        if($success) {
            //success edit
            Session::flash('message', 'Success update');
            return Redirect::to('account/index');
        } else {
            Session::flash('message_error', 'Failed update');
            return Redirect::to('account/edit')
                ->with('id', $id);
        }
    }

    public function get_add() {
        $accountdata = Session::get('account');
        return $this->layout->nest('content', 'account.add', array(
            'account' => $accountdata,
        ));
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $accountdata = Input::all();
        if(!$validation->fails()) {
            $success = Account::create($accountdata);
            if($success) {
                //success
                Session::flash('message', 'Success create');
                return Redirect::to('account/index');
            } else {
                Session::flash('message_error', 'Failed create');
                return Redirect::to('account/add')
                    ->with('account', $accountdata);
            }
        } else {
            return Redirect::to('account/add')
                ->with_errors($validation)
                ->with('account', $accountdata);
        }
    }

    public function get_delete($id=null) {
        if($id===null) {
            return Redirect::to('account/index');
        }
        $success = Account::remove($id);
        if($success) {
            //success
            Session::flash('message', 'Remove success');
            return Redirect::to('account/index');
        } else {
            Session::flash('message_error', 'Remove failed');
            return Redirect::to('account/index');
        }
    }

    private function getRules($method='add') {
        $additional = array();
        $rules = array(
            'name' => 'required|max:50',
        );
        if($method == 'add') {
            $additional = array(
            );
        } elseif($method == 'edit') {
            $additional = array(
            );
        }
        return array_merge($rules, $additional);
    }

}