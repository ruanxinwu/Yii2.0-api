<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/24
 * Time: 16:16
 */

namespace api\controllers;

use api\exceptions\ApiException;
use api\models\AdminUser;
use api\models\ChannelSource;
use Yii;
use api\components\AuthController;
use api\models\ChannelAdmin;
class AdminUserController extends AuthController
{
    /**
     * 新增人员
     */
    public function actionAddUser()
    {
        $post = Yii::$app->request->post();

        // 渠道id
        $channel_source_id = isset($post['channel_source_id'])?$post['channel_source_id']:$this->admin_user->channel_id;

        // 验证传入的渠道是否为当前用户的子集渠道
        if(ChannelSource::isExist($channel_source_id,$this->admin_user->channel_id))
        {
            // 新增人员
            $model = new AdminUser();
            $model->username = $post['username'];
            $model->password = isset($post['password'])?md5($post['password']):md5('123456');
            $model->type = isset($post['type'])?$post['type']:AdminUser::SP_ADMIN;
            $model->channel_id = $channel_source_id;//pd($model);
            $model->save();
            return $this->response();
        }else
        {
            return $this->responseError(ApiException::CHANNEL_IS_NOT_EXIST);
        }

    }
}