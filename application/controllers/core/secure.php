<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/10/12
 * Time: 2:48 AM
 * To change this template use File | Settings | File Templates.
 */
class Secure_Controller extends Controller {

    public $layout = 'layout.base';

    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param  string    $method
     * @param  array     $parameters
     * @return Response
     */
    public function __call($method, $parameters)
    {
        return Response::error('404');
    }

    public function __construct() {
        parent::__construct();
        $this->filter('before', 'auth');

        Asset::add('style', 'css/styles.css');
        Asset::add('jquery', 'js/jquery.min.js');
        Asset::add('jquery-ui', 'js/jquery-ui.min.js', array('jquery'));
        Asset::add('jquery-uniform', 'js/plugins/forms/jquery.uniform.js', array('jquery', 'jquery-ui'));
        Asset::add('application-js', 'js/application.js', array('jquery-uniform'));
    }

}