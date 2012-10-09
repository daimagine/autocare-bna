<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/28/12
 * Time: 2:18 AM
 * To change this template use File | Settings | File Templates.
 */
class Work_Order_Controller extends Secure_Controller
{

    public $restful = true;

    public function __construct() {
        parent::__construct();
        Session::put('active.main.nav', 'work_order@index');
    }

    public function get_index() {
        return$this->get_list();
    }

    public function get_list() {
        Asset::add('function_item', 'js/item/confirmation.js',  array('jquery', 'jquery-ui'));
        $transactions = Transaction::list_all(array(
            'status' => array(
                statusWorkOrder::OPEN, statusWorkOrder::CLOSE, statusWorkOrder::CANCELED
            )
        ));

//        {{dd($transactions);}}
        return $this->layout->nest('content', 'wo.list', array(
            'transactions' => $transactions
        ));
    }

    public function get_add() {
        Asset::add('jquery.validationEngine-en', 'js/plugins/forms/jquery.validationEngine-en.js',  array('jquery', 'jquery-ui'));
        Asset::add('jquery.validate', 'js/plugins/wizards/jquery.validate.js',  array('jquery', 'jquery-ui'));
        Asset::add('validationEngine.form', 'js/plugins/forms/jquery.validationEngine.js',  array('jquery', 'jquery-ui'));
        Asset::add('function_item', 'js/wo/application.js',  array('jquery', 'jquery-ui'));
        $customer = Session::get('customer');
        $service = Session::get('service');
        $mechanic = Session::get('mechanic');

        //------------get service list---------------------//
        $lstService = Service::list_all(array(
            'status' => array(statusType::ACTIVE)
        ));
        $selectionService = array();
        $selectionService[0] = '-- select service --';
        foreach($lstService as $srv) {
            $selectionService[$srv->id] = $srv->name;
        }

        //------------GET MECHANIC----------------------//
        $lstMechanic=User::listByCiteria(array(
           'role_id' => 4
        ));

        $selectionMechanic = array();
        $selectionMechanic[0] = '-- select service --';
        foreach($lstMechanic as $mch) {
            $selectionMechanic[$mch->id] = $mch->name;
        }


        return $this->layout->nest('content', 'wo.add', array(
            'customers' => $customer,
            'selectionService' => $selectionService,
            'lstService' => $lstService,
            'service' => $service,
            'selectionMechanic' => $selectionMechanic,
            'mechanic' => $mechanic
        ));
    }


    private function define_asset(){
        Asset::add('style', 'css/styles.css');
        Asset::add('jquery', 'js/jquery.min.js');
        Asset::add('jquery-ui', 'js/jquery-ui.min.js', array('jquery'));
        Asset::add('jquery-uniform', 'js/plugins/forms/jquery.uniform.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.dataTables', 'js/plugins/tables/jquery.dataTables.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.sortable', 'js/plugins/tables/jquery.sortable.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.resizable', 'js/plugins/tables/jquery.resizable.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.collapsible', 'js/plugins/ui/jquery.collapsible.min.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.breadcrumbs', 'js/plugins/ui/jquery.breadcrumbs.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.tipsy', 'js/plugins/ui/jquery.tipsy.js', array('jquery', 'jquery-ui'));
        Asset::add('bootstrap-js', 'js/bootstrap.js', array('jquery-uniform'));
        Asset::add('application-js', 'js/application.js', array('jquery-uniform'));
    }

    public function get_lst_customer() {
       //get list customer by vehicle
        Work_Order_Controller::define_asset();
        $lstVehicle = Vehicle::listAll(array());
        return View::make('wo.modal.customer', array(
            'lstVehicle' => $lstVehicle
        ));
    }

    public function get_lst_items() {
        //get list items
        Work_Order_Controller::define_asset();
        $lstItemCategory = ItemCategory::listAll(null);
        $lstItems = Item::listAll(array());
//        {{dd($date);}}
        return View::make('wo.modal.items', array(
            'lstItemCategory' => $lstItemCategory,
            'lstItems' => $lstItems
        ));
    }

    public function post_add(){
        $validation = Validator::make(Input::all(), $this->getRules());
        $wodata = Input::all();

        if(!$validation->fails()) {
            //=== check status customer ===//
            if($wodata['customerId']==null or $wodata['customerId']==''){
                //thisis new customer & new vehicle
                $customer = Customer::create(array(
                    'name' => $wodata['customerName'],
                    'status' => 1
                ));
                $wodata['customerId'] = $customer;
            }

            if($wodata['vehiclesid']==null or $wodata['vehiclesid']=='' or $wodata['vehiclesid']==0){
                    $vehicle = Vehicle::create(array(
                    'customer_id' => $wodata['customerId'],
                    'status' => statusType::ACTIVE,
                    'number' => $wodata['vehiclesnumber'],
                    'type' => $wodata['vehiclestype'],
                    'color' => $wodata['vehiclescolor'],
                    'model' => $wodata['vehiclesmodel'],
                    'brand' => $wodata['vehiclesbrand'],
                    'description' => $wodata['vehiclesdescription']
                ));

                if($vehicle) {
                    //success create new vehicle
                    $wodata['vehiclesid'] = $vehicle;
                }
            } else {
                $vehicle = Vehicle::getSingleResult(array(
                    'customer_id' => $wodata['customerId'],
                    'vehicle_number' => $wodata['vehiclesnumber']
                ));//TEMPORARY MAKE SURE KE ADI RELASI CUSTOMER DGN VEHICLE (1 to 1 / 1 to m)
                $wodata['vehiclesid'] = $vehicle->id;
            }

            $success = Transaction::create($wodata);
            if($success) {
                //success
                Session::flash('message', 'Success add wo');
                return Redirect::to('work_order/list');
            } else {
                Session::flash('message_error', 'Failed add wo');
                return Redirect::to('work_order/add');
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('work_order/add')
                ->with_errors($validation);
        }
    }


    //GET DETAIL
    public function get_detail($id=null){
        if ($id===null) {
            return Redirect::to('work_order/list');
        }


        $transaction = Transaction::get_detail_trx($id);
        return $this->layout->nest('content', 'wo.detail', array(
            'transaction' => $transaction
        ));
    }

    //GET UPDATE or EDIT
    public function get_edit($id=null){
        if ($id===null) {
            return Redirect::to('work_order/list');
        }

        Asset::add('jquery.validationEngine-en', 'js/plugins/forms/jquery.validationEngine-en.js',  array('jquery', 'jquery-ui'));
        Asset::add('jquery.validate', 'js/plugins/wizards/jquery.validate.js',  array('jquery', 'jquery-ui'));
        Asset::add('validationEngine.form', 'js/plugins/forms/jquery.validationEngine.js',  array('jquery', 'jquery-ui'));
        Asset::add('function_item', 'js/wo/application.js',  array('jquery', 'jquery-ui'));

        $transaction = Transaction::get_detail_trx($id);
//        {{dd($transaction);}}
        //------------get service list---------------------//
        $lstService = Service::list_all(array(
            'status' => array(statusType::ACTIVE)
        ));
        $selectionService = array();
        $selectionService[0] = '-- select service --';
        foreach($lstService as $srv) {
            $selectionService[$srv->id] = $srv->name;
        }

        //------------GET MECHANIC----------------------//
        $lstMechanic=User::listAll(array(
            'role_id' => 4
        ));

        $selectionMechanic = array();
        $selectionMechanic[0] = '-- select service --';
        foreach($lstMechanic as $mch) {
            $selectionMechanic[$mch->id] = $mch->name;
        }


        return $this->layout->nest('content', 'wo.update', array(
            'selectionService' => $selectionService,
            'lstService' => $lstService,
            'selectionMechanic' => $selectionMechanic,
            'transaction' => $transaction

        ));
    }


    public function post_edit(){
        $validation = Validator::make(Input::all(), $this->getRules());
        $wodata = Input::all();
        $id = $wodata['id'];
        if ($id === null) {
            return Redirect::to('work_order/list');
        }
//        $serviceFormulaId=array();
//        $no=0;
//        foreach($wodata['services'] as $s){
//            $serviceFormulaId[$no] = $s['service_formula_id'];
//            $no++;
//        }
//        {{dd($wodata);}}
        if(!$validation->fails()) {
            //=== check status customer ===//
            if($wodata['customerId']==null or $wodata['customerId']==''){
                //thisis new customer & new vehicle
                $customer = Customer::create(array(
                    'name' => $wodata['customerName'],
                    'status' => 1
                ));
                $wodata['customerId'] = $customer;
            }

            if($wodata['vehiclesid']==null or $wodata['vehiclesid']=='' or $wodata['vehiclesid']==0){
                $vehicle = Vehicle::create(array(
                    'customer_id' => $wodata['customerId'],
                    'status' => statusType::ACTIVE,
                    'number' => $wodata['vehiclesnumber'],
                    'type' => $wodata['vehiclestype'],
                    'color' => $wodata['vehiclescolor'],
                    'model' => $wodata['vehiclesmodel'],
                    'brand' => $wodata['vehiclesbrand'],
                    'description' => $wodata['vehiclesdescription']
                ));

                if($vehicle) {
                    //success create new vehicle
                    $wodata['vehiclesid'] = $vehicle;
                }
            } else {
                $vehicle = Vehicle::getSingleResult(array(
                    'customer_id' => $wodata['customerId'],
                    'vehicle_number' => $wodata['vehiclesnumber']
                ));//TEMPORARY MAKE SURE KE ADI RELASI CUSTOMER DGN VEHICLE (1 to 1 / 1 to m)
                $wodata['vehiclesid'] = $vehicle->id;
            }

            $success = Transaction::update($id, $wodata);
            if($success) {
                //success
                Session::flash('message', 'Success update wo');
                return Redirect::to('work_order/list');
            } else {
                Session::flash('message_error', 'Failed update wo');
                return Redirect::to('work_order/edit/'.$id);
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('work_order/edit/'.$id)
                ->with_errors($validation);
        }
    }
    //=======================RULES INPUT============================//
    private function getRules($method='add') {
        $additional = array();
        $rules = array(
            'customerName' => 'required|max:50',
            'vehiclesid' => 'required',
            'services' => 'required',
            'users' => 'required'
        );
        if($method == 'add') {
            $additional = array(
            );
        } elseif($method == 'edit') {
            $additional = array(
            );
        }
        return array_merge($rules, $additional);
    }
}
