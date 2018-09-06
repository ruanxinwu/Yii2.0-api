<?php

namespace backend\controllers;

use backend\components\BaseController;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\rbac\DbManager;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);

    }

    public function actionAb()
    {
        $this->createEmpowerment(['name' => 'admin','description' => 'read_post']);
    }

    // 创建许可
    protected function createPermission()
    {
        $auth = Yii::$app->authManager;
        $createPost = $auth->createPermission('');
        $createPost->description = '';
        return $auth->add($createPost);
    }

    // 创建角色
    protected function createRole($item)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($item);
        //$role->description = ;
        return $auth->add($role);
    }

    // 给角色分配许可
    protected function createEmpowerment($item)
    {
        $auth = Yii::$app->authManager;
        $parent = $auth->createRole($item['name']);
        $child = $auth->createPermission($item['description']);
        return $auth->addChild($parent,$child);
    }

    // 给角色分配用户
    protected function assign($item)
    {
        $auth = Yii::$app->authManager;
        $reader = $auth->createRole($item['name']);
        return $auth->assign($reader,$item['description']);
    }
    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model, // 模板中使用变量$jiju
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
