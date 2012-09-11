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
        $message = Session::get('message');
        $message_class = Session::get('message_class');
        $criteria = array();
        $roles = Role::listAll($criteria);
        return View::make('role.index')
            ->with('message_class', $message_class)
            ->with('message', $message)
            ->with('roles', $roles);
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('role/index');
        }
        $message = Session::get('message');
        $message_class = Session::get('message_class');
        $role = Role::find($id);
        return View::make('role.edit')
            ->with('message_class', $message_class)
            ->with('message', $message)
            ->with('role', $role);
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null) {
            return Redirect::to('role/index');
        }
        $role = Role::find($id);
        $roledata = Input::all();
        $success = Role::update($id, $roledata);
        if($success) {
            //success login
            return Redirect::to('role/index')
                ->with('message', 'Success to update role')
                ->with('message_class', 'success');
        } else {
            return Redirect::to('role/edit')
                ->with('message', 'Failed to update role')
                ->with('message_class', 'error')
                ->with('id', $id);
        }
    }

    public function get_add() {
        $message = Session::get('message');
        $message_class = Session::get('message_class');
        $roledata = Session::get('role');
        return View::make('role.add')
            ->with('message_class', $message_class)
            ->with('message', $message)
            ->with('role', $roledata);
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $roledata = Input::all();
        if(!$validation->fails()) {
            $success = Role::create($roledata);
            if($success) {
                //success login
                return Redirect::to('role/index')
                    ->with('message', 'Success to create new role')
                    ->with('message_class', 'success');
            } else {
                return Redirect::to('role/add')
                    ->with('message', 'Failed to create new role')
                    ->with('message_class', 'error')
                    ->with('role', $roledata);
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
            return Redirect::to('role/index')
                ->with('message', 'Success to remove role')
                ->with('message_class', 'success');
        } else {
            return Redirect::to('role/index')
                ->with('message', 'Failed to remove role')
                ->with('message_class', 'error');
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