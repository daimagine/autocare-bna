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

    //WO REPORT

    public function action_wo() {
        return $this->layout->nest('content', 'report.finance.wo.index', array());
    }

    public function action_wo_daily() {

        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        if($startdate == null)
            $startdate = date('d-m-Y', strtotime('09/01/2012'));
        if($enddate == null)
            $enddate = date('d-m-Y');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $startdate.' 00:00:00');
        $start = $tempdate->format('Y-m-d H:i:s');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $enddate.' 23:59:59');
        $end = $tempdate->format('Y-m-d H:i:s');

        $criteria = array(
            'date' => array( 'between', $start, $end )
        );
        if(Input::get('wo_status')!==null && Input::get('wo_status')!='') {
            $wo_status = Input::get('wo_status');
            $criteria['wo_status'] = array( '=', $wo_status );
        }
        $transaction = Transaction::finance_daily($criteria);

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.finance.application', 'js/report/finance/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.finance.wo.daily', array(
            'transactions' => $transaction,
            'wo_status' => @$wo_status,
            'startdate' => $startdate,
            'enddate' => $enddate,
        ));
    }

    public function action_wo_weekly() {
        $this->wo_report_periodic();
    }

    public function action_wo_monthly() {
        $this->wo_report_periodic('MONTH');
    }

    public function wo_report_periodic($period='WEEK') {
//        dd(Input::all());

        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        if($startdate == null && $startdate == '')
            $startdate = date('d-m-Y', strtotime('09/01/2012'));
        if($enddate == null && $enddate == '')
            $enddate = date('d-m-Y');

        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $startdate.' 00:00:00');
        $start = $tempdate->format('Y-m-1 H:i:s');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $enddate.' 23:59:59');
        $end = $tempdate->format('Y-m-t H:i:s');

        $criteria = array(
            'date' => array( 'between', $start, $end )
        );
        if(Input::get('wo_status')!==null && Input::get('wo_status')!='') {
            $wo_status = Input::get('wo_status');
            $criteria['wo_status'] = array( '=', $wo_status );
        }

        if($period === 'MONTH') {
            $view = 'report.finance.wo.monthly';
            $transaction = Transaction::finance_monthly($criteria);

        } else {
            $view = 'report.finance.wo.weekly';
            $transaction = Transaction::finance_weekly($criteria);
        }

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.finance.application', 'js/report/finance/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', $view, array(
            'transactions' => $transaction,
            'wo_status' => @$wo_status,
            'startdate' => $startdate,
            'enddate' => $enddate,
        ));
    }



    // SERVICE REPORT

    public function action_service() {
        return $this->layout->nest('content', 'report.finance.service.index', array());
    }

    public function action_service_daily() {

        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        if($startdate == null)
            $startdate = date('d-m-Y', strtotime('09/01/2012'));
        if($enddate == null)
            $enddate = date('d-m-Y');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $startdate.' 00:00:00');
        $start = $tempdate->format('Y-m-d H:i:s');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $enddate.' 23:59:59');
        $end = $tempdate->format('Y-m-d H:i:s');

        $criteria = array(
            'date' => array( 'between', $start, $end )
        );
        if(Input::get('service_type')!==null && Input::get('service_type')!='') {
            $service_type = Input::get('service_type');
            $criteria['service_type'] = array( '=', $service_type );
        }
        $services = Service::finance_daily($criteria);
        $service_type_opt = Service::allSelect();

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.finance.application', 'js/report/finance/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.finance.service.daily', array(
            'services' => $services,
            'service_type' => @$service_type,
            'service_type_opt' => @$service_type_opt,
            'startdate' => $startdate,
            'enddate' => $enddate,
        ));
    }


    public function action_service_weekly() {
        $this->service_report_periodic();
    }

    public function action_service_monthly() {
        $this->service_report_periodic('MONTH');
    }

    public function service_report_periodic($period='WEEK') {
//        dd(Input::all());

        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        if($startdate == null && $startdate == '')
            $startdate = date('d-m-Y', strtotime('09/01/2012'));
        if($enddate == null && $enddate == '')
            $enddate = date('d-m-Y');

        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $startdate.' 00:00:00');
        $start = $tempdate->format('Y-m-1 H:i:s');
        $tempdate = DateTime::createFromFormat('d-m-Y H:i:s', $enddate.' 23:59:59');
        $end = $tempdate->format('Y-m-t H:i:s');

        $criteria = array(
            'date' => array( 'between', $start, $end )
        );

        if(Input::get('service_type')!==null && Input::get('service_type')!='') {
            $service_type = Input::get('service_type');
            $criteria['service_type'] = array( '=', $service_type );
        }

        if($period === 'MONTH') {
            $view = 'report.finance.service.monthly';
            $services = Service::finance_monthly($criteria);

        } else {
            $view = 'report.finance.service.weekly';
            $services = Service::finance_weekly($criteria);
        }

        $service_type_opt = Service::allSelect();

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.finance.application', 'js/report/finance/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', $view, array(
            'services' => $services,
            'service_type' => @$service_type,
            'service_type_opt' => @$service_type_opt,
            'startdate' => $startdate,
            'enddate' => $enddate,
        ));
    }


}
