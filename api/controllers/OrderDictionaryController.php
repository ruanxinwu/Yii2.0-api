<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/21
 * Time: 17:19
 */
namespace api\controllers;

use api\exceptions\ApiException;
use api\models\ChannelSource;
use api\models\Order;
use common\models\User;
use yii\helpers\ArrayHelper;
use Ramsey\Uuid\Uuid;
use Yii;
use api\components\AuthController;
use api\models\OrderDictionary;
use yii\db\ArrayExpression;

class OrderDictionaryController extends AuthController
{
    /**
     * 订单列表
     * @method GET
     */
    public function actionIndex()
    {
        $get = Yii::$app->request->get();
        $post = Yii::$app->request->post();
        new User(['scenario' => 'signupsadaasad']);die;
        $order_dictionarys = OrderDictionary::find()
            ->Where(['in', 'sp_id', ChannelSource::getChildrenChannel($this->admin_user->channel_id,true)])
            ->all();

        // 订单列表
        if(empty($order_dictionarys))
        {
            return $this->responseError(ApiException::ORDER_DICTIONARY_LIST_NOT_EXIST);
        }else
        {
            return $this->response($order_dictionarys);
        }
    }

    /**
     * 订单详情
     * @method GET
     */
    public function actionSingle($id)
    {
        $order_dictionary = OrderDictionary::find()->where(['id' => $id])
            ->andWhere(['in','sp_id',ChannelSource::getChildrenChannel($this->admin_user->channel_id,true)])
            ->one();

        // 订单数据
        if(empty($order_dictionary))
        {
            return $this->responseError(ApiException::ORDER_DICTIONARY_LIST_NOT_EXIST);
        }else
        {
            return $this->response($order_dictionary);
        }
    }

    /**
     * 订单新增
     * @method POST
     */
    public function actionAdd()
    {
        $data = Yii::$app->request->post();
        Yii::error($data);
        // 接收数据为空错误

        // 订单默认数据
        $data['uuid'] = Uuid::uuid4()->toString();
        $data['order_no'] = microtime(true) . '_1';
        //$data['sp_id'] = $this->admin_user->channel_id;

        $model = (new OrderDictionary())->findOne(46);


        if($model->load($data,'') && $model->save())
        {
            return $this->response([],'新增订单成功');
        }else
        {
            // 返回保存订单失败错误信息，暂时返回一条即可
            return $this->responseError(ApiException::ORDER_DICTIONARY_OPTION_FAIL, $this->getFirstErrorLabel($model));
        }

    }

    /**
     * 订单批量新增(excel导入)
     * @method POST
     */
    public function actionBatchAddOrderDictionary()
    {

    }
    /**
     * 订单批量删除
     * @method POST
     */
    public function actionBatchDeleteOrderDictionary()
    {
        // ids 以,隔开
        $ids = Yii::$app->request->post('ids');
        $ids_array = array_filter(explode(',',$ids));

        $count = OrderDictionary::find()->where(['in','id',$ids_array])
            ->andWhere(['sp_id' => $this->user->channel_id])
            ->count();

        // 防止传入无效的订单id
        if(count($ids_array) != $count)
        {
            return $this->responseError(ApiException::ORDER_DICTIONARY_INVALID);
        }

        // 执行删除
        if(OrderDictionary::deleteAll(['in','id',$ids_array]))
        {
            return $this->response();
        }else
        {
            return $this->responseError(ApiException::ORDER_DICTIONARY_OPTION_FAIL);
        }
    }

}