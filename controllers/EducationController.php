<?php

namespace app\controllers;

use Yii;
use app\models\EmplEducationalHistoryInfo;
use app\models\search\EmplEducationalHistoryInfoSearch;
use app\models\EmployeeInfo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EducationController implements the CRUD actions for EmplEducationalHistoryInfo model.
 */
class EducationController extends Controller
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
     * Lists all EmplEducationalHistoryInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmplEducationalHistoryInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmplEducationalHistoryInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmplEducationalHistoryInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmplEducationalHistoryInfo();
        $model2 = new EmployeeInfo();

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);die;
            if($model->save()){
                if(Yii::$app->request->post('submit')==='create_continue'){
                                //employe education info form. 
                                return $this->redirect(['education/create', 'id' => $model->emp_id]);
                            }else{
                                return $this->redirect(['employee/view', 'id' => $model->emp_id]);
                            }
            }else{
                
            }
            return $this->redirect(['/employee/view', 'id' => $model->emp_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model2'=>$model2,
            ]);
        }
    }

    /**
     * Updates an existing EmplEducationalHistoryInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $u_id=yii::$app->request->get('u_id');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/employee/view', 'id' => $model->emp_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'u_id'=>$u_id,
            ]);
        }
    }

    /**
     * Deletes an existing EmplEducationalHistoryInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmplEducationalHistoryInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmplEducationalHistoryInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmplEducationalHistoryInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
