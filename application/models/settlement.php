<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adi
 * Date: 10/21/12
 * Time: 5:11 AM
 * To change this template use File | Settings | File Templates.
 */
class Settlement extends Eloquent {

    public static $table = 'settlement';

    public static $sql_timestamp_format = 'Y-m-d H:i:s';
    public static $sql_date_format = 'Y-m-d';

    public static $format = 'd-m-Y H:i:s';
    public static $dateformat = 'd-m-Y';
    public static $timeformat = 'H:i:s';

    public function clerk() {
        return $this->belongs_to('User', 'user_id');
    }

    public static function listAll() {
        return Settlement::with('clerk')
            ->where_status(1)
            ->order_by('settlement_date', 'desc')
            ->get();
    }


    public static function update($id, $data = array()) {
        $settlement = Settlement::where_id($id)
            ->where_status(1)
            ->first();

        if(array_key_exists('notes', $data))
            $settlement->notes = $data['notes'];
        if(array_key_exists('status', $data))
            $settlement->status = $data['status'];

        if(array_key_exists('fraction_50', $data))
            $settlement->fraction_50 = $data['fraction_50'];
        if(array_key_exists('fraction_100', $data))
            $settlement->fraction_100 = $data['fraction_100'];
        if(array_key_exists('fraction_200', $data))
            $settlement->fraction_200 = $data['fraction_200'];
        if(array_key_exists('fraction_500', $data))
            $settlement->fraction_500 = $data['fraction_500'];
        if(array_key_exists('fraction_1000', $data))
            $settlement->fraction_1000 = $data['fraction_1000'];
        if(array_key_exists('fraction_2000', $data))
            $settlement->fraction_2000 = $data['fraction_2000'];
        if(array_key_exists('fraction_5000', $data))
            $settlement->fraction_5000 = $data['fraction_5000'];
        if(array_key_exists('fraction_10000', $data))
            $settlement->fraction_10000 = $data['fraction_10000'];
        if(array_key_exists('fraction_20000', $data))
            $settlement->fraction_20000 = $data['fraction_20000'];
        if(array_key_exists('fraction_50000', $data))
            $settlement->fraction_50000 = $data['fraction_50000'];
        if(array_key_exists('fraction_100000', $data))
            $settlement->fraction_100000 = $data['fraction_100000'];

        if(array_key_exists('amount_cash', $data))
            $settlement->amount_cash = $data['amount_cash'];
        if(array_key_exists('amount_non_cash', $data))
            $settlement->amount_non_cash = $data['amount_non_cash'];

        $settlement->calculate_amount();

        $settlement_date= $data['settlement_date'];
        $settlement_date = DateTime::createFromFormat(static::$sql_date_format, $settlement_date);
        $settlement->settlement_date = $settlement_date->format(static::$sql_timestamp_format);;

        if(array_key_exists('state', $data))
            $settlement->state = $data['state'];

        if(array_key_exists('success_transaction', $data))
            $settlement->success_transaction = $data['success_transaction'];

        //always set after settlement date
        $settlement->is_match($settlement);

        if(array_key_exists('user_id', $data)) {
            $settlement->user_id = $data['user_id'];
        }
        //dd($settlement);

        //save
        $settlement->save();
        return $settlement->id;
    }

    public static function create($data = array()) {

        $settlement = new Settlement;
        if(array_key_exists('notes', $data))
            $settlement->notes = $data['notes'];
        if(array_key_exists('status', $data))
            $settlement->status = $data['status'];

        if(array_key_exists('fraction_50', $data))
            $settlement->fraction_50 = $data['fraction_50'];
        if(array_key_exists('fraction_100', $data))
            $settlement->fraction_100 = $data['fraction_100'];
        if(array_key_exists('fraction_200', $data))
            $settlement->fraction_200 = $data['fraction_200'];
        if(array_key_exists('fraction_500', $data))
            $settlement->fraction_500 = $data['fraction_500'];
        if(array_key_exists('fraction_1000', $data))
            $settlement->fraction_1000 = $data['fraction_1000'];
        if(array_key_exists('fraction_2000', $data))
            $settlement->fraction_2000 = $data['fraction_2000'];
        if(array_key_exists('fraction_5000', $data))
            $settlement->fraction_5000 = $data['fraction_5000'];
        if(array_key_exists('fraction_10000', $data))
            $settlement->fraction_10000 = $data['fraction_10000'];
        if(array_key_exists('fraction_20000', $data))
            $settlement->fraction_20000 = $data['fraction_20000'];
        if(array_key_exists('fraction_50000', $data))
            $settlement->fraction_50000 = $data['fraction_50000'];
        if(array_key_exists('fraction_100000', $data))
            $settlement->fraction_100000 = $data['fraction_100000'];

        if(array_key_exists('amount_cash', $data))
            $settlement->amount_cash = $data['amount_cash'];
        if(array_key_exists('amount_non_cash', $data))
            $settlement->amount_non_cash = $data['amount_non_cash'];

        $settlement->calculate_amount();

        $settlement_date= $data['settlement_date'];
        $settlement_date = DateTime::createFromFormat(static::$sql_date_format, $settlement_date);
        $settlement->settlement_date = $settlement_date->format(static::$sql_timestamp_format);;

        if(array_key_exists('state', $data))
            $settlement->state = $data['state'];
        if(array_key_exists('success_transaction', $data))
            $settlement->success_transaction = $data['success_transaction'];

        //always set after settlement date
        $settlement->is_match($settlement);

        if(array_key_exists('user_id', $data)) {
            $settlement->user_id = $data['user_id'];
        }

        $settlement->save();
        return $settlement->id;
    }

    public static function remove($id) {
        $access = Access::find($id);
        $access->status = 0;
        $access->save();
        return $access->id;
    }

    public function is_match() {
        try {

            $date = date(Settlement::$sql_date_format, strtotime($this->settlement_date));
            $bod = date(Settlement::$sql_timestamp_format, strtotime($date . ' 00:00:00'));
            $eod = date(Settlement::$sql_timestamp_format, strtotime($date . ' 23:59:59'));
            Log::info('bod : ' . $bod);
            Log::info('eod : ' .$eod);
            $transactionAmount = Transaction::where('date', '>=', $bod)
                ->where('date', '<=', $eod)
                ->sum('amount');
            Log::info('settlement amount  : ' . $this->amount);
            Log::info('amount transaction : ' . $transactionAmount);

            if($this->user_id > 0) {
                if($transactionAmount == $this->amount) {
                    $this->match = true;
                    $this->state = SettlementState::SETTLED_MATCH;

                    return true;
                } else {
                    $this->match = false;
                    $this->state = SettlementState::SETTLED_UNMATCH;
                }
            }

        } catch (Exception $err) {
            Log::exception($err);
        }
        return false;
    }

    public function calculate_amount() {
        $this->amount = $this->amount_cash + $this->amount_non_cash;
    }

    public function get_state_description() {
        if($this->state == SettlementState::SETTLED) {
            return "Settled";
        } elseif($this->state == SettlementState::SETTLED_MATCH) {
            return "Settled and Match";
        } elseif($this->state == SettlementState::SETTLED_UNMATCH) {
            return "Settled but Unmatch";
        } elseif($this->state == SettlementState::UNSETTLED) {
            return "Unsettled";
        } else {
            return "Cannot Determine State";
        }
    }

}
