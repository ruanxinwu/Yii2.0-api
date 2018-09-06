<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/24
 * Time: 17:51
 */

namespace api\models;

use yii\db\ActiveRecord;
class ChannelSource extends ActiveRecord
{
    private static $array = array();
    public static function tableName()
    {
        return 'ad_channel_source';
    }

    public function rules()
    {
        return [
            [['source_name'],'required'],
            [['parent_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'source_name' => '渠道名'
        ];
    }

    // 是否为一级渠道
    public static function isFirstChannel($channel_id)
    {
        $model = self::findOne([
            'id' => $channel_id,
            'type' => 0
        ]);
        if($model)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function getAdminUser()
    {
        return $this->hasOne(OrderDictionary::className(),['sp_id' => 'id']);
    }

    // 判断渠道是否属于另一个渠道
    public static function isExist($search_id,$id)
    {
        if($search_id == $id || in_array($search_id,self::getChildrenChannel($id)))
        {
            return true;
        }
        return false;
    }

    // 获取一个渠道的所有子渠道,$option为false表示不包含自己本身
    public static function getChildrenChannel($channel_id,$option = false)
    {
        $model =  self::find()->select(['id'])->where(['parent_id' => $channel_id])->all();

        foreach ($model as $value)
        {
            if(self::findAll(['parent_id' => $value->id]))
            {
                self::getChildrenChannel($value->id);
            }
            self::$array[] = $value->id;
        }
        // insert self::$channel_id to collection
        if($option)
        {
            self::$array[] = $channel_id;
        }
        return self::$array;
    }
}