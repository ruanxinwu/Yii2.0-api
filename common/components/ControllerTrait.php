<?php
namespace common\components;

use yii\base\Model;

trait ControllerTrait
{
    public function getFirstErrorLabel(Model $model)
    {
        $data = $model->getFirstErrors();
        return reset($data);
    }
}