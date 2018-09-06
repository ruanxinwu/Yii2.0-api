<?php
namespace api\models;
use Yii;
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/21
 * Time: 9:55
 */
class Post extends \yii\db\ActiveRecord
{
    public function index()
    {
        return self::find()->all();
    }

    // 返回需要的字段，还可设置别名
    public function fields()
    {
        /*
         * 屏蔽不需要展示的字段
         *
        $fields = parent::fields();
        unset($fields['create_time']);
        */
        return [
            'id',
            'title',
            '内容' => 'content',
            'status' => function()
            {
                return $this->poststatus['name'];
            }
        ];
    }

    public function getPoststatus()
    {
        return $this->hasOne(Poststatus::className(),['id' => 'status']);
    }

//    public function getStatus0()
//    {
//        // post表多对一而言用 hasOne()
//        return $this->hasOne(Poststatus::className(),['id'=>'status']);
//        //$this->hasMany();// post表一对多而言用hasMany();
//    }
}