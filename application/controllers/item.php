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
            'item_category_name' => $item_category->name
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
        return $this->layout->nest('content', 'item.add', array(
            'item' => $itemdata,
            'itemType' => $selectionType,
            'itemCategory' => $item_category,
            'allItemCategory' => $all_item_category,
            'unitType'  => $selectionUnit
        ));
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $itemdata = Input::all();
        if(!$validation->fails()) {
            $success = Item::create($itemdata);
            if($success) {
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

//        $criteria = array(
//            'item_category_id' => $item_category->id
//        );


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
}