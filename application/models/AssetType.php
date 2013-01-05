<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 1/5/13
 * Time: 6:41 PM
 * To change this template use File | Settings | File Templates.
 */

class AssetType extends Eloquent {
    public static $table = 'asset_type';

    public function asset() {
        return $this->has_many('AssetActiva', 'type_id')
            ->where('status', '=', statusType::ACTIVE);
    }

    public static function listAll($criteria) {
        $item_category = AssetType::with('asset');
        $item_category = $item_category->where('status', '=', statusType::ACTIVE);
        if($criteria != null) {
            if(isset($criteria['id'])) {
                $item_category = $item_category->where('id', '=', $criteria['asset_type_id']);
            }
        }
        $item_category = $item_category->get();
        return $item_category;
    }
}