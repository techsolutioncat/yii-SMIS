<?php

namespace app\controllers;

use app\models\FeeHeads;
use Yii;
use app\models\Settings;
use yii\helpers\ArrayHelper;
use app\models\search\SettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        $model =  Settings::find()->where(['fk_branch_id'=> Yii::$app->common->getBranch()])->One();
        $modelFeeHeads = FeeHeads::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all();
        $arrayFeeHead = ArrayHelper::map($modelFeeHeads,'id','title');


        if(count($model) == 0){
            $model = new Settings();
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->fk_branch_id=Yii::$app->common->getBranch();
            if($model->save()){
                \Yii::$app->getSession()->setFlash('success', 'Settings has been updated.');
                return $this->render('settings', [
                    'model' => $model,
                    'modelHead' => $arrayFeeHead,
                    'modelFeeHeads' => $modelFeeHeads,
                ]);
            }
        } else {
            return $this->render('settings', [
                'model' => $model,
                'modelHead' => $arrayFeeHead,
                'modelFeeHeads' => $modelFeeHeads,
            ]);
        }
    }

    /**
     * Displays a single Settings model.
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
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($model->load(Yii::$app->request->post())) {
            $model->fk_branch_id = yii::$app->common->getBranch();
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,

                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Settings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Settings model.
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
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
