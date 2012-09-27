<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jojo
 * Date: 9/16/12
 * Time: 12:56 AM
 * To change this template use File | Settings | File Templates.
 */

class Item_Controller extends Secure_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
        Asset::add('jquery.validationEngine-en', 'js/plugins/forms/jquery.validationEngine-en.js',  array('jquery', 'jquery-ui'));
        Asset::add('jquery.validate', 'js/plugins/wizards/jquery.validate.js',  array('jquery', 'jquery-ui'));
        Asset::add('validationEngine.form', 'js/plugins/forms/jquery.validationEngine.js',  array('jquery', 'jquery-ui'));
        Asset::add('function_item', 'js/item/application.js',  array('jquery', 'jquery-ui'));
        Session::put('active.main.nav', 'item@index');
    }

    public function get_index() {
        $this->get_list();
    }

    public function get_list() {
        $category_id = Input::get('category'); //this id category
        $all_item_category = ItemCategory::listAll(array());
        if ($all_item_category == null) {
            Session::flash('message_error', 'System Failed (List Item Category Null)');
            return Redirect::to('/');
        }
        $item_category=null;
        if($category_id!=null) {
            foreach ($all_item_category as $c) {
                if ($c->id == $category_id ) {
                    $item_category=$c;
                }
            }
        } else {
            $item_category=$all_item_category[0];
        }
        if ($item_category==null) {
            Session::flash('message_error', 'System Failed get item category');
            return Redirect::to('/');
        }
        $criteria = array(
            'item_category_id' => $item_category->id
        );

        $this->get_items($criteria, $all_item_category ,$item_category);
    }

    public function get_items($criteria, $all_item_category, $item_category) {
        $item = Item::listAll($criteria);
        return $this->layout->nest('content', 'item.index', array(
            'item' => $item,
            'item_category' => $all_item_category,
            'category' => $item_category
        ));
    }

    public function get_add() {
        $itemdata = Session::get('item');
        $category_id = Input::get('category'); //this id category

        $all_item_category = ItemCategory::listAll(array());
        if ($all_item_category == null) {
            Session::flash('message_error', 'System Failed (List Item Category Null)');
            return Redirect::to('item/index');
        }
        $item_category=null;
        if($category_id!=null) {
            foreach ($all_item_category as $c) {
                if ($c->id == $category_id ) {
                    $item_category=$c;
                }
            }
        } else {
            $item_category=$all_item_category[0];
        }
        if ($item_category==null) {
            Session::flash('message_error', 'System Failed get item category');
            return Redirect::to('item/index');
        }
        $itemType=ItemType::listAll(array('item_category_id' => $item_category->id));
        $selectionType = array();
        foreach($itemType as $type) {
            $selectionType[$type->id] = $type->name;
        }
        $unitType=DB::table('unit_type')->get();
        $selectionUnit = array();
        foreach($unitType as $unit) {
            $selectionUnit[$unit->id] = $unit->name;
        }

        $lstSubAte=Item_Controller::get_lstSubAccountTrx(null);

        $selectionAte= array();
        if($lstSubAte!=null){
            foreach($lstSubAte as $ate) {
                $selectionAte[$ate->id] = ($ate->account_transaction->invoice_no).('-').($ate->id);
            }
        }

        return $this->layout->nest('content', 'item.add', array(
            'item' => $itemdata,
            'itemType' => $selectionType,
            'itemCategory' => $item_category,
            'allItemCategory' => $all_item_category,
            'unitType'  => $selectionUnit,
            'accountTransaction' => $selectionAte
        ));
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $itemdata = Input::all();
        if(!$validation->fails()) {
            $success = Item::create($itemdata);
            $storeItemPrice = ItemPrice::create(array('item_id' => $success));
            if($success and $storeItemPrice) {
                //success
                Session::flash('message', 'Success create');
                return Redirect::to('item/index'.'?category='.$itemdata['item_category_id']);
            } else {
                Session::flash('message_error', 'Failed create');
                return Redirect::to('item/add'.'?category='.$itemdata['item_category_id'])
                    ->with('access', $itemdata);
            }
        } else {
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
            return Redirect::to('item/add')
                ->with_errors($validation)
                ->with('access', $itemdata);
        }
    }

    public function get_edit($id=null) {
        if($id===null) {
            return Redirect::to('item/index');
        }

        $item = Item::find($id);
        $itemType=ItemType::listAll(array('item_category_id' => $item->item_category->id));
        $selectionType = array();
        foreach($itemType as $type) {
            $selectionType[$type->id] = $type->name;
        }
        $unitType=DB::table('unit_type')->get();
        $selectionUnit = array();
        foreach($unitType as $unit) {
            $selectionUnit[$unit->id] = $unit->name;
        }

        $lstSubAte=Item_Controller::get_lstSubAccountTrx(null);
        $selectionAte= array();
        if($lstSubAte!=null){
            foreach($lstSubAte as $ate) {
                $selectionAte[$ate->id] = ($ate->account_transaction->invoice_no).('-').($ate->id);
            }
        }

//        {{dd($item);}}
        return $this->layout->nest('content', 'item.edit', array(
            'item' => $item,
            'itemType' => $selectionType,
            'unitType'  => $selectionUnit,
            'accountTransaction' => $selectionAte,
            'category' => $item->item_category
        ));
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null) {
            return Redirect::to('item/index');
        }
        $item = Input::all();
        $prevPrice=Item::find($id)->price;
        if ($prevPrice !== $item['price']) {
            //get price active from DB
            $oldPrice = ItemPrice::getSingleResult(array(
                'item_id' => $id
            ));
//            {{dd($oldPrice);}}
            if ($oldPrice) {
                $updateItemPrice = ItemPrice::update($oldPrice->id, array(
                    'status' => statusType::INACTIVE
                ));
                $newPrice = ItemPrice::create(array(
                    'item_id' => $id
                ));
                if ($updateItemPrice==null || $newPrice==null) {
                    Session::flash('message_error', 'Failed update item');
                }
            }
        }

        $updateItem = Item::update($id, $item);
        if ($updateItem) {
            Session::flash('message', 'Success update item');
        }
        return Redirect::to('item/index'.'?category='.$item['item_category_id']);
    }


    private function getRules($method='add') {
        $additional = array();
        $rules = array(
            'name' => 'required|max:50',
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

    //============================= START CONTROLLER FOR APPROVED HERE ====================

    private function get_lstSubAccountTrx($id){
        $lstAte=SubAccountTrx::getByCriteria(array(
            'id' => $id,
            'approved_status' => approvedStatus::NEW_ACCOUNT_INVOICE,
            'account_trx_id' => null,
            'account_trx_status' => accountTrxStatus::AWAITING_PAYMENT
        ));
        return $lstAte;
    }

    public function get_list_approved(){
        Session::forget(ACCOUNT_TRX_ID);
        $lstSubAte=Item_Controller::get_lstSubAccountTrx(null);
        return $this->layout->nest('content', 'item.approved.list', array(
            'lstSubAte' => $lstSubAte
        ));
    }

    public function get_detail_approved($id=null) {
        Session::forget(ACCOUNT_TRX_ID);
        Session::put(ACCOUNT_TRX_ID, $id);
        if($id===null) {
            return Redirect::to('access/index');
        }
        $subAccountTrx = SubAccountTrx::find($id);
        $criteria = array(
            'sub_account_trx_id' => $subAccountTrx->id,
            'status' => array(itemStockFlowStatus::ADD_TO_LIST)
        );
        $items=ItemStockFlow::listAll($criteria);

        $all_item_category = ItemCategory::listAll(array());

        return $this->layout->nest('content', 'item.approved.detail', array(
            'items' => $items,
            'subAccountTrx' => $subAccountTrx,
            'itemCategory' => $all_item_category
        ));
    }

    public function get_lst_item($id) {
        $itemdata = Session::get('item');
        $subAccountTrxId = Session::get(ACCOUNT_TRX_ID, null);
        if($subAccountTrxId==null){
            Session::flash('message', 'System Failed');
            return Redirect::to('/');
        }
        $item_category=ItemCategory::find($id);
        $items=Item::listAll(array(
            'item_category_id' => $item_category->id
        ));
        $selectionItem = array();
        foreach($items as $item) {
            $selectionItem[$item->id] = $item->name;
        }
        return View::make('item.approved.items', array(
            'selectionItem' => $selectionItem,
            'item' => $itemdata,
            'categoryName' => $item_category->name,
            'sub_account_trx_id' => $subAccountTrxId
        ));
    }

    public function post_add_apporved_item(){
        $validation = Validator::make(Input::all(), $this->getRules());
        $subAccountTrxId = Session::get(ACCOUNT_TRX_ID, null);
        $data = Input::all();
        //        if(!$validation->fails()) {
        $success = ItemStockFlow::create($data);
        if($success) {
            //success
            //                Session::flash('message', 'Success create');
            return Redirect::to('item/detail_approved/'.$subAccountTrxId);
        } else {
            Session::flash('message_error', 'Failed create');
            return Redirect::to('item/list_approved');
        }
        //        } else {
        //            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
        return Redirect::to('item/detail_approved/'.$subAccountTrxId)
            ->with_errors($validation)
            ->with('access', $data);
        //        }
    }

    public function get_putnewitem($id){
        $itemdata = Session::get('item');
        $subAccountTrxId = Session::get(ACCOUNT_TRX_ID, null);
        if($subAccountTrxId==null){
            Session::flash('message', 'System Failed');
            return Redirect::to('/');
        }

        $item_category = ItemCategory::find($id);
        if ($item_category==null) {
            Session::flash('message_error', 'System Failed get item category');
            return Redirect::to('item/index');
        }
        $itemType=ItemType::listAll(array('item_category_id' => $item_category->id));
        $selectionType = array();
        foreach($itemType as $type) {
            $selectionType[$type->id] = $type->name;
        }
        $unitType=DB::table('unit_type')->get();
        $selectionUnit = array();
        foreach($unitType as $unit) {
            $selectionUnit[$unit->id] = $unit->name;
        }

        return View::make('item.approved.additem', array(
            'item' => $itemdata,
            'itemType' => $selectionType,
            'unitType'  => $selectionUnit,
            'itemCategory' => $item_category,
            'sub_account_trx_id' => $subAccountTrxId
        ));
    }

    public function post_putnewitem(){
        $validation = Validator::make(Input::all(), $this->getRules());
        $subAccountTrxId = Session::get(ACCOUNT_TRX_ID, null);
        $itemdata = Input::all();
        $itemdata = $itemdata;
        if(!$validation->fails()) {
            $success = Item::create($itemdata);
            $insertStokFlow = ItemStockFlow::create(array(
                'item_id' => $success,
                'sub_account_trx_id' => $subAccountTrxId,
                'quantity' => $itemdata['stock']
            ));
            if($success && $insertStokFlow) {
                Session::flash('message', 'Success Update');
            } else {
                Session::flash('message_error', 'Failed create item');
            }
        } else {
            Session::flash('message_error', 'Failed create');
            Log::info('Validation fails. error : ' + print_r($validation->errors, true));
        }
        return Redirect::to('item/detail_approved/'.$subAccountTrxId);
    }

    public function post_approved_action() {
        $action = Input::get('action'); //this action type
        $subAccountTrxId = Session::get(ACCOUNT_TRX_ID, null);
        $criteria = array(
            'sub_account_trx_id' => $subAccountTrxId,
            'status' => array(itemStockFlowStatus::ADD_TO_LIST)
        );
        $item =null;
        $listItemStockFlow = ItemStockFlow::listAll($criteria);
        $subAccountTrx = SubAccountTrx::find($subAccountTrxId);

        if ($listItemStockFlow!=null) {
            if ($action == 'confirm') {
                foreach($listItemStockFlow as $itemStockFlow){
                    //update item
                    $item = Item::find($itemStockFlow->item->id);
                    $countStock = ($item->stock) + ($itemStockFlow->quantity);
                    if(Item::updateStock($item->id, $countStock)) {
                        //success update item stock
                    }
                    //update item stock flow
                    if(ItemStockFlow::updateStatus($itemStockFlow->id, itemStockFlowStatus::CONFIRM_ADDITIONAL)) {
                        //success update item stock flow status
                    }

                }
                $subAccountTrx->approved_status = approvedStatus::CONFIRM_BY_WAREHOUSE;
            } else if ($action = 'reject') {
                foreach($listItemStockFlow as $itemStockFlow){
                    //update item stock flow
                }
                if(ItemStockFlow::updateStatus($itemStockFlow->id, itemStockFlowStatus::CANCEL)) {
                    //success update item stock flow status
                }
                $subAccountTrx->approved_status = approvedStatus::REVIEW_BY_WAREHOUSE;
            }
            if(SubAccountTrx::updateStatus($subAccountTrx->id, $subAccountTrx->approved_status)) {
                //success update sub account trx
            }
        }
        return Redirect::to('item/list_approved');
    }



    //============================= START CONTROLLER FOR MENU HISTORY ====================
    public function get_list_history() {
        $category_id = Input::get('category'); //this id category
        $all_item_category = ItemCategory::listAll(array());
        if ($all_item_category == null) {
            Session::flash('message_error', 'System Failed (List Item Category Null)');
            return Redirect::to('/');
        }
        $item_category=null;
        if($category_id!=null) {
            foreach ($all_item_category as $c) {
                if ($c->id == $category_id ) {
                    $item_category=$c;
                }
            }
        } else {
            $item_category=$all_item_category[0];
        }
        if ($item_category==null) {
            Session::flash('message_error', 'System Failed get item category');
            return Redirect::to('/');
        }
        $criteria = array(
            'item_category_id' => $item_category->id,
            'status' => array(statusType::ACTIVE, statusType::INACTIVE),
        );

        //----call query get list item_price-----//
        $listItemPrice = ItemPrice::listAll(array(
           'item_category_id' => $item_category->id,
            'status' => array(statusType::ACTIVE, statusType::INACTIVE)
        ));

        //----call query get item stock flow-----//
        $listItemStockFlow=ItemStockFlow::listAll(array(
            'item_category_id' => $item_category->id,
            'status' => array(itemStockFlowStatus::ADD_TO_LIST, itemStockFlowStatus::CONFIRM_ADDITIONAL)
        ));
        return $this->layout->nest('content', 'item.history', array(
            'listItemPrice' => $listItemPrice,
            'listItemStokFlow' => $listItemStockFlow,
            'item_category' => $all_item_category,
            'category' => $item_category
        ));
    }


}