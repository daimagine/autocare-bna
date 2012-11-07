<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adi
 * Date: 11/7/12
 * Time: 6:57 AM
 * To change this template use File | Settings | File Templates.
 */
class Report_Finance_Controller extends Secure_Controller {


    public function __construct() {
        parent::__construct();
        Session::put('active.main.nav', 'report@dashboard@index');
    }

    public function action_index() {
        return $this->layout->nest('content', 'report.finance.index', array());
    }

    public function action_wo() {
        return $this->layout->nest('content', 'report.finance.wo.index', array());
    }

    public function action_wo_daily() {

        $criteria = array();
        if(Input::get('wo_status')!==null && Input::get('wo_status')!='') {
            $wo_status = Input::get('wo_status');
            $criteria['wo_status'] = array( '=', $wo_status );
        }
        $transaction = Transaction::finance_daily($criteria);

        Asset::add('report.finance.application', 'js/report/finance/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.finance.wo.daily', array(
            'transactions' => $transaction,
            'wo_status' => @$wo_status,
        ));
    }

}
