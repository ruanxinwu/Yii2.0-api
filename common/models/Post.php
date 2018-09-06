<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $taggs
 * @property int $status
 * @property int $create_time
 * @property int $update_time
 * @property int $author_id
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[[], 'required'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['content', 'taggs'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'taggs' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'author_id' => '作者',
        ];
    }

    public function getStatus0()
    {
        // post表多对一而言用 hasOne()
        return $this->hasOne(Poststatus::className(),['id'=>'status']);
        //$this->hasMany();// post表一对多而言用hasMany();
    }

    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(),['id'=>'author_id']);
    }

    //重写beforeSave方法，在save()数据写入数据库时执行
//    public function beforeSave($insert)
//    {
//        if(parent::beforeSave($insert)) // 保证父类的该方法也执行
//        {
//            if($insert)
//            {
//                $this->create_time = time();
//                $this->update_time = time();
//            }else
//            {
//                $this->update_time = time();
//            }
//            return true;
//        }else
//        {
//            return false;
//        }
//    }

    public function getUpdateTime()
    {
        return date('Y-m-d H:i:s',$this->update_time);
    }

    public function getCreateTime()
    {
        return date('Y-m-d H:i:s',$this->create_time);
    }

    public function getRuan()
    {
        return $this::find();
    }
}
