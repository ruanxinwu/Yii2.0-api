<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/24
 * Time: 15:49
 */

namespace api\models;


use yii\db\ActiveRecord;

class OrderDictionary extends ActiveRecord
{
    public static function tableName()
    {
        return 'ad_order_dictionary';
    }

    public function rules()
    {
        return [
            ['order_no','required','on'=>'da'],
            ['uuid','safe']
        ];
    }

    public function beforeSave($insert)
    {
        var_dump($this->isNewRecord);return false;
    }

}