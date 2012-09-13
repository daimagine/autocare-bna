<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/11/12
 * Time: 10:47 PM
 * To change this template use File | Settings | File Templates.
 */
class Role_Controller extends Secure_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $criteria = array();
        $roles = Role::listAll($criteria);
        return $this->layout->nest('content', 'role.index', array(
            'roles' => $roles
        ));
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('role/index');
        }
        $role = Role::find($id);
        return $this->layout->nest('content', 'role.edit', array('role' => $role));
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null   ) {
            return Redirect::to('role/index');
        }
        $role = Role::find($id);
        $roledata = Input::all();
        $success = Role::update($id, $roledata);
        if($success) {
            //success login
            Session::flash('message', 'Success update role');
            return Redirect::to('role/index');
        } else {
            Session::flash('message_error', 'Failed update role');
            return Redirect::to('role/edit')
                ->with('id', $id);
        }
    }

    public function get_add() {
        $roledata = Session::get('role');
        return $this->layout->nest('content', 'role.add', array('role' => $roledata));
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $roledata = Input::all();
        if(!$validation->fails()) {
            $success = Role::create($roledata);
            if($success) {
                //success login
                Session::flash('message', 'Success to create new role');
                return Redirect::to('role/index');
            } else {
                Session::flash('message_error', 'Failed to create new role');
                return Redirect::to('role/add');
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('role/add')
                ->with_errors($validation)
                ->with('role', $roledata);
        }
    }

    public function get_delete($id=null) {
        if($id===null) {
            return Redirect::to('role/index');
        }
        $success = Role::remove($id);
        if($success) {
            //success login
                    Session::flash('message', 'Success to remove role');
            return Redirect::to('role/index');
        } else {
            Session::flash('message_error', 'Failed to remove role');
            return Redirect::to('role/index');
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