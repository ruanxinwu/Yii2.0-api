<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/24
 * Time: 17:17
 */

namespace api\controllers;

use api\exceptions\ApiException;
use api\models\ChannelSource;
use Yii;
use api\components\AuthController;
use api\models\AdminUser;
class ChannelSourceController extends AuthController
{
    /**
     * 添加渠道
     * @return array
     */
    public function actionAddChannel()
    {
        $model = new ChannelSource();

        $post = Yii::$app->request->post();

        $post['parent_id'] = $this->admin_user->channel_id;

        if($model->load($post,'') && $model->save())
        {
            return $this->response();
        }else
        {
            return $this->responseError(ApiException::CHANNEL_ADD_FAIL,$this->getFirstErrorLabel($model));
        }
    }

}