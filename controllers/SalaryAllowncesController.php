<?php

namespace app\controllers;

use Yii;
use app\models\SalaryAllownces;
use app\models\SalaryPayStages;
use app\models\SalaryDeductionType;
use app\models\EmployeeSalarySelection;
use app\models\search\SalaryAllowncesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * SalaryAllowncesController implements the CRUD actions for SalaryAllownces model.
 */
class SalaryAllowncesController extends Controller
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
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionGetStages(){
    
        $id=Yii::$app->request->post('id');
        $stage= SalaryPayStages::find()->where(['status'=>1,'fk_branch_id'=>yii::$app->common->getBranch(),'fk_pay_groups'=>$id])->all();
     
        echo "<option selected='selected'>Select Stages</option>";
        foreach($stage as $stage)
        {
            echo "<option value='".$stage->id."'>".$stage->title."</option>";
            
        }
    
   } 
   
    public function actionGetSalary(){
    //echo 'adf';die;
         $id=Yii::$app->request->post('id');
        $groups=Yii::$app->request->post('groups');
        $ammount= SalaryPayStages::find()->where(['fk_pay_groups'=>$groups,'id'=>$id])->one();
        echo $ammount->amount;
       // echo "<option selected='selected'>Select Salary</option>";
        //foreach($ammount as $ammount)
       // {
        //    echo "<option value='".$ammount->id."'>".$ammount->amount."</option>";
            
       // }
    
   }
   
   public function actionGetStageAmount(){
    //echo 'adf';die;
         $id=Yii::$app->request->post('id');
    
        $stageamount= SalaryAllownces::find()->where(['fk_stages_id'=>$id])->all();
        echo '<pre>';print_r($stageamount);die;
       // echo "<option selected='selected'>Select Salary</option>";
        foreach($stageamount as $stageamount)
        {
            echo $stageamount->amount;
           // echo "<option value='".$stageamount->id."'>".$stageamount->amount."</option>";
            
        }
    
   }
   public function actionGetDeductionAmount(){
   // echo 'adsfs';
          $id=Yii::$app->request->post('id');
          $stage=Yii::$app->request->post('stage');
        $stageamount= SalaryDeductionType::find()->where(['fk_stages_id'=>$stage])->one();
        echo $stageamount->amount;
       // print_r($stageamount);
       // echo "<option selected='selected'>Select Salary</option>";
        

    
   }
   
    public function actionSa(){
    //echo 'adsfs';
          $id=Yii::$app->request->post('hideamnt');
          $stage=Yii::$app->request->post('getdys');
          echo $stage*$id;
          //echo $stageamount->amount;
       // print_r($stageamount);
       // echo "<option selected='selected'>Select Salary</option>";
        

    
   }
   
   public function actionGetAllownce(){
          $id=Yii::$app->request->post('id');
          $stageamount= SalaryAllownces::find()->where(['id'=>$id])->one();
          echo $stageamount->amount;
        
  }
  
  

    /**
     * Lists all SalaryAllownces models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new SalaryAllowncesSearch();
        $searchModel->fk_branch_id=yii::$app->common->getBranch();
        $searchModel->status=1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single SalaryAllownces model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "SalaryAllownces #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new SalaryAllownces model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new SalaryAllownces();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new SalaryAllownces",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new SalaryAllownces",
                    'content'=>'<span class="text-success">Create SalaryAllownces success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new SalaryAllownces",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing SalaryAllownces model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update SalaryAllownces #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "SalaryAllownces #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update SalaryAllownces #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing SalaryAllownces model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing SalaryAllownces model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the SalaryAllownces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalaryAllownces the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalaryAllownces::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
