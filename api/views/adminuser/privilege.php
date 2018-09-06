<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '用户权限设置';
$this->params['breadcrumbs'][] = ['label' => 'Adminusers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="adminuser-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="adminuser-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList('ruan',$rolesUsersArray,$rolesArray) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>