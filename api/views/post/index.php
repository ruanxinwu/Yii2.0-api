<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        //$searchModel = '32';
    ?>
    <?php // 网格小部件 ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'content:ntext',
            'taggs:ntext',
            //'status',
            ['attribute' => 'status',
                'value' => 'status0.name',
                // 下拉框
                'filter' => Poststatus::find()
                                ->select(['name','id'])
                                ->indexBy('id')
                                ->column(),
                // 调整列属性 宽度
                //'contentOptions' => ['width' => '60px'],

                'contentOptions' => function ($model)
                {
                    return ($model->status ==1)?['class' => 'bg-danger']:[];
                },
            ],

            // 'create_time:datetime'
            ['attribute' => 'create_time',
                'format' => ['date','php:m-d H:i'],
//                'value' => function($model)
//                {
//                    return date('Y-m-d H:i:s',$model->create_time);
//                },


               //'value' => 'createtime'

            ],

            // 'update_time:datetime', 时间有三种方式展示
            ['attribute' => 'update_time',
//                'value' => function($model)
//                {
//                    return date('Y-m-d',$model->update_time);
//                }
                'value' => 'updaTEtimE' // 默认使用的是 post 模型中的getUpdateTime()方法
                //'value' => date('Y-m-d',$model->create_time) 错误的写法
            ],

            //'author_id',
//            ['attribute' => 'author_id',
//                'value' => 'author.nickname'
//            ],

            ['attribute' => 'authorName', // 当对应存在authorName则显示post里面设置的名称
                'label' => '作者',
                'value' => 'author.nickname'

            ],

            'title',
            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update} {delete}   {approve}',
                'buttons' =>
                    [
                        // $url:动作列为按钮创建的URL
                        // $model：当前要渲染的模型对象
                        // $key：数据提供者数组中模型的键
                        'approve' => function ($url,$model,$key)
                        {
                            $options =
                                [
                                    'title' => Yii::t('yii','审核'),
                                    'aria-label' => Yii::t('yii','审核'),
                                    'data-confirm' => Yii::t('yii','你确定通过这条评论吗'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ];

                            return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                        }
                    ]
            ]
        ],
    ]); ?>
</div>
