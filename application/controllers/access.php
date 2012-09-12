<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/13/12
 * Time: 12:35 AM
 * To change this template use File | Settings | File Templates.
 */
class Access_Controller extends Secure_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        $criteria = array();
        $accesss = Access::listAll($criteria);
        return View::make('access.index')
            ->with('accesss', $accesss);
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('access/index');
        }
        $access = Access::find($id);
        $accesses = Access::allSelect($id);
        return View::make('access.edit')
            ->with('access', $access)
            ->with('accesses', $accesses);
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null) {
            return Redirect::to('access/index');
        }
        $access = Access::find($id);
        $accessdata = Input::all();
        $success = Access::update($id, $accessdata);
        if($success) {
            //success edit
            Session::flash('message', 'Success update');
            return Redirect::to('access/index');
        } else {
            Session::flash('message_error', 'Failed update');
            return Redirect::to('access/edit')
                ->with('id', $id);
        }
    }

    public function get_add() {
        $accessdata = Session::get('access');
        $accesses = Access::allSelect();
        return View::make('access.add')
            ->with('access', $accessdata)
            ->with('accesses', $accesses);
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $accessdata = Input::all();
        if(!$validation->fails()) {
            $success = Access::create($accessdata);
            if($success) {
                //success
                Session::flash('message', 'Success create');
                return Redirect::to('access/index');
            } else {
                Session::flash('message_error', 'Failed create');
                return Redirect::to('access/add')
                    ->with('access', $accessdata);
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('access/add')
                ->with_errors($validation)
                ->with('access', $accessdata);
        }
    }

    public function get_delete($id=null) {
        if($id===null) {
            return Redirect::to('access/index');
        }
        $success = Access::remove($id);
        if($success) {
            //success
            Session::flash('message', 'Remove success');
            return Redirect::to('access/index');
        } else {
            Session::flash('message_error', 'Remove failed');
            return Redirect::to('access/index');
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
