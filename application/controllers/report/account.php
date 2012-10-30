<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adi
 * Date: 10/30/12
 * Time: 12:40 PM
 * To change this template use File | Settings | File Templates.
 */
class Report_Account_Controller extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        Session::put('active.main.nav', 'report@dashboard@index');
    }

    public function action_index() {
        return $this->layout->nest('content', 'report.account.index', array());
    }

    public function action_day() {
        //dd(Input::all());

        $invdate = Input::get('date');
        if($invdate == null)
            $invdate = date('d-m-Y');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $invdate.' 00:00:00');
        $start = $tempdate->format('Y-m-d H:i:s');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $invdate.' 23:59:59');
        $end = $tempdate->format('Y-m-d H:i:s');

        $criteria = array(
            'paid_date' => array( 'not_null', '' ),
            'input_date' => array( 'within', $start, $end )
        );

        $accounts = AccountTransaction::listAll($criteria);

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.account.application', 'js/report/account/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.account.daily', array(
            'accounts' => $accounts,
            'date' => $invdate,
        ));
    }

}
