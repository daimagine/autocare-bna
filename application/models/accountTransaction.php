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

    public static $sqlformat = 'Y-m-d H:i:s';
    public static $format = 'd-m-Y H:i:s';
    public static $dateformat = 'd-m-Y';
    public static $timeformat = 'H:i:s';

    public static function invoice_new() {
        $count = DB::table(static::$table)->count();
        $count++;
        //pad static::$INVOICE_LENGTH leading zeros
        $suffix = sprintf('%0' . static::$INVOICE_LENGTH . 'd', $count);
        return static::$INVOICE_PREFIX . $suffix;
    }

    public static function create($data=array()) {
        if(empty($data))
            return false;

        $ate = new AccountTransaction;
        $ate->invoice_no = $data['invoice_no'];
        $ate->reference_no = $data['reference_no'];
        $ate->status = $data['status'];
        $ate->type = $data['type'];
        $ate->description = @$data['description'];
        $ate->subject = $data['subject'];

        //datetime fields

        $ate->input_date = date(static::$sqlformat);

        $invoice_date = $data['invoice_date'] . $data['invoice_time'];
        $invoice_date = DateTime::createFromFormat(static::$format, $invoice_date);
        $ate->invoice_date = $invoice_date->format(static::$sqlformat);

        $due_date = $data['due_date'] . $data['due_time'];
        $due_date = DateTime::createFromFormat(static::$format, $due_date);
        $ate->due_date = $due_date->format(static::$sqlformat);

        $ate->save();
        return $ate->id;
    }

    public static function listAll($criteria=array()) {
        return AccountTransaction::where('status', '=', 1)->get();
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

        //datetime fields

        $ate->input_date = date(static::$sqlformat);

        $invoice_date = $data['invoice_date'] . $data['invoice_time'];
        $invoice_date = DateTime::createFromFormat(static::$format, $invoice_date);
        $ate->invoice_date = $invoice_date->format(static::$sqlformat);

        $due_date = $data['due_date'] . $data['due_time'];
        $due_date = DateTime::createFromFormat(static::$format, $due_date);
        $ate->due_date = $due_date->format(static::$sqlformat);

        $ate->save();
        return $ate->id;
    }

    public static function listAllByCriteria($criteria) {
        $ate=DB::table('account_transactions');
        if($criteria!=null and $criteria['status']) {
            if($criteria['status']) {$ate=$ate->where('status', '=', $criteria['status']);}
            if($criteria['approved_status']){$ate=$ate->where('approved_status', '=', $criteria['approved_status']);}
        }
        return $ate->get();
    }
}
