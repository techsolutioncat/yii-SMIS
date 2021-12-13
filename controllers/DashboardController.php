<?php

namespace app\controllers;

use Yii;
use app\models\Dashboard;
use app\models\search\Dashboard as DashboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class DashboardController extends Controller
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
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dashboard model.
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
     * Creates a new Dashboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dashboard();
        $count = 0;
        if ($model->load(Yii::$app->request->post()))
        {
            $count  =  Dashboard::find()->where(['fk_branch_id'=>null/*Yii::$app->common->getBranch()*/])->count();
            $model->sort_order = $count;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo "<pre>";
                print_r($model->getErrors());exit;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dashboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo "<pre>";
                print_r($model->getErrors());exit;
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dashboard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /*inactive pallet */
    public function actionInactivePallet(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if($data['pallet_id']){
                $model=$this->findModel($data['pallet_id']);
                $model->status = 0;
                $model->save();
                return json_encode(['status'=>1]);
            }
        }
    }

    /*inactive pallet */
    public function actionActivePallet(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if($data['pallet_id']){
                $model=$this->findModel($data['pallet_id']);
                $model->status = $data['status'];
                $model->save();
                return json_encode(['status'=>1]);
            }
        }
    }

    /**
     * Finds the Dashboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dashboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dashboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
