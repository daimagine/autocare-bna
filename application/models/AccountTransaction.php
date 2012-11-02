<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fahmi
 * Date: 20/09/12
 * Time: 2:42
 * To change this template use File | Settings | File Templates.
 */
class AccountTransaction extends Eloquent {

    public static $table = 'account_transactions';

    private static $INVOICE_PREFIX = 'INV';
    private static $INVOICE_LENGTH = 14;

    private static $REF_PREFIX = 'REF';
    private static $REF_LENGTH = 9;

    public static $sqlformat = 'Y-m-d H:i:s';
    public static $format = 'd-m-Y H:i:s';
    public static $dateformat = 'd-m-Y';
    public static $timeformat = 'H:i:s';

    public function user() {
        return $this->belongs_to('user', 'create_by');
    }

    public function account() {
        return $this->belongs_to('account', 'account_id');
    }

    public function items() {
        return $this->has_many('SubAccountTrans', 'account_trx_id')
            ->where('status','=',1);
    }

    public static function invoice_new() {
        $count = DB::table(static::$table)->count();
        $count++;
        //pad static::$length leading zeros
        $suffix = sprintf('%0' . static::$INVOICE_LENGTH . 'd', $count);
        return static::$INVOICE_PREFIX . $suffix;
    }

    public static function reference_new() {
        $count = DB::table(static::$table)->order_by('id', 'desc')->take(1)->only('id');
        //dd($count);
        $count++;
        //pad static::$REF_LENGTH leading zeros
        $suffix = sprintf('%0' . static::$REF_LENGTH . 'd', $count);
        return static::$REF_PREFIX . $suffix;
    }

    public static function create($data=array()) {
        if(empty($data))
            return false;

        $ate = new AccountTransaction;
        $ate->create_by = Auth::user()->id;

        $ate->invoice_no = $data['invoice_no'];
        $ate->reference_no = $data['reference_no'];
        $ate->status = $data['status'];
        $ate->type = $data['type'];
        $ate->description = @$data['description'];
        $ate->subject = $data['subject'];
        $ate->account_id = $data['account_id'];

        $ate->approved_status = approvedStatus::NEW_ACCOUNT_INVOICE;

        //datetime fields

        $ate->input_date = date(static::$sqlformat);

        $invoice_date = $data['invoice_date'] . $data['invoice_time'];
        $invoice_date = DateTime::createFromFormat(static::$format, $invoice_date);
        $ate->invoice_date = $invoice_date->format(static::$sqlformat);

        $due_date = $data['due_date'] . $data['due_time'];
        $due_date = DateTime::createFromFormat(static::$format, $due_date);
        $ate->due_date = $due_date->format(static::$sqlformat);

        $ate->save();


        //register items
        $due_amount = 0;
        if(isset($data['items']) && is_array($data['items'])) {
            //cleanup items
            $affected = DB::table('sub_account_trx')
                ->where('account_trx_id', '=', $ate->id)
                ->delete();
            foreach($data['items'] as $item) {
                $item['approved_status'] = approvedStatus::NEW_ACCOUNT_INVOICE;
                $ate->items()->insert($item);
                $due_amount += $item['amount'];
                //var_dump($item['amount']);
            }
        }

        //dd($data);
        $ate->due = round($due_amount, 2);
        $ate->save();

        //dd($ate);
        return $ate->id;
    }

    public static function listAll($criteria=array()) {
        $q = AccountTransaction::with(array('account'))
            ->where('status', '=', 1);
        foreach($criteria as $key => $val) {
            if(is_array($val)) {
                if($val[0] === 'null') {
                    $q->where_null($key);
                } elseif($val[0] === 'not_null') {
                    $q->where_not_null($key);
                } elseif($val[0] === 'within') {
                    $q->where($key, '>=', $val[1]);
                    $q->where($key, '<=', $val[2]);
                } else {
                    $q->where($key, $val[0], $val[1]);
                }
            }
        }
        $data =  $q->get();
        //dd(DB::last_query());
        return $data;
    }

