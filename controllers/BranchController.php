<?php

namespace app\controllers;

use Yii;
use app\models\Branch;
use app\models\search\BranchSearch;
use app\models\WorkingDays;
use app\models\RefProvince;
use app\models\RefDistrict;
use app\models\FeeGroup;
use app\models\FeePlanType;
use app\models\RefCities;
use app\models\Settings;
use app\models\FeePaymentMode;
use app\models\FeeHeads;
use app\models\RefClass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use app\models\RefSession;

/**
 * BranchController implements the CRUD actions for Branch model.
 */
class BranchController extends Controller
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
     * Lists all Branch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BranchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Branch model.
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
     * Creates a new Branch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Branch();
        $model2 = new RefClass();
        $FeePaymentMode = new FeePaymentMode();
        $FeeHeads = new FeeHeads();
        $settings = new Settings();
        $FeeGroup = new FeeGroup();
        $FeePlanType = new FeePlanType();

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['index', 'id' => $model->id]);
            return $this->redirect(['index']);
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'model2'  =>$model2,
                'FeePaymentMode'  =>$FeePaymentMode,
                'FeeHeads'  =>$FeeHeads,
                'settings'  =>$settings,
                'FeeGroup'  =>$FeeGroup,
                'FeePlanType'  =>$FeePlanType,

            ]);
        }
    }

    /**
     * Updates an existing Branch model.
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
     * Deletes an existing Branch model.
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
     * Finds the Branch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionGetInput(){
        $rows=yii::$app->request->post('rows');
        $views=$this->renderAjax('get-input',['rows'=>$rows]);
        return json_encode(['views'=>$views]);
    }

    public function actionFeeMood(){
        $rows=yii::$app->request->post('rows');
        $views=$this->renderAjax('get-fee-modd',['rows'=>$rows]);
        return json_encode(['views'=>$views]);
    }

    public function actionFeeHeads(){
         $rows=yii::$app->request->post('rows');
         $branch=yii::$app->request->post('branch'); 
         $getFeePln=FeePaymentMode::find()->where(['fk_branch_id'=>$branch])->All();
         $brnch= "<option value=''>Select Fee Head</option>";
         foreach ($getFeePln as $plan) {
            $brnch.= "<option value='".$plan->id."'>".$plan->title."</option>";
            
        }

        $views=$this->renderAjax('get-fee-heads',['rows'=>$rows]);
        return json_encode(['views'=>$views,'branch'=>$brnch]);
    }

      

    public function actionFeeHeadsCreate(){

        $branch=Yii::$app->request->post('branch');
        $getFeePln=FeePaymentMode::find()->where(['fk_branch_id'=>$branch])->all();

        echo "<option selected='selected'>Select Heads</option>";
        foreach($getFeePln as $getFeePlns)
        {

                echo "<option value='".$getFeePlns->id."'>".$getFeePlns->title."</option>";

        }


    }//end of country
    
    public function actionFeePlanType(){
        $rows=yii::$app->request->post('rows');
        $views=$this->renderAjax('fee-paln-type',['rows'=>$rows]);
        return json_encode(['views'=>$views]);
    }

    public function actionCreateBranch(){

        if(Yii::$app->request->post()){
            //echo '<pre>';print_r($_POST);die;
            // echo $branch_id= $_POST['Branch']['branch_name'];
           //  die;
                $existx=Branch::find()->where(['id'=>$_POST['Branch']['branch_name']])->one();
               // echo $existx;die;   
                      if(count($existx) > 0){
                        
                        $model = Branch::findOne($existx->id);
                       }else{
                        
                            $model = new Branch();
                        }



           
           
            if($model->load(Yii::$app->request->post())){
                //echo '<pre>';print_r($_POST);die;
               


                $file_logo = UploadedFile::getInstance($model, 'logo');
                if (!empty($file_logo)){
                    /*unlink old image logo*/
                    /*if($model->get('logo')){
                        unlink(\Yii::getAlias('@frontend').'/web/uploads/logos/'.$model->get('site_logo'));
                    }*/
                    /*when user upload new image of logo*/
                    $model->logo = $file_logo;
                    $file_name = str_replace(" ", "-", strtolower($file_logo->baseName)) .'-'.date('YmdHis') .'.' . strtolower($file_logo->extension);
                    $file_name_thumb = str_replace(" ", "-", strtolower($file_logo->baseName)) .'-'.date('YmdHis'). '_thumb.' . strtolower($file_logo->extension);
                    $uploadDir = \Yii::getAlias('@webroot') . '/uploads/school-logo/';
                    if(!(file_exists($uploadDir)))
                    {
                        FileHelper::createDirectory($uploadDir,0777);
                    }
                    $uploadFile =$uploadDir.$file_name;
                    $uploadFile_thumb=$uploadDir.$file_name_thumb;
                    Image::getImagine()->open($file_logo->tempName)->thumbnail(new Box(230, 200))->save($uploadDir.$file_name_thumb , ['quality' => 90]);
                    /*image commented but can use incase if you need to save actual size image*/
                    $model->logo->saveAs($uploadFile);
                    $model->logo = $file_name_thumb;
                }

                if($model->save()){
                    //echo $branhId=$model->id;
                    //echo $model->id;
                    //die;
                   /* $existSession=RefSession::find()->where(['fk_branch_id'=>$_POST['Branch']['branch_name']])->one();
                        echo count($existSession);
                        
                        if(count($existSession) > 0){
                            echo '1';
                           $refSession = RefSession::findOne($existSession->session_id);
                       }else{
                        echo 'update';
                        
                            $refSession = new RefSession();
                        }*/

                    /*$refSession=new \app\models\RefSession;
                    $refSession->fk_branch_id = $model->id;
                    $refSession->title=$_POST['Branch']['title'];

                    if($refSession->save()){}else{
                        echo '<pre>';print_r($refSession->getErrors());
                      }*/
                     /*$exists=Branch::find()->where(['id'=>$model->id])->one();
                      if(count($exists) > 0){
                        $model = Branch::findOne($exists->id);
                       }else{
                            $model = new Branch();
                        }*/
                   /* yii::$app->db->createCommand("insert into dashboard (`fk_branch_id`,`title`,`icon`,`details`,`type`,`sort_order`,`status`) select ".$model->id.",`title`,`icon`,`details`,`type`,`sort_order`,`status` from dashboard where fk_branch_id is Null")->execute();*/

                    $branch_admin =  new \app\models\User();
                    $branch_admin->fk_branch_id = $model->id;
                    $branch_admin->first_name   ='branch';
                    $branch_admin->last_name    ='admin';
                    $branch_admin->username     = str_replace(' ', '@s', $model->name);
                    $random_password='@moment2016';
                    $branch_admin->setPassword($random_password);
                    $branch_admin->generateAuthKey();
                    $branch_admin->fk_role_id      = 1;
                    $branch_admin->email           = yii::$app->request->post('email');
                    $branch_admin->status          = 'active';
                    //$branch_admin->save();
                    if($branch_admin->save()){
                        /*create days settings*/
                        $workingDayxExist=WorkingDays::find()->where(['fk_branch_id'=>$_POST['Branch']['branch_name']])->one();
               // echo $existx;die;   
                      if(count($workingDayxExist) > 0){
                       }else{

                         yii::$app->db->createCommand("insert into dashboard (`fk_branch_id`,`title`,`icon`,`details`,`type`,`sort_order`,`status`) select ".$model->id.",`title`,`icon`,`details`,`type`,`sort_order`,`status` from dashboard where fk_branch_id is Null")->execute();
                           
                        
                        $daysArray= ['Mon' => 'Mon','Tue' => 'Tue', 'Wed' => 'Wed','Thu'=>'Thu','Fri'=>'Fri','Sat'=>'Sat','Sun'=>'Sun'];
                        foreach($daysArray as $days){
                            $mdl=new WorkingDays();
                            $mdl->title=$days;
                            $mdl->fk_branch_id=$model->id;
                            if($mdl->save()){

                            }else{
                                //print_r($mdl->getErrors());die;
                            }
                        }
                    } // end of exist else
                        /*end of create days setting*/
                    }else{
                       // print_r($branch_admin->getErrors());die;
                    }
                    return json_encode(['status'=>1,'branch_id'=>$model->id]);

                }else{
                    //echo "<pre>";print_r($model->getErrors());exit;
                }
            }

        } 
    }

    public function actionCreateClass(){
        
        $class=yii::$app->request->post('cls');
        $status=yii::$app->request->post('status');
        $session=yii::$app->request->post('session');
        $updateclass=yii::$app->request->post('updateclass');
       
        $inputClass="";       

        foreach ($class as $key => $classess) {
            if($status == 'create'){
             $model=new RefClass();
        }else{  
              $updateclass=yii::$app->request->post('updateclass');
            if (isset($updateclass[$key])) {
               
               $model=RefClass::find()->where(['fk_branch_id'=>yii::$app->request->post('branchid'),'class_id'=>$updateclass[$key]])->one(); 
               
            }else{
                $model= new RefClass();
            }
      
        }
            $model->title=$classess;
            $model->fk_session_id=yii::$app->request->post('session');
            $model->fk_branch_id=yii::$app->request->post('branchid');


            if($model->save()){

                 $inputClass.="<input type='hidden' class='cls_db_id' value=".$model->class_id.">";

            }else{
                    //print_r($model->getErrors());die;
                 }
        } 

        $getclasses= RefClass::find()->where(['fk_branch_id'=>yii::$app->request->post('branchid')])->all();
        $clssview=$this->renderAjax('get-classes',['clas'=>$getclasses]);
        $statusUpdate="update";

        return json_encode(['classview'=>$clssview,'inputclass'=>$inputClass,'statusUpdate'=>$statusUpdate]);


    }

     public function actionCreateFeePlan(){
        //echo "adsf";die;
        $mod=yii::$app->request->post('mod');
        $month=yii::$app->request->post('month');
        $branch=yii::$app->request->post('branchid');
        $updateclass=yii::$app->request->post('updateclass');
        $status=yii::$app->request->post('status');


        $lastId="";
        foreach ($mod as $key => $mods) {

            if($status == 'create'){
                //echo 'here';
             $model=new FeePaymentMode();
             }else{
             //echo 'this';  
              $updateclass=yii::$app->request->post('updateclass');
            if (isset($updateclass[$key])) {
               
               $model=FeePaymentMode::find()->where(['fk_branch_id'=>yii::$app->request->post('branchid'),'id'=>$updateclass[$key]])->one(); 
               
            }else{
                $model= new FeePaymentMode();
            }
      
        }
            //echo '<pre>';print_r($key);
            //echo '<pre>';print_r($mods);
            $model->title=$mods;
            $model->time_span=yii::$app->request->post('month')[$key];
            $model->fk_branch_id=yii::$app->request->post('branchid');
            if($model->save()){
                $lastId.="<input type='hidden' class='paymentmode_db_id' value=".$model->id.">";
                $statusUpdate="update";



            }else{
                    print_r($model->getErrors());die;
                 }
        }
        $getFeePln=FeePaymentMode::find()->where(['fk_branch_id'=>$branch])->All();
         $feeHeadOptions= "<option value=''>Select Fee Head</option>";
        foreach ($getFeePln as $plan) {
            $feeHeadOptions.= "<option value='".$plan->id."'>".$plan->title."</option>";
            
        }
        return json_encode(['lastid'=>$lastId,'statusUpdate'=>$statusUpdate,'feeHeadOptions'=>$feeHeadOptions]);

    } // end of function

    public function actionCreateFeeHead(){
        
        $heads=yii::$app->request->post('heads');
        //print_r($class);
        $method=yii::$app->request->post('method');
        $updateclass=yii::$app->request->post('updateclass');
         $status=yii::$app->request->post('status');
        $lastId="";
        foreach ($heads as $key => $headss) {
            

            if($status == 'create'){
               // echo 'here';
             $model=new FeeHeads();
             }else{  
               // echo 'this';
              $updateclass=yii::$app->request->post('updateclass');
            if (isset($updateclass[$key])) {
               // echo $updateclass[$key];
               
               $model=FeeHeads::find()->where(['fk_branch_id'=>yii::$app->request->post('branchid'),'id'=>$updateclass[$key]])->one(); 
               
            }else{
                $model= new FeeHeads();
            }
      
        }
            //print_r($classess);
            $model->title=$headss;
            $model->fk_fee_method_id=yii::$app->request->post('method')[$key];
            $model->fk_branch_id=yii::$app->request->post('branchid');
            $model->created_date=date("Y:m:d H:i:s");


            if($model->save()){

                $lastId.="<input type='hidden' class='head_db_id' value=".$model->id.">";

                


            }else{
                    print_r($model->getErrors());die;
                 }
        }


        $getHeads=FeeHeads::find()->where(['fk_branch_id'=>yii::$app->request->post('branchid')])->all();
        $head="<option value=''>Select Fee Head</option>";
        foreach ($getHeads as $heads) {
            $head.= "<option value='".$heads->id."'>".$heads->title."</option>";
          
        }
        $statusUpdate="update";
       return json_encode(['headx'=>$head,'lastId'=>$lastId,'statusUpdate'=>$statusUpdate]);

    }

    public function actionSettings(){

        $model = new Settings();

         $model->fee_due_date=yii::$app->request->post('fee');
         $model->school_time_in=yii::$app->request->post('intime');
         $model->school_time_out=yii::$app->request->post('outtime');
         $model->theme_color=yii::$app->request->post('theme');
         $model->fee_bank_name=yii::$app->request->post('bankname');
         $model->fee_bank_account=yii::$app->request->post('bankacount');
         $model->salary_bank_name=yii::$app->request->post('salry');
         $model->salary_bank_account=yii::$app->request->post('salryBnkacnt');
         $model->fk_branch_id=yii::$app->request->post('branchid');


         if($model->save()){
            
            return $this->redirect(['index']);
         }else{
            print_r($model->getErrors());die;
         }
    } // end of settings


    public function actionCountry(){
       echo  $id=Yii::$app->request->post('id');
        $provinces=RefProvince::find()->where(['country_id'=>$id])->all();

    echo "<option></option>";
    foreach($provinces as $province)
    {

            echo "<option value='".$province->province_id."'>".$province->province_name."</option>";

    }


    }//end of country

     public function actionProvince(){
        $id=Yii::$app->request->post('id');
        $District=RefDistrict::find()->where(['province_id'=>$id])->all();
        echo "<option></option>";
        foreach($District as $district)
        {
        echo "<option value='".$district->district_id."'>".$district->District_Name."</option>";
        } }//end of Province

        public function actionDistrict(){

        $id=Yii::$app->request->post('id');
        $city=RefCities::find()->where(['district_id'=>$id])->all();

    echo "<option></option>";
    foreach($city as $city)
    {

            echo "<option value='".$city->city_id."'>".$city->city_name."</option>";

    }


    }//end of District


     public function actionCreateAssignFee(){
        $feeHead=Yii::$app->request->post('feeHeads');

        $ammount=Yii::$app->request->post('ammount');

        $classes=Yii::$app->request->post('getclass');

       $branch=Yii::$app->request->post('branchid');

       $existsclass=FeeGroup::find()->where(['fk_fee_head_id'=>$feeHead,'fk_class_id'=>$classes])->one();
       if($existsclass){
           echo  "Already Assigned";
       }else{

        $msg=0;
        foreach ($classes as $clas) {
            //$msg++;
            $model=new FeeGroup();
            $model->fk_class_id=$clas;
            $model->fk_fee_head_id=Yii::$app->request->post('feeHeads');
            $model->amount=Yii::$app->request->post('ammount');
            $model->created_date=date("Y:m:d H:i:s");
            $model->is_active='yes';
            $model->fk_branch_id=Yii::$app->request->post('branchid');
            if($model->save()){
               // echo "Succesfuly Assign";
                //break;
              //$msg.="assign successfully";


            }else{
                print_r($model->getErrors());die;
            }
            
        }
        if($msg == 0){
                echo "Assignment successful";
            }

        //return json_encode(['msg'=>$msg]);

    }



     }


     public function actionCreateFeeTypex(){
        //echo "adsf";die;
        $instal=yii::$app->request->post('instal');
        $typefee=yii::$app->request->post('typefee');
        $b=yii::$app->request->post('branchid');
        $updateclass=yii::$app->request->post('updateclass');
        $status=yii::$app->request->post('status');
        $lastIdPlan="";
         foreach ($typefee as $key => $mods) {

            if($status == 'create'){
               // echo 'here';
             $model=new FeePlanType();

             }else{  
               // echo 'this';
              $updateclass=yii::$app->request->post('updateclass');
            if (isset($updateclass[$key])) {
               // echo $updateclass[$key];
               
               $model=FeePlanType::find()->where(['fk_branch_id'=>yii::$app->request->post('branchid'),'id'=>$updateclass[$key]])->one(); 
               
            }else{
                $model= new FeePlanType();
            }
      
        }
            //echo '<pre>';print_r($key);
            //echo '<pre>';print_r($mods);
            $model->title=$mods;
            $model->no_of_installments=yii::$app->request->post('instal')[$key];
            $model->fk_branch_id=yii::$app->request->post('branchid');
            if($model->save()){
                $lastIdPlan.="<input type='hidden' class='plantype_db_id' value=".$model->id.">";
                

            }else{
                    print_r($model->getErrors());die;
                 }
        } 
        $statusUpdate="update";
        return json_encode(['statusUpdate'=>$statusUpdate,'lastIdPlan'=>$lastIdPlan]);
        }// end of function


        public function actionBranchExists(){
        $existsbranch=Branch::find()->where(['name'=>yii::$app->request->post('name')])->one();
        if($existsbranch){
                echo "Branch Already Exists";
        }else{

        }
        }
}
