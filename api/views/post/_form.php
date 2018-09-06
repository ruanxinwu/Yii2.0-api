<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    <?//= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taggs')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?php
    /*
     * 第一种方法：
        // 找出Posstatus所有数据
        $psObjs = Poststatus::find()->all();
        // 将这个数据装换成id => name 数组
        $allStatus = ArrayHelper::map($psObjs,'id','name');
        var_dump($psObjs);
    */
    /*
     * 第二种方法
        $psArray = Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
        $allStatus = ArrayHelper::map($psArray,'id','name');
        var_dump($psArray);

        第三种方法：查询构建器 \yii\db\Query
        $allStatus = (new \yii\db\Query)->
                        select(['name','id'])
                        ->from('poststatus')
                        ->indexBy('id') // 以字段id作为返回数组键
                        ->column(); // 取select()里面的第一列值,这里对应的是name

        第四种方法：
           $allStatus = Poststatus::find()
                        ->select(['name','id'])
                        ->orderBy('postition')
                        ->indexBy('id') // 以字段id作为返回数组键
                        ->column();
    */
        $allStatus = Poststatus::find()
                        ->select(['name','id'])
                        ->indexBy('id')
                        ->column();
    ?>

    <?php // 下拉菜单选择选框 ?>
     <?= $form->field($model, 'status')->dropDownList($allStatus,['prompt' => '请选择状态']) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <?php
        var_dump($model->isNewRecord );
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'新增':'修改', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
