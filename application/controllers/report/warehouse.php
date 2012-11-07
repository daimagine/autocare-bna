<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 11/7/12
 * Time: 1:00 AM
 * To change this template use File | Settings | File Templates.
 */
class Report_Warehouse_Controller extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        Session::put('active.main.nav', 'report@dashboard@index');
    }

    public function action_index() {
        return $this->layout->nest('content', 'report.warehouse.index', array());
    }

    public function action_list_item() {
        $name = Input::get('name');
        $code = Input::get('code');
        $vendor = Input::get('vendor');
        $opQryStock = Input::get('opQryStock');
        $stock = Input::get('stock');

        $criteria = array();
        if ($name != null && $name != '') {
            $criteria['name'] =  array( 'like', $name );
        }
        if ($code != null && $code != '') {
            $criteria['code'] =  array( 'like', $code );
        }
        if ($vendor != null && $vendor != '') {
            $criteria['vendor'] =  array( 'like', $vendor );
        }
        if ($stock != null && $stock != '') {
            $criteria['stock'] =  array( ($opQryStock != null && $opQryStock != '') ? $opQryStock : '=', $stock );
            if ($opQryStock != null && $opQryStock != '') {

            }
        }

        $items = Item::list_report($criteria);
//        {dd($items);}
        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.warehouse.application', 'js/report/warehouse/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.warehouse.item', array(
            'items' => $items,
            'name' => $name,
            'code' => $code,
            'vendor' => $vendor,
            'stock' => $stock,
            'opQryStock' => $opQryStock,

        ));
    }

    public function action_history_stock_item() {
        return $this->layout->nest('content', 'report.warehouse.stock', array());
    }

    public function action_history_price_item() {
        return $this->layout->nest('content', 'report.warehouse.price', array());
    }
}