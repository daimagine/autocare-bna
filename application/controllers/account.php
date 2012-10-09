<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/18/12
 * Time: 03:35 AM
 */
class Account_Controller extends Secure_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
        Session::put('active.main.nav', 'account@index');
    }

    public function get_index() {
        $this->get_list();
    }

    public function get_list() {
        $criteria = array();
        $account = Account::listAll($criteria);
        return $this->layout->nest('content', 'account.index', array(
            'account' => $account
        ));
    }

    public function get_edit($id=null) {
        $id !== null ? $id : Input::get('id');
        if($id===null) {
            return Redirect::to('account/index');
        }
        $account = Account::find($id);
        return $this->layout->nest('content', 'account.edit', array(
            'account' => $account,
        ));
    }

    public function post_edit() {
        $id = Input::get('id');
        if($id===null) {
            return Redirect::to('account/index');
        }
        $validation = Validator::make(Input::all(), $this->getRules());
        $accountdata = Input::all();
        if(!$validation->fails()) {
            $success = Account::update($id, $accountdata);
            if($success) {
                //success edit
                Session::flash('message', 'Success update');
                return Redirect::to('account/index');
            } else {
                Session::flash('message_error', 'Failed update');
                return Redirect::to_action('account@edit', array($id));
            }
        } else {
            return Redirect::to_action('account@edit', array($id))
                ->with_errors($validation);
        }
    }

    public function get_add() {
        $accountdata = Session::get('account');
        return $this->layout->nest('content', 'account.add', array(
            'account' => $accountdata,
        ));
    }

    public function post_add() {
        $validation = Validator::make(Input::all(), $this->getRules());
        $accountdata = Input::all();
        if(!$validation->fails()) {
            $success = Account::create($accountdata);
            if($success) {
                //success
                Session::flash('message', 'Success create');
                return Redirect::to('account/index');
            } else {
                Session::flash('message_error', 'Failed create');
                return Redirect::to('account/add')
                    ->with('account', $accountdata);
            }
        } else {
            return Redirect::to('account/add')
                ->with_errors($validation)
                ->with('account', $accountdata);
        }
    }

    public function get_delete($id=null) {
        if($id===null) {
            return Redirect::to('account/index');
        }
        $success = Account::remove($id);
        if($success) {
            //success
            Session::flash('message', 'Remove success');
            return Redirect::to('account/index');
        } else {
            Session::flash('message_error', 'Remove failed');
            return Redirect::to('account/index');
        }
    }

    private function getRules($method='add') {
        $additional = array();
        $rules = array(
            'name' => 'required|min:5|max:50',
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

    /**
     * @param string $type
     */
    public function get_invoice_in($type=AUTOCARE_ACCOUNT_TYPE_DEBIT) {
        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.ui.mousewheel', 'js/plugins/forms/jquery.mousewheel.js', array('jquery'));
		Asset::add('role.application', 'js/account/account_transaction/application.js', array('jquery.timeentry'));
        $invoiceNumber = AccountTransaction::invoice_new();
        $data = Session::get('accountTrans');
        $accounts = Account::allSelect();
        return $this->layout->nest('content', 'account.account_transaction.add', array(
            'accountTrans' => $data,
            'accountTransType' => $type,
            'invoiceNumber' => $invoiceNumber,
            'accounts'  => $accounts
        ));
    }

    public function post_invoice_in() {
        $validation = Validator::make(Input::all(), $this->getInvoiceRules());
        $data = Input::all();
        $type = @$data['type'];
        if(!$validation->fails()) {
            $success = AccountTransaction::create($data);
            if($success) {
                //success
                Session::flash('message', 'Success create invoice ' . $data['invoice_no']);
                if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                    return Redirect::to('account/account_receivable');
                else
                    return Redirect::to('account/account_payable');
            } else {
                Session::flash('message_error', 'Failed create');
                return Redirect::to_action('account@invoice_in', array( $type ))
                    ->with_input();
            }
        } else {
            return Redirect::to_action('account@invoice_in', array( $type ))
                ->with_errors($validation)
                ->with_input();
        }
    }

    public function get_account_receivable($type=null) {
        $criteria = array(
            'type' => array('=', AUTOCARE_ACCOUNT_TYPE_DEBIT)
        );
        if($type === 'paid')
            $criteria['paid_date'] = array( 'not_null', '' );
        elseif($type === 'unpaid')
            $criteria['paid_date'] = array( 'null', '' );
        $accounts = AccountTransaction::listAll($criteria);

        return $this->layout->nest('content', 'account.account_transaction.receivable', array(
            'accounts' => $accounts,
            'accountTransType' => AUTOCARE_ACCOUNT_TYPE_DEBIT,
        ));
    }


    public function get_account_payable($type=null) {
        $criteria = array(
            'type' => array('=', AUTOCARE_ACCOUNT_TYPE_CREDIT)
        );
        if($type === 'paid')
            $criteria['paid_date'] = array( 'not_null', '' );
        elseif($type === 'unpaid')
            $criteria['paid_date'] = array( 'null', '' );
        $accounts = AccountTransaction::listAll($criteria);

        return $this->layout->nest('content', 'account.account_transaction.payable', array(
            'accounts' => $accounts,
            'accountTransType' => AUTOCARE_ACCOUNT_TYPE_CREDIT,
        ));
    }

    public function get_invoice_delete($type=AUTOCARE_ACCOUNT_TYPE_DEBIT, $id=null) {
        if($id===null) {
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
        $success = AccountTransaction::remove($id);
        if($success) {
            //success
            Session::flash('message', 'Remove success');
        } else {
            Session::flash('message_error', 'Remove failed');
        }
        if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
            return Redirect::to('account/account_receivable');
        else
            return Redirect::to('account/account_payable');
    }

    public function get_invoice_edit($type=AUTOCARE_ACCOUNT_TYPE_DEBIT, $id) {
        if($id===null) {
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.ui.mousewheel', 'js/plugins/forms/jquery.mousewheel.js', array('jquery'));
		Asset::add('role.application', 'js/account/account_transaction/application.js', array('jquery.timeentry'));

        $account = AccountTransaction::find($id);
        $inv_date = date(AccountTransaction::$dateformat, strtotime($account->invoice_date));
        $inv_time = date(AccountTransaction::$timeformat, strtotime($account->invoice_date));
        $due_date = date(AccountTransaction::$dateformat, strtotime($account->due_date));
        $due_time = date(AccountTransaction::$timeformat, strtotime($account->due_date));
        $accounts = Account::allSelect();
        $items = $account->items;

        return $this->layout->nest('content', 'account.account_transaction.edit', array(
            'account' => $account,
            'accountTransType' => $type,
            'invoice_date' => $inv_date,
            'invoice_time' => $inv_time,
            'due_date' => $due_date,
            'due_time' => $due_time,
            'accounts'  => $accounts,
            'items' => $items
        ));
    }

    public function post_invoice_edit($type=AUTOCARE_ACCOUNT_TYPE_DEBIT) {
        $id = Input::get('id');
        if($id===null) {
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
        $validation = Validator::make(Input::all(), $this->getInvoiceRules('edit'));
        if(!$validation->fails()) {
            $data = Input::all();
            $success = AccountTransaction::update($id, $data);
            if($success) {
                //success edit
                Session::flash('message', 'Success update');
                if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                    return Redirect::to('account/account_receivable');
                else
                    return Redirect::to('account/account_payable');
            } else {
                Session::flash('message_error', 'Failed update');
                return Redirect::to_action('account@invoice_edit', array($type, $id));
            }
        } else {
            Session::flash('message_error', 'Failed update');
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
    }

    private function getInvoiceRules($method='add') {
        $additional = array();
        $rules = array(
            'subject' => 'required',
            'reference_no' => 'required|min:5|max:50',
            'invoice_date' => 'required',
            'invoice_time' => 'required',
            'due_date' => 'required',
            'due_time' => 'required',
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


    /***
     * PAY INVOICE FUNCTIONS
     */

    public function get_pay_invoice($type=AUTOCARE_ACCOUNT_TYPE_DEBIT, $id) {
        if($id===null) {
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
        Asset::add('jquery.timeentry', 'js/plugins/ui/jquery.timeentry.min.js', array('jquery', 'jquery-ui'));
        Asset::add('jquery.ui.mousewheel', 'js/plugins/forms/jquery.mousewheel.js', array('jquery'));
        Asset::add('role.application', 'js/account/account_transaction/application.js', array('jquery.timeentry'));

        $account = AccountTransaction::find($id);
        $inv_date = date(AccountTransaction::$dateformat, strtotime($account->invoice_date));
        $inv_time = date(AccountTransaction::$timeformat, strtotime($account->invoice_date));
        $due_date = date(AccountTransaction::$dateformat, strtotime($account->due_date));
        $due_time = date(AccountTransaction::$timeformat, strtotime($account->due_date));
        $accounts = Account::allSelect();
        $items = $account->items;

        return $this->layout->nest('content', 'account.account_transaction.edit', array(
            'account' => $account,
            'accountTransType' => $type,
            'invoice_date' => $inv_date,
            'invoice_time' => $inv_time,
            'due_date' => $due_date,
            'due_time' => $due_time,
            'accounts'  => $accounts,
            'items' => $items
        ));
    }

    public function post_pay_invoice($type=AUTOCARE_ACCOUNT_TYPE_DEBIT) {
        $id = Input::get('id');
        if($id===null) {
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
        $validation = Validator::make(Input::all(), $this->getInvoiceRules('edit'));
        if(!$validation->fails()) {
            $data = Input::all();
            $success = AccountTransaction::pay_invoice($id, $data);
            if($success) {
                //success edit
                Session::flash('message', 'Success update');
                if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                    return Redirect::to('account/account_receivable');
                else
                    return Redirect::to('account/account_payable');
            } else {
                Session::flash('message_error', 'Failed update');
                return Redirect::to_action('account@invoice_edit', array($type, $id));
            }
        } else {
            Session::flash('message_error', 'Failed update');
            if($type == AUTOCARE_ACCOUNT_TYPE_DEBIT)
                return Redirect::to('account/account_receivable');
            else
                return Redirect::to('account/account_payable');
        }
    }

}