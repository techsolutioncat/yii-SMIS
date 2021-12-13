<?php
namespace app\controllers;

use Yii;
use app\models\EmployeeSalarySelection;
use app\models\SalaryMain;
use app\models\search\EmployeeSalarySelectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeSalarySelectionController implements the CRUD actions for EmployeeSalarySelection model.
 */
class EmployeeSalarySelectionController extends Controller
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
    
   /* public function actionGetEmployee(){
           $id=Yii::$app->request->post('id');
          $emp= EmployeeSalarySelection::find()->where(['fk_emp_id'=>$id])->All();
         // print_r($emp);
          foreach($emp as $empl){
          return json_encode(['stage'=>$empl->fkPayStages->title,'stageid'=>$empl->fk_pay_stages,'groupid'=>$empl->fk_group_id,'group'=>$empl->fkGroup->title,'allownce'=>$empl->fk_allownces_id,'getAllownceTxt'=>$empl->fkAllownces->title]);
          }
        
  }*/

   public function actionGetEmployee(){
          $id=Yii::$app->request->post('id');
          $exist=SalaryMain::find()->where(['fk_emp_id'=>$id])->one();
          if(count($exist)>0){
            //$e=$exist->fk_emp_id;
           $c_date=date('m');
           $mon=date('m',strtotime($exist->salary_month));
           if($c_date == $mon){
            $exist= 'This Employee Has Already Been Taken Salary This Month';
           }
          }
           
          $emp=Yii::$app->db->createCommand("SELECT CONCAT(u.first_name,' ', u.last_name) as `employee name` , ess.fk_emp_id,spg.title as `salary_pay_group`,sps.title as `salary_pay_stages`,sps.amount `Basic_Salary`,sum(sa.amount) as `total_allownces`,sum(efdd.amount) as `total_fix_deduction`,sa.title as sa_title ,efdd.title as ded_title FROM `employee_salary_selection` ess
                   inner join salary_pay_groups spg on spg.id = ess.fk_group_id
                   inner join salary_pay_stages sps on sps.id= ess.fk_pay_stages
                   left join salary_allownces sa on sa.id=ess.fk_allownces_id
                   left join salary_deduction_type efdd ON efdd.id =ess.fk_fix_deduction_detail
                   inner join employee_info ei on ei.emp_id=ess.fk_emp_id
                   inner join user u on u.id=ei.user_id where ess.fk_emp_id='".$id."' 
                   group by ess.fk_emp_id,spg.title,sps.title,sps.amount,sa.title,efdd.title")->queryAll();
          // $emplyoe_payroll = \app\models\EmployeeSalarySelection::find()->where(['fk_emp_id'=>$id])->groupBy('fk_emp_id')->One();

          $emplyoe_payroll= Yii::$app->db->createCommand("SELECT CONCAT(u.first_name,' ', u.last_name) as `employee_name` , ess.fk_emp_id,spg.id as `group_id`,spg.title as `salary_pay_group`,sps.id as `stage_id`,sps.title as `salary_pay_stages`,sps.amount `Basic_Salary`,sum(sa.amount) as `total_allownces`,sum(efdd.amount) as `total_fix_deduction`, (sps.amount + ifnull(sum(sa.amount),0) - ifnull(sum(efdd.amount),0)) as `gros_salary` FROM `employee_salary_selection` ess inner join salary_pay_groups spg on spg.id = ess.fk_group_id inner join salary_pay_stages sps on sps.id= ess.fk_pay_stages left join salary_allownces sa on sa.id=ess.fk_allownces_id left join salary_deduction_type efdd ON efdd.id =ess.fk_fix_deduction_detail inner join employee_info ei on ei.emp_id=ess.fk_emp_id inner join user u on u.id=ei.user_id where ess.fk_emp_id='".$id."' group by ess.fk_emp_id,spg.id,sps.id,spg.title,sps.title,sps.amount")->queryOne();



          if(count($emp)>0){
            $veiws=$this->renderAjax('empsalary_detail',['emp'=>$emp,'basic'=>$emplyoe_payroll]);
        }else{
            $veiws='Not Found';
        }
        return json_encode(['viewsalary'=>$veiws,'exist'=>$exist]);
         
        
  }

    /**
     * Lists all EmployeeSalarySelection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSalarySelectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeeSalarySelection model.
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
     * Creates a new EmployeeSalarySelection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmployeeSalarySelection();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmployeeSalarySelection model.
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
     * Deletes an existing EmployeeSalarySelection model.
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
     * Finds the EmployeeSalarySelection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployeeSalarySelection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployeeSalarySelection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

?>