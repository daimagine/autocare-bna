<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adikurniawan
 * Date: 9/15/12
 * Time: 3:38 AM
 *
 */
class Cube extends \Laravel\Auth\Drivers\Eloquent {

    public $navigation = array();

    /**
     * Attempt to log a user into the application.
     *
     * @param  array $arguments
     * @return void
     */
    public function attempt($arguments = array())
    {
        $user = $this->model()->where(function($query) use($arguments)
        {
            $username = Config::get('auth.username');

            $query->where($username, '=', $arguments['username']);

            foreach(array_except($arguments, array('username', 'password', 'remember')) as $column => $val)
            {
                $query->where($column, '=', $val);
            }
        })->first();

        // If the credentials match what is in the database we will just
        // log the user into the application and remember them if asked.
        $password = $arguments['password'];

        $password_field = Config::get('auth.password', 'password');

        if ( ! is_null($user) and Hash::check($password, $user->get_attribute($password_field)))
        {
            Session::put('auth.user.role.access', $this->getNavigation($user));
            return $this->login($user->id, array_get($arguments, 'remember'));
        }

        return false;
    }

    public function navigation() {
        if(Session::has('auth.user.role.access'))
            return Session::get('auth.user.role.access');
        return $this->navigation;
    }

    public function getNavigation($user) {
        $navMenu = array(
            0 => array(
                'title'  => 'Dashboard',
                'action' => 'home@index',
                'image'  => '',
                'childs' => null
            )
        );
        $navigation = Role::getAccessRole($user);
        foreach($navigation as $nav) {
            //if main navigation
            if($nav->type === 'M') {
                $navMenu[$nav->id] = array(
                        'title'  => $nav->name,
                        'action' => $nav->action,
                        'image'  => '',
                        'childs' => null
                    );
            } else {
                $tempMain = array_get($navMenu, $nav->parent_id);
                $tempMain['childs'][$nav->id] = array(
                    'title'  => $nav->name,
                    'action' => $nav->action,
                    'image'  => $nav->image
                );
                $navMenu[$nav->parent_id] = $tempMain;
            }
        }

//        foreach($navMenu as $menu) {
//            echo $menu['title'].'<br>';
//            if($menu['childs'] != null) {
//                foreach($menu['childs'] as $child) {
//                    echo '  - '. $child['title'].'<br>';
//                }
//            }
//        }
        return $navMenu;
    }

    public function navModel() {
        $model = Config::get('auth.navigation');
        return new $model;
    }

    public function has_permissions() {
        $uri = URI::current();
        $val = in_array($uri, Config::get('auth.white_list'));
        if($val)
            return true;
        return $this->model()->check_permission(Auth::user(), $uri);
    }

}
