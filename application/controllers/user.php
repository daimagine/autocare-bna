<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/10/12
 * Time: 1:34 AM
 * To change this template use File | Settings | File Templates.
 */

class User_Controller extends Secure_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
        $this->filters = array();
        $this->filter('before', 'auth')->except(array('login', 'logout'));
        Session::put('active.main.nav', 'user@index');
    }

    public function get_login() {
        if (Auth::check()) {
            return Redirect::to('/');
        }
        Asset::add('login', 'js/login.js', array('jquery', 'jquery-ui'));
        return View::make('user.login');
    }

    public function post_login() {
        if (Auth::check()) {
            return Redirect::to('/');
        }
        $rules = array(
            'login' => 'required|max:50',
            'password' => 'required|max:50'
        );
        $validation = Validator::make(Input::all(), $rules);
        if(!$validation->fails()) {
            $userdata = array(
                'username' => Input::get('login'),
                'password' => Input::get('password')
            );

            if(Auth::attempt($userdata)) {
                //success login
                return Redirect::to('/');
            } else {
                return Redirect::to('login')
                    ->with('message', 'Failed to authenticate')
                    ->with('message_class', 'error');
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('login')->with_errors($validation);
        }
    }

    public function get_logout() {
        Auth::logout();
        return Redirect::to('login');
    }

    public function get_index() {
        $this->get_list();
    }

    public function get_list() {
        $criteria = array();
        $users = User::listAll($criteria);
        return $this->layout->nest('content', 'user.index', array(
            'users' => $users
        ));
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('user/index');
        }
        $user = User::find($id);
        $roles = Role::allSelect();
        return $this->layout->nest('content', 'user.edit', array(
            'roles' => $roles,
            'user'=> $user));
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null) {
            return Redirect::to('user/index');
        }
        $user = User::find($id);
        $userdata = Input::all();
        $success = User::update($id, $userdata);
        if($success) {
            //success login
            Session::flash('message', 'Success update user');
            return Redirect::to('user/index');
        } else {
            Session::flash('message_error', 'Failed to update user');
            return Redirect::to('user/edit')->with('id', $id);
        }
    }

    public function get_add() {
        $userdata = Session::get('user');
        $roles = Role::allSelect();
        return $this->layout->nest('content', 'user.add', array(
            'roles' => $roles,
            'user', $userdata));
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $userdata = Input::all();
        if(!$validation->fails()) {
            $success = User::create($userdata);
            if($success) {
                //success login
                Session::flash('message', 'Success to create new user');
                return Redirect::to('user/index');
            } else {
                Session::flash('message_error', 'Failed to create new user');
                return Redirect::to('user/add')
                    ->with('user', $userdata);
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('user/add')
                ->with_errors($validation)
                ->with('user', $userdata);
        }
    }

    public function get_delete($id=null) {
        if($id===null) {
            return Redirect::to('user/index');
        }
        $success = User::remove($id);
        if($success) {
            //success login
            Session::flash('message', 'Success to remove user');
            return Redirect::to('user/index');
        } else {
            Session::flash('message_error', 'Failed to remove user');
            return Redirect::to('user/index');
        }
    }

    private function getRules($method='add') {
        $additional = array();
        $rules = array(
            'login_id' => 'required|max:50',
            'staff_id' => 'required|max:50',
            'status' => 'required'
        );
        if($method == 'add') {
            $additional = array(
                'password' => 'required|min:5|max:50'
            );
        } elseif($method == 'edit') {
            $additional = array(
            );
        }
        return array_merge($rules, $additional);
    }

}