<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/20/12
 * Time: 9:51 PM
 * To change this template use File | Settings | File Templates.
 */
class Batch extends Eloquent {

    public static $table = 'batch';

    //===jo edit====//
    public static function getSingleResult($criteria) {
        $b=Batch::where('batch_status', '=', 1);
        return $b->first();
    }
}
