<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/27
 * Time: 11:16
 */

namespace api\models;

use yii\db\ActiveRecord;
class ChannelAdmin extends ActiveRecord
{

    public static function tableName()
    {
        return 'ad_channel_admin';
    }
}