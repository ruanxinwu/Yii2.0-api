<?php
namespace api\controllers;

use api\exceptions\ApiException;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use api\models\AdminLoginForm;
use api\models\AdminUserToken;
use api\components\BaseController;
use api\components\AuthController;
/**
 * Site controller
 */
class SiteController extends AuthController
{
    public function beforeAction($actions)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                // 'backColor'=>0x000000,//背景颜色
                //'fixedVerifyCode' => substr(rand(1000,9999), 0),
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 3,//间距
                'height'=>34,//高度
                'width' => 90,  //宽度

                // 'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4        //设置字符偏移量 有效果
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

            'ruan' => [

            ]
        ];
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        try
        {
            //var_dump($this->admin_user);die;
            //pd(Yii::$app->getRequest()->getBodyParams());
            $model = new AdminLoginForm();
            $model->load(Yii::$app->getRequest()->getBodyParams(),'');
            $login = $model->login();//var_dump($login);die;

            if($login)
            {
               // pd($this->getClientType());
                $AdminUserToken = new AdminUserToken();//var_dump($model->__get('_user')->id);die;
                $AdminUserToken->user_id = $model->__get('_user')->id;
                $AdminUserToken->token = $login;
                $AdminUserToken->client_type = $this->getClientType();
                $AdminUserToken->expiry_time = time() + 10;
                $AdminUserToken->save();//pd($login);
                return $this->response([$login]);
            }else
            {
                return $this->responseError(ApiException::LOGIN_INVALID,$this->getFirstErrorLabel($model));
            }
        }catch (\Exception $e)
        {
            print_r($e->getMessage());
        }

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {

    }
}
