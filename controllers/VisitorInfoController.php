<?php
namespace app\controllers;

use Yii;
use app\models\VisitorInfo;
use app\models\search\VisitorInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RefProvince;
use app\models\RefDistrict;
use app\models\RefCities;
use app\models\RefGroup;
use app\models\VisitorResponseInfo;

/**
 * VisitorInfoController implements the CRUD actions for VisitorInfo model.
 */
class VisitorInfoController extends Controller
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
     * Lists all VisitorInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitorInfoSearch();
        if(count(Yii::$app->request->get())== 0 ){
            $searchModel->id = 0;
        }
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitorInfo model.
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
     * Creates a new VisitorInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VisitorInfo();
        $model2 = new VisitorResponseInfo();

        if ($model->load(Yii::$app->request->post()) ) {
            $post_result = Yii::$app->request->post();
            
             $model->admin_personel_observation = implode(",",$_POST['VisitorInfo']['admin_personel_observation']);
             $model->is_active= 1;
             $model->fk_branch_id=Yii::$app->common->getBranch();
            if($model->save()){
                if($model2->load(Yii::$app->request->post())){
                $model2->fk_admission_vistor_id=$model->id;
                  $model2->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo "<pre>";
                print_r($model->getErrors());exit;
            }
        } else {
           // print_r($model->getErrors());die;
            return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    /**
     * Updates an existing VisitorInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2=VisitorResponseInfo::find()->where(['fk_admission_vistor_id'=>$id])->one();
        $model->admin_personel_observation = explode(',', $model->admin_personel_observation); 
       if($model->load(Yii::$app->request->post())) {
        $model->admin_personel_observation = implode(",",$_POST['VisitorInfo']['admin_personel_observation']);
         if($model->save()){
            if($model2->load(Yii::$app->request->post())){
               $model2->save();
             }
             
            return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    /**
     * Deletes an existing VisitorInfo model.
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
     * Finds the VisitorInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VisitorInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VisitorInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    // country
    public function actionCountry(){
        $id=Yii::$app->request->post('id');
        $provinces=RefProvince::find()->where(['country_id'=>$id])->all();
        echo "<option selected='selected'>Select Provinces</option>";
        foreach($provinces as $province)
        {
         echo "<option value='".$province->province_id."'>".$province->province_name."</option>";
        } }//end of country 

    public function actionProvince(){
        $id=Yii::$app->request->post('id');
        $District=RefDistrict::find()->where(['province_id'=>$id])->all();
        echo "<option selected='selected'>Select District</option>";
        foreach($District as $district)
        {
          echo "<option value='".$district->district_id."'>".$district->District_Name."</option>";
        }}//end of Province 

        public function actionDistrict(){
        $id=Yii::$app->request->post('id');
        $city=RefCities::find()->where(['district_id'=>$id])->all();
        echo "<option selected='selected'>Select City</option>";
        foreach($city as $city)
        {
          echo "<option value='".$city->city_id."'>".$city->city_name."</option>";
        } }//end of District

        public function actionGroup(){
        $id=Yii::$app->request->post('id');
        $group=RefGroup::find()->where(['fk_class_id'=>$id])->all();
        echo "<option selected='selected'>Select Group</option>";
       foreach($group as $group)
       {
        echo "<option value='".$group->group_id."'>".$group->title."</option>";
        } }//end of Section

}// end of main class
