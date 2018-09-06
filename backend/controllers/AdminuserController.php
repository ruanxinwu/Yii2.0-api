<?php

namespace backend\controllers;

use common\models\AuthAssignment;
use common\models\AuthItem;
use Yii;
use common\models\Adminuser;
use common\models\AdminuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\BaseController;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends BaseController
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
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
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
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Adminuser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Adminuser model.
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
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Adminuser model.
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
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrivilege($id)
    {
        $roles = AuthItem::find()->select(['name','description'])->all();
        $rolesArray = array();
        foreach ($roles as $role)
        {
            $rolesArray[$role->name] = $role->description;
        }
       // pd($rolesArray);

        $roles_users = AuthAssignment::find()->select(['item_name','user_id'])
            ->where(['user_id' => $id])->all();
        $rolesUsersArray = array();
        foreach ($roles_users as $roles_user)
        {
            array_push($rolesUsersArray,$roles_user->item_name);
        }

        if(Yii::$app->request->isPost)
        {
            if(isset($_POST['ruan']))
            {
                $list = $_POST['ruan'];
                AuthAssignment::deleteAll(['user_id' => $id]);
                foreach($list as $value)
                {
                    $obj = new AuthAssignment();
                    $obj->item_name = $value;
                    $obj->user_id = $id;
                    $obj->created_at = time();

                    $obj->save();
                }
            }else
            {
                AuthAssignment::deleteAll(['user_id' => $id]);
            }
            return $this->redirect(['post/index']);
        }
        //return $this->redirect('index');


        //pd($rolesUsersArray);
        return $this->render('privilege',[
            'rolesArray' => $rolesArray,
            'rolesUsersArray' => $rolesUsersArray
        ]);

    }
}
