<?php
namespace api\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use api\models\AdminUserToken;
use api\exceptions\ApiException;
class AuthController extends BaseController
{
    public $admin_user;

    public $admin_user_token;

    // 验证token闸门
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'authenticatior' => [
                'class' => QueryParamAuth::className(),
                'optional' => [
                    //'logins'   //放在这里面的方法不用验证token，但是两个控制器存在相同的方法，一个需要验证一个不需要验证怎么办
                ]
            ]
        ]);
    }

    public function beforeAction($actions)
    {
        parent::beforeAction($actions);

        $actionId = '/' . $actions->getUniqueId();  // 获取访问的 contronller 和 action
        $token = Yii::$app->request->get('access-token');   // get access-token value
//pd_var(Yii::$app->authManager->getRules());
        $this->admin_user_token = AdminUserToken::getAdminUserToken($token,['user_id']);
        $this->admin_user = $this->admin_user_token->adminUser;
        Yii::$app->cache->set('token',['token' => $token,'user_id' => $this->admin_user_token->user_id]);
        //pd($this->admin_user_token->user_id, $actionId);
        //pd(Yii::$app->authManager->getPermissionsByUser($this->admin_user_token->user_id));
        if(Yii::$app->authManager->checkAccess($this->admin_user_token->user_id, $actionId))
        {
            return true;
        }else
        {
            Yii::$app->response->data=$this->responseError(ApiException::NO_AUTH);

            Yii::$app->end();
        }
    }


}