<?php

class Home_Controller extends Secure_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/


    public function __construct() {
        parent::__construct();
    }

    public function action_index() {
        $members = Member::recent();
        $news = News::recent();
        $item_prices = ItemPrice::recent();
        $settlements = Settlement::summaryDashboard();
        Asset::add('home.application', 'js/home/application.js', array('jquery'));
        return $this->layout->nest('content', 'home.dashboard', array(
            'news' => $news,
            'members' => $members,
            'item_prices' => $item_prices,
            'settlements' => $settlements
        ));
	}

    public function action_sandbox() {
        Asset::add('home.application', 'js/home/sandbox.js', array('jquery', 'charts.highcharts'));
        return $this->layout->nest('content', 'home.sandbox', array() );
    }

}