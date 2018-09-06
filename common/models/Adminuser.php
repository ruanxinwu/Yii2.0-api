<?php

namespace common\models;

use api\models\AdminUserToken;
use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "adminuser".
 *
 * @property int $id
 * @property string $username
 * @property string $nickname
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Adminuser extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile'], 'string'],
            [['username', 'nickname', 'password', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '用户昵称',
            'password' => '密码',
            'email' => '邮件',
            'profile' => 'Profile',
        ];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
       //return Yii::$app->security->validatePassword($password, $this->password);
        //var_dump($this->password);
        return $this->password == md5($password);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        //return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        $model = new AdminUserToken();
        return $model::findOne(['token' => $token]);
       // return parent::find
        return static::findOne(['access_token' => $token]);

    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
}
