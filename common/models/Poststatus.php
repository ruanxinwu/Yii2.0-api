<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "poststatus".
 *
 * @property int $id
 * @property string $name
 * @property int $position
 */
class Poststatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poststatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'position' => 'Position',
        ];
    }
}
