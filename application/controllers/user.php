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
        $message = Session::get('message');
        $message_class = Session::get('message_class');
        $criteria = array();
        $users = User::listAll($criteria);
        return View::make('user.index')
            ->with('message_class', $message_class)
            ->with('message', $message)
            ->with('users', $users);
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('user/index');
        }
        $message = Session::get('message');
        $message_class = Session::get('message_class');
        $user = User::find($id);
        $roles = Role::allSelect();
        return View::make('user.edit')
            ->with('message_class', $message_class)
            ->with('message', $message)
            ->with('user', $user)
            ->with('roles', $roles);
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
            return Redirect::to('user/index')
                ->with('message', 'Success to update user')
                ->with('message_class', 'success');
        } else {
            return Redirect::to('user/edit')
                ->with('message', 'Failed to update user')
                ->with('message_class', 'error')
                ->with('id', $id);
        }
    }

    public function get_add() {
        $message = Session::get('message');
        $message_class = Session::get('message_class');
        $userdata = Session::get('user');
        $roles = Role::allSelect();
        return View::make('user.add')
            ->with('message_class', $message_class)
            ->with('message', $message)
            ->with('user', $userdata)
            ->with('roles', $roles);
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $userdata = Input::all();
        if(!$validation->fails()) {
            $success = User::create($userdata);
            if($success) {
                //success login
                return Redirect::to('user/index')
                    ->with('message', 'Success to create new user')
                    ->with('message_class', 'success');
            } else {
                return Redirect::to('user/add')
                    ->with('message', 'Failed to create new user')
                    ->with('message_class', 'error')
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
            return Redirect::to('user/index')
                ->with('message', 'Success to remove user')
                ->with('message_class', 'success');
        } else {
            return Redirect::to('user/index')
                ->with('message', 'Failed to remove user')
                ->with('message_class', 'error');
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