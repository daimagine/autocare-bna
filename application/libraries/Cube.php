<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adikurniawan
 * Date: 9/15/12
 * Time: 3:38 AM
 *
 */
class Cube extends Laravel\Auth\Drivers\Eloquent {

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
            $this->navigation = $this->getNavigation($user);
            return $this->login($user->id, array_get($arguments, 'remember'));
        }

        return false;
    }

    public function navigation() {
        return $this->navigation;
    }

    public function getNavigation($user) {
        $navigation = $this->navModel()->where(
            function($query) use($user) {
                $query->where('type', '=', 'M');
                $query->or_where('type', '=', 'L');
                $query->where('status', '=', 1);
            }
        )->get();
        foreach($navigation as $nav) {

        }
        return $navigation;
    }

    public function navModel() {
        $model = Config::get('auth.navigation');
        return new $model;
    }

}
