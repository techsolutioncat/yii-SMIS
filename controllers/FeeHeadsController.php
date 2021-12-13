<?php

namespace app\controllers;

use Yii;
use app\models\FeeHeads;
use app\models\search\FeeHeads as FeeHeadsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * FeeHeadsController implements the CRUD actions for FeeHeads model.
 */
class FeeHeadsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all FeeHeads models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new FeeHeadsSearch();
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeeHeads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            return [
                'title' => "View: " . $model->title,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new FeeHeads model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new FeeHeads();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new Fee Head",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new Fee Head",
                    'content' => '
                            <div class="alert alert-success" role="alert">
                            <strong><i class="fa fa-check-circle"></i> Congratulation</strong>  fee head has been added successfully!.
                           </div>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Add another Fee Head', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new Fee Head",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
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
     * Updates an existing FeeHeads model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update: " . $model->title,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Update: " . $model->title,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update: " . $model->title,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
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
     * Delete an existing FeeHeads model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $isDependent = false;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
             if ($isDependent) {
                return [
                    'title' => " Warning ",
                    'content' => '
                            <div class="alert alert-warning" role="alert">
                            <strong><i class="fa fa-info"></i></strong>  The fee group is linked with following..
                           </div>',
                    'footer' => Html::button('Close', [
                        'forceClose' => true, 'forceReload' => '#crud-datatable-pjax',
                        'class' => 'classFeeGroup btn btn-success pull-right',
                        'data-dismiss' => 'modal',
                    ])
                ];
            } else {
             $model->delete();
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];   
            }
            
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing FeeHeads model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete() {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the FeeHeads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeeHeads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = FeeHeads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /* set discount status */

    public function actionSetDiscountStatus() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /* discount_head_status */
            if ($data['head_id']) {
                $feeHeadModel = FeeHeads::findOne($data['head_id']);
                $feeHeadModel->discount_head_status = $data['status'];
                $feeHeadModel->save();
                if ($data['status'] == 1) {
                    return json_encode(['status' => 1, 'message' => "<strong>" . ucfirst($feeHeadModel->title) . 'Head discount has been Activated</strong>']);
                } else {
                    return json_encode(['status' => 1, 'message' => "<strong>" . ucfirst($feeHeadModel->title) . 'Head discount has been Deactivated</strong>']);
                }
            }
        }
    }

    /* set one time head only status */

    public function actionSetOnetimeHead() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /* discount_head_status */
            if ($data['head_id']) {
                $feeHeadModel = FeeHeads::findOne($data['head_id']);
                $feeHeadModel->one_time_only = $data['status'];
                $feeHeadModel->save();
                if ($data['status'] == 1) {
                    return json_encode(['status' => 1, 'message' => "<strong>" . ucfirst($feeHeadModel->title) . 'Head will add on Admission Only</strong>']);
                } else {
                    return json_encode(['status' => 1, 'message' => "<strong>" . ucfirst($feeHeadModel->title) . 'Head will appear on creation of admission  and partial challan </strong>']);
                }
            }
        }
    }

    /* set one time head only status */

    public function actionSetPromotionHead() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /* discount_head_status */
            if ($data['head_id']) {
                $feeHeadModel = FeeHeads::findOne($data['head_id']);
                $feeHeadModel->promotion_head = $data['status'];
                $feeHeadModel->save();
                if ($data['status'] == 1) {
                    return json_encode(['status' => 1, 'message' => "<strong>" . ucfirst($feeHeadModel->title) . 'Head will add on Admission Only</strong>']);
                } else {
                    return json_encode(['status' => 1, 'message' => "<strong>" . ucfirst($feeHeadModel->title) . 'Head will appear on creation of admission  and partial challan </strong>']);
                }
            }
        }
    }

}

// end of class
