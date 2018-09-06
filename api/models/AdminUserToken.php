<?php
namespace api\models;

use yii\web\IdentityInterface;
class AdminUserToken extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'admin_user_token';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public function validateAuthKey($authKey)
    {
        //return $this->getAuthKey() === $authKey;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function getAdminUser()
    {
        return $this->hasOne(AdminUser::className(),['id' => 'user_id']);
    }

    public static function getAdminUserToken($token,$params = [])
    {
        return static::find()->select($params)->where(['token' => $token])->one();
    }
}