<?php

namespace app\controllers;

use app\models\RefGroup;
use Yii;
use app\models\RefSection;
use app\models\StudentInfo;
use app\models\RefSectionSearch;
use app\models\StudentInfoSearch;
use app\models\StudentEducationalHistoryInfo;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

/**
 * RefSectionController implements the CRUD actions for RefSection model.
 */
class SectionController extends Controller
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

    /**
     * Lists all RefSection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefSectionSearch();
        if(yii::$app->request->get('cid')){
            $searchModel->class_id = yii::$app->request->get('cid');
        }

        if(count(Yii::$app->request->get())== 0 ){
            $searchModel->class_id = 0;
        }
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        $searchModel->status = 'active';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'class_id'=>yii::$app->request->get('cid'),
            'group_id'=>yii::$app->request->get('gid'),
        ]);
    }

    public function actionSectionResult()
    {    
        $searchModel = new RefSectionSearch();
        if(yii::$app->request->get('cid')){
            $searchModel->class_id = yii::$app->request->get('cid');
        }
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single RefSection model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "RefSection #".$id,
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
     * Creates a new RefSection model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new RefSection();
        $class_id = yii::$app->request->get('cid');
        $group_id = yii::$app->request->get('gid');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new RefSection",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new RefSection",
                    'content'=>'<span class="text-success">Create RefSection success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create','cid'=>$class_id,'gid'=>$group_id],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{

                return [
                    'title'=> "Create new RefSection",
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
                return $this->redirect(['view', 'id' => $model->section_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing RefSection model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $class_id = yii::$app->request->get('cid');
        $group_id = yii::$app->request->get('gid');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Section : ".$model->title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Section : ".$model->title,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id,'cid'=>$class_id,'gid'=>$group_id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Section : ".$model->title,
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
                return $this->redirect(['view', 'id' => $model->section_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }



    // get student on base of section_id
    public function actionGet1($id){
       // echo 'adfadf';die;
        $query=StudentInfo::find()->where(['section_id'=>$id])->one();
        //echo '<pre>';print_r($query);die;
            $provider = new ActiveDataProvider([
                'query' => $query,
            ]);
            $this->render('getStudents', ['provider' => $provider]);
            
    }
    public function actionGet2($id)
    {
        $model=StudentInfo::findOne(['section_id'=>$id]);
        $model2=StudentEducationalHistoryInfo::findOne(['stu_id'=>$id]);

        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }else {
            return $this->render('getStudents', [
                //'model' => $this->findModel($id),
                'model'=>$model,
                'model2'=>$model2
            ]);
        }
    }
    public function actionGet()
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }else{
            $searchModel = new StudentInfoSearch();
            $sectionId = Yii::$app->request->get('sid');
            if($sectionId){
                $searchModel->group_id = $sectionId;
            }
            $searchModel->fk_branch_id = Yii::$app->common->getBranch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('getStudents', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    // end of get student on base of section_id

    /**
     * Delete an existing RefSection model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->status = 'inactive';
        $model->save();
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
     * Delete multiple existing RefSection model.
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
     * Finds the RefSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefSection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetGroups(){
        if(yii::$app->user->isGuest){
            return $this->goHome();
        }else{
            if(yii::$app->request->isAjax){
                $id = Yii::$app->request->post('cid');
                $groupData = RefGroup::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'fk_class_id'=>$id])->all();
                $select = '<option value="">Select Group ...</option>';
                if($groupData) {
                    foreach ($groupData as $item) {
                        $select .= '<option value="' . $item->group_id . '">' . $item->title . '</option>';
                    }
                }
                return $select;
            }
        }
    }
}