    public static function weekly($criteria=array()) {
        $param = array();
        $criterion = array();
        foreach($criteria as $key => $val) {
            $key = static::weekly_lookup($key);
            if($val[0] === 'not_null') {
                $criterion[] = "$key is not null";
            } elseif($val[0] === 'between') {
                $criterion[] = "$key $val[0] ? and ?";
                array_push($param, $val[1]);
                array_push($param, $val[2]);
            } else {
                $criterion[] = "$key $val[0] ?";
                array_push($param, $val[1]);
            }
        }

        $q = "SELECT a.name, "
            . "Count(*) AS count, "
            . "Sum(at.due) AS amount, "
            . "Date_add(at.invoice_date, INTERVAL(1-Dayofweek(at.invoice_date)) day) AS week_start, "
            . "Date_add(at.invoice_date, INTERVAL(7-Dayofweek(at.invoice_date)) day) AS week_end ";

        $q .= "FROM   account_transactions AS at "
            . "INNER JOIN account AS a ON a.id = at.account_id ";

        $where = " ";
        if(strlen(trim($where)) > 0)
            $where .= " and ";
        else
            $where .= " where ";
        $where .= implode(" and ", $criterion). " ";

        $q.= $where;

        $q .= "GROUP  BY Week(at.input_date), "
            . "a.name ";

        $data = DB::query($q, $param);

//        dd($data);
//        dd(DB::last_query());
        return $data;
    }

    public static function remove($id) {
        $ate = AccountTransaction::find($id);
        $ate->status = 0;
        $ate->save();
        return $ate->id;
    }

    public static function update($id, $data = array()) {
        $ate = AccountTransaction::where_id($id)
            ->where_status(1)
            ->first();

        $ate->invoice_no = $data['invoice_no'];
        $ate->reference_no = $data['reference_no'];
        $ate->status = $data['status'];
        $ate->type = $data['type'];
        $ate->description = @$data['description'];
        $ate->subject = $data['subject'];
        $ate->account_id = $data['account_id'];

        //datetime fields

        $ate->input_date = date(static::$sqlformat);

        $invoice_date = $data['invoice_date'] . $data['invoice_time'];
        $invoice_date = DateTime::createFromFormat(static::$format, $invoice_date);
        $ate->invoice_date = $invoice_date->format(static::$sqlformat);

        $due_date = $data['due_date'] . $data['due_time'];
        $due_date = DateTime::createFromFormat(static::$format, $due_date);
        $ate->due_date = $due_date->format(static::$sqlformat);

        $ate->save();

        //register items
        $due_amount = 0;
        if(isset($data['items']) && is_array($data['items'])) {
            //cleanup items
            $affected = DB::table('sub_account_trx')
                ->where('account_trx_id', '=', $ate->id)
                ->delete();
            foreach($data['items'] as $item) {
                $ate->items()->insert($item);
                $due_amount += $item['amount'];
                //var_dump($item['amount']);
            }
        }

        //dd($data);
        $ate->due = round($due_amount, 2);
        $ate->save();

        //dd($ate);
        return $ate->id;
    }

    public static function listAllByCriteria($criteria) {
        $ate=AccountTransaction::where('status', '=', 1);
        if($criteria!=null and $criteria['status']) {
            if($criteria['approved_status']){$ate=$ate->where('approved_status', '=', $criteria['approved_status']);}
        }
        return $ate->get();
    }


    public static function pay_invoice($id, $data = array()) {
        $ate = AccountTransaction::where_id($id)
            ->where_status(1)
            ->first();

        $ate->subject_payment = $data['subject_payment'];
        $ate->paid = round($data['paid'], 2);

        //datetime fields
        $payment_date = $data['payment_date'] . $data['payment_time'];
        $payment_date = DateTime::createFromFormat(static::$format, $payment_date);
        $ate->paid_date = $payment_date->format(static::$sqlformat);

        $ate->save();

        //dd($ate);
        return $ate->id;
    }

    public static function weekly_lookup($key) {
        $keystore = array(
            'paid_date' => 'at.paid_date',
            'start_date' => 'at.invoice_date',
            'end_date' => 'at.invoice_date',
            'invoice_date' => 'at.invoice_date',
        );
        return($keystore[$key]);
    }
}