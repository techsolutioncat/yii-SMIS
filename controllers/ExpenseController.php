<?php

namespace app\controllers;

use Yii;
use app\models\Expense;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ExpenseController implements the CRUD actions for Expense model.
 */
class ExpenseController extends Controller
{
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
     * Lists all Expense models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Expense();
        $query = Expense::find()
            ->select(['expense.*', 'expense_head.head'])
            ->leftJoin('expense_head', 'expense_head.id = expense.expense_head_id');

        
        $data = $query->createCommand()->queryAll();
        return $this->render('index', [
            'model'=> $model,
            'data'=> $data
        ]);
    }

    /**
     * Save Expense Head.
     * @return mixed
     */
    public function actionExpenseHeadSave()
    {
        $data = Yii::$app->request->post();
        if($data['id'] == 0) {
            $save_data = array('head' => $data['head'], 'created_at' => date('Y-m-d H:i:s'));
            Yii::$app->db->createCommand()->insert('expense_head', $save_data)->execute();
            echo true;
            exit;
        }
    }

    /**
     * Save Expense Head.
     * @return mixed
     */
    public function actionGetHead()
    {
        $data = yii::$app->db->createCommand( 'SELECT * FROM expense_head' )->queryAll();
        echo json_encode($data);
    }

    /**
     * Save Expense Head.
     * @return mixed
     */
    public function actionExpenseSave()
    {
        $data = Yii::$app->request->post();
        if($data['id'] == 0) {
            unset($data['id']);
            $data['created_at'] = date('Y-m-d H:i:s');
           
            $query =  Yii::$app->db->createCommand()->insert('expense', $data)->execute();
            $insert_id = Yii::$app->db->getLastInsertID();

            $query = Expense::find()
            ->select(['expense.*', 'expense_head.head'])
            ->leftJoin('expense_head', 'expense_head.id = expense.expense_head_id')
            ->where(['expense.id' => $insert_id]);
            $row = $query->createCommand()->queryOne();

            echo json_encode($row);
            exit;
        }

    }

}
