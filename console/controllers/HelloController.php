<?php
namespace console\controllers;
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/17
 * Time: 15:56
 */

use yii\console\Controller;
use common\models\Post;
class HelloController extends Controller
{
    public $rev;

    public function actionIndex()
    {
       // $posts = Post::find()->all();
        $str = 'Hello World';
        if($this->rev == 1)
        {
            echo strrev($str);
        }else
        {
            echo $str;
        }
    }



}