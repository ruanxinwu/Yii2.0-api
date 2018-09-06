<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/27
 * Time: 18:08
 */

namespace api\modules\website\models;

use Yii;
use yii\db\ActiveRecord;

class WebsitePlanLoan extends ActiveRecord
{
    public static function tableName()
    {
        return 'af_website_plan_loan';
    }

    //切换db组件
    public static function getDb()
    {

        return Yii::$app->get('af_db');
    }
}