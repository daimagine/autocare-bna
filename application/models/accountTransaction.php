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
    private static $length = 14;

    public static function invoice_new() {
        $count = DB::table(static::$table)->count();
        $count++;
        //pad static::$length leading zeros
        $suffix = sprintf('%0' . static::$length . 'd', $count);
        return static::$INVOICE_PREFIX . $suffix;
    }

}
