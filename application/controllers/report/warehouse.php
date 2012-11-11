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
        $type = Input::get('type');
        $category = Input::get('category');


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
            if ($opQryStock != null && $opQryStock != '') {
                $criteria['stock'] =  array( ($opQryStock != null && $opQryStock != '') ? $opQryStock : '=', $stock );
            }
        }
        if ($type != null && $type != '') {
            $criteria['type'] =  array( 'like', $type );
        }
        if ($category != null && $category != '' &&  $category!=0) {
            $criteria['category'] =  array( '=', $category );
        }

        $items = Item::list_report($criteria);
        $lstCategory = ItemCategory::listAll(array());
        $selectionCategory = array();
        $selectionCategory[0] = '--ALL--';
        foreach($lstCategory as $ctg) {
            $selectionCategory[$ctg->id] = $ctg->name;
        }

        $selectionType = array();
        $selectionType[0] = '--select category first--';

        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.warehouse.application', 'js/report/warehouse/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.warehouse.item', array(
            'items' => $items,
            'name' => $name,
            'code' => $code,
            'vendor' => $vendor,
            'stock' => $stock,
            'opQryStock' => $opQryStock,
            'type' => $type,
            'category' => $category,
            'lstCategory' => $selectionCategory,
            'lstType' => $selectionType,
        ));
    }

    public function action_lst_unit_type($id=null){
        if ($id===null) {
            return Redirect::to('report/warehouse/list_item');
        }
        $lstUnitType = UnitType::listAll(array(
            'item_category_id' => $id,
        ));

        $type=0;
        $selection = array();
        $selection[0] = '--ALL--';
        foreach($lstUnitType as $ctg) {
            $selection[$ctg->id] = $ctg->name;
        }
        return View::make('report.warehouse.selectboxtype', array(
            'lstType' => $selection,
            'type' => $type
        ));
    }

    public function action_history_stock_item() {
        $name = Input::get('name');
        $code = Input::get('code');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $stock = Input::get('stock');
        $type = Input::get('type');
        $category = Input::get('category');
        $invoiceNo = Input::get('invoiceNo');
        $refNum = Input::get('refNum');


        if($startDate == null)
            $startDate = date('d-m-Y', strtotime('09/01/2012'));
        if($endDate == null)
            $endDate = date('d-m-Y');
        $tempDate = DateTime::createFromFormat('d-m-Y H:i:s', $startDate.' 00:00:00');
        $start = $tempDate->format('Y-m-d H:i:s');
        $tempDate = DateTime::createFromFormat('d-m-Y H:i:s', $endDate.' 23:59:59');
        $end = $tempDate->format('Y-m-d H:i:s');

        $criteria = array(
            'date' => array( 'between', $start, $end )
        );

        if ($name != null && $name != '') {
            $criteria['name'] =  array( 'like', $name );
        }
        if ($code != null && $code != '') {
            $criteria['code'] =  array( 'like', $code );
        }
        if ($invoiceNo != null && $invoiceNo != '') {
            $criteria['invoiceNo'] =  array( 'like', $invoiceNo );
        }
        if ($refNum != null && $refNum != '') {
            $criteria['refNum'] =  array( 'like', $refNum );
        }
        if ($type != null && $type != '') {
            $criteria['type'] =  array( 'like', $type );
        }
        if ($category != null && $category != '' &&  $category!=0) {
            $criteria['category'] =  array( '=', $category );
        }

        $lstCategory = ItemCategory::listAll(array());
        $selectionCategory = array();
        $selectionCategory[0] = '--ALL--';
        foreach($lstCategory as $ctg) {
            $selectionCategory[$ctg->id] = $ctg->name;
        }

        $listStockHistory = ItemStockFlow::list_report($criteria);
        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.warehouse.application', 'js/report/warehouse/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.warehouse.stock', array(
            'name' => $name,
            'code' => $code,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'stock' => $stock,
            'invoiceNo' => $invoiceNo,
            'refNum' => $refNum,
            'type' => $type,
            'category' => $category,
            'lstCategory' => $selectionCategory,
            'listStockHistory' => $listStockHistory,
        ));
    }

    public function action_history_price_item() {
        $name = Input::get('name');
        $code = Input::get('code');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $opQryStock = Input::get('opQryStock');
        $type = Input::get('type');
        $category = Input::get('category');
        $price = Input::get('price');

        if($startDate == null)
            $startDate = date('d-m-Y', strtotime('09/01/2012'));
        if($endDate == null)
            $endDate = date('d-m-Y');
        $tempDate = DateTime::createFromFormat('d-m-Y H:i:s', $startDate.' 00:00:00');
        $start = $tempDate->format('Y-m-d H:i:s');
        $tempDate = DateTime::createFromFormat('d-m-Y H:i:s', $endDate.' 23:59:59');
        $end = $tempDate->format('Y-m-d H:i:s');

        $criteria = array(
            'date' => array( 'between', $start, $end )
        );

        if ($name != null && $name != '') {
            $criteria['name'] =  array( 'like', $name );
        }
        if ($code != null && $code != '') {
            $criteria['code'] =  array( 'like', $code );
        }
        if ($price != null && $price != '') {
            $criteria['price'] =  array( ($opQryStock != null && $opQryStock != '') ? $opQryStock : '=', $price );
        }
        if ($type != null && $type != '') {
            $criteria['type'] =  array( 'like', $type );
        }
        if ($category != null && $category != '' &&  $category!=0) {
            $criteria['category'] =  array( '=', $category );
        }

        $lstCategory = ItemCategory::listAll(array());
        $selectionCategory = array();
        $selectionCategory[0] = '--ALL--';
        foreach($lstCategory as $ctg) {
            $selectionCategory[$ctg->id] = $ctg->name;
        }


        $listPriceHistory = ItemPrice::list_report($criteria);
        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('report.warehouse.application', 'js/report/warehouse/application.js', array('jquery.timeentry'));
        return $this->layout->nest('content', 'report.warehouse.price', array(
            'name' => $name,
            'code' => $code,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'price' => $price,
            'opQryStock' => $opQryStock,
            'type' => $type,
            'category' => $category,
            'lstCategory' => $selectionCategory,
            'listPriceHistory' => $listPriceHistory,
        ));
    }
}