<?php

namespace api\models;

use api\components\BaseController;
use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use Detection\MobileDetect;
/**
 * This is the model class for table "admin_user".
 *
 * @property int $id
 * @property string $username
 * @property string $nickname
 * @property string $password
 * @property string $email
 * @property string $profile
 * @property int $type 0 超级管理员；1 sp管理员；2 风控初审；3 风控复审
 * @property int $channel_id 渠道id
 */
class AdminUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ADMIN = 1;
    const SP_ADMIN = 2;
    const SP_SALES = 3;
    const SP_FINANCE = 4;

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
            [['username', 'nickname', 'password', 'email',], 'string', 'max' => 255],
            [['type','channel_id'],'integer']
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
        return AdminUserToken::find()->where(['token' => $token])
           // ->andWhere(['>','expiry_time',time()])
            ->one();


    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public function generateAccessToken()
    {
        return Yii::$app->security->generateRandomString();

    }

    // 返回需要的字段,还可以给字段名重新设置别名
    public function fields()
    {
        return ['id','姓名' => 'name'];
    }

    public function getRuanAa()
    {
        return 22222;
    }
}
