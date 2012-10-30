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
        if(Input::get('type')!==null) {
            $type = Input::get('type');
            if($type === AUTOCARE_ACCOUNT_TYPE_DEBIT) {
                $criteria['type'] = array( '=', AUTOCARE_ACCOUNT_TYPE_DEBIT );
            } elseif($type === AUTOCARE_ACCOUNT_TYPE_CREDIT) {
                $criteria['type'] = array( '=', AUTOCARE_ACCOUNT_TYPE_CREDIT );
            }
        }

        $accounts = AccountTransaction::listAll($criteria);

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.account.application', 'js/report/account/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.account.daily', array(
            'accounts' => $accounts,
            'date' => $invdate,
            'type' => $type
        ));
    }

    public function action_week() {

    }

    public function action_week_selection($month=null, $year=null) {
        if($month === null) $month = date('m');
        if($year === null) $year = date('Y');

        // Current timestamp is assumed, so these find first and last day of THIS month
        $first = date("01-$month-$year"); // hard-coded '01' for first day
        $last = date("t-$month-$year");

        //dd($first. ' - ' .$last);
        $result = array($first, $last);
        return json_encode($result);
    }

}
