<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/27
 * Time: 17:59
 */
namespace api\modules\website\controllers;
use api\components\AuthController;
use api\modules\website\models\WebsitePlanLoan;
use yii\web\Controller;

class PlanController extends AuthController
{
    public function actionIndex()
    {
        pd(WebsitePlanLoan::find()->all());
    }
}