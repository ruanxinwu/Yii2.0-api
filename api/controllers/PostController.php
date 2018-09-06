<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/20
 * Time: 14:02
 */

namespace api\controllers;

use api\models\Post;
use Yii;
use api\components\AuthController;

use yii\data\ActiveDataProvider;

class PostController extends AuthController
{
    public function actions()
    {
        $action = parent::actions();
        unset($action['index']);
        return $action;
    }

    public function actionIndex()
    {
        return  Post::find()->all();
        $modelClass = $this->modelClass;

        // 分页，请求要带上page参数
       return new ActiveDataProvider([
           'query' => $modelClass::find()->asArray(),
           'pagination' => ['pageSize' => 2]
       ]);
    }

    public function actionSearchAbc()
    {
        pd($this->get,$this->post,$this->cookie);
//        $modelClass = $this->modelClass;
//        $model = new Post();
//        return $modelClass::find()->where(['like','content',$_POST['content']])->all();
    }

}