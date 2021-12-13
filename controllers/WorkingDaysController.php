<?php

namespace app\controllers;

use Yii;
use app\models\WorkingDays;
use app\models\search\WorkingDaysSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkingDaysController implements the CRUD actions for WorkingDays model.
 */
class WorkingDaysController extends Controller
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
     * Lists all WorkingDays models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkingDaysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkingDays model.
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
     * Creates a new WorkingDays model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * if(count($exists) > 0){
        $model = EmployeeAttendance::findOne($exists->id);
       }else{
            $model = new EmployeeAttendance();
        }
     */
     
    public function actionDay(){
        $model=new WorkingDays();
        $id=$_POST['id'];
        
       $matchId=WorkingDays::find()->where(['id'=>$id,'fk_branch_id'=>Yii::$app->common->getBranch()])->one();
       if($matchId->is_active == 0 and $matchId->fk_branch_id=Yii::$app->common->getBranch()){
        Yii::$app->db->createCommand("update working_days set is_active='1',fk_branch_id ='".Yii::$app->common->getBranch()."' WHERE id=".$id."")->execute();
       }else if($matchId->is_active == 1 and $matchId->fk_branch_id=Yii::$app->common->getBranch()){
         Yii::$app->db->createCommand("update working_days set is_active='0' ,fk_branch_id ='".Yii::$app->common->getBranch()."' WHERE id=".$id."")->execute();
       }
       
       
    }
    
     public function actionStuDay(){
        $id=$_POST['id'];
       $matchId=WorkingDays::find()->where(['id'=>$id,'fk_branch_id'=>Yii::$app->common->getBranch()])->one();
       if($matchId->is_active_stu == 0 and $matchId->fk_branch_id=Yii::$app->common->getBranch()){
        Yii::$app->db->createCommand("update working_days set is_active_stu='1' ,fk_branch_id ='".Yii::$app->common->getBranch()."' WHERE id=".$id."")->execute();
       }else if($matchId->is_active_stu == 1 and $matchId->fk_branch_id=Yii::$app->common->getBranch()){
         Yii::$app->db->createCommand("update working_days set is_active_stu='0' ,fk_branch_id ='".Yii::$app->common->getBranch()."' WHERE id=".$id."")->execute();
       }
    }
     
    public function actionCreate()
    {
        $model = new WorkingDays();
        $model->is_active=1;

        if ($model->load(Yii::$app->request->post())) {
          $model->save();
            return $this->redirect(['view', 'id' => $mdl->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
     public function actionStuSettings()
    {
        $model = new WorkingDays();

        if ($model->load(Yii::$app->request->post())) {
          $model->save();
            return $this->redirect(['view', 'id' => $mdl->id]);
        } else {
            return $this->render('createA', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkingDays model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WorkingDays model.
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
     * Finds the WorkingDays model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkingDays the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkingDays::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
