<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\EmployeeInfo;
use app\models\search\EmployeeInfoSearch;
use app\models\EmployeeParentsInfo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeInfoController implements the CRUD actions for EmployeeInfo model.
 */
class EmployeeController extends Controller
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
     * Lists all EmployeeInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeeInfo model.
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
     * Creates a new EmployeeInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmployeeInfo();
        $model2 = new EmployeeParentsInfo();
        $usermodel = new User();

        /*assigning predefined values*/
        $model->marital_status=1;
        $model->gender_type=1;
        // if(Yii::$app->request->post()){
        //     //echo "<pre>";print_r(Yii::$app->request->post());exit;
        // }

        if ($usermodel->load(Yii::$app->request->post())){

            $random_password= Yii::$app->getSecurity()->generateRandomString($length = 7);
            $usermodel->setPassword($random_password);
            $usermodel->generateAuthKey();
            $usermodel->fk_branch_id=1;
            $usermodel->fk_role_id=1;
            $usermodel->status=1;
            $usermodel->created_at=1478781110;
            $usermodel->updated_at=1478781110;

            if($usermodel->save()){
                $user_id=$usermodel->id;
                if ($model->load(Yii::$app->request->post())){
                    $model->user_id=$usermodel->id;
                    $model->fk_branch_id=1;
                    if($model->save()){
                        if ($model2->load(Yii::$app->request->post())){
                            $model2->emp_id=$model->emp_id;
                            if($model2->save()){
                                return $this->redirect(['emp-education/create', 'id' => $model->user_id]);
                            }else{
                                return $this->render('create', [
                            'model' => $model,
                            'model2' => $model2,
                            'usermodel' => $usermodel,
                                ]);
                            }
                         }
                    }else{
                         //print_r($model->getErrors());die;
                         return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
                'usermodel' => $usermodel,
            ]);
                    }
                }
            }else{
             return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
                'usermodel' => $usermodel,
            ]);
            
            //return $this->redirect(['create', 'id' => $model->emp_id]);
            }

        } else {
           // print_r($model->getErrors());die;
            return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
                'usermodel' => $usermodel,
            ]);
        }
    }

    /**
     * Updates an existing EmployeeInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $usermodel=User::find()->where(['id'=>$model->user_id])->one();

        $model2=EmployeeParentsInfo::find()->where(['emp_id'=>$id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($usermodel->load(Yii::$app->request->post())){
                $usermodel->status=1;
               if($usermodel->save()){
                if($model2->load(Yii::$app->request->post())){
                    $model2->save();
               }
               }else{
                //print_r($usermodel->getErrors());die;
               }
             }
            return $this->redirect(['view', 'id' => $model->emp_id]);
        } else {
            //print_r($model->getErrors());die;
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
                'usermodel' => $usermodel,
            ]);
        }
    }

    /**
     * Deletes an existing EmployeeInfo model.
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
     * Finds the EmployeeInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployeeInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployeeInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
