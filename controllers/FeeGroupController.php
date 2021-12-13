<?php

namespace app\controllers;

use Yii;
use app\models\FeeGroup;
use app\models\RefClass;
use yii\data\ActiveDataProvider;
use app\models\search\FeeGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * FeeGroupController implements the CRUD actions for FeeGroup model.
 */
class FeeGroupController extends Controller {

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
//                    'remove' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all FeeGroup models.
     * @return mixed
     */
    public function actionClasses() {
        // data provider & model classes are different!
        // Thats why the Filters are not working.

        $searchModel = new FeeGroupSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        $query1 = RefClass::find()->where(['fk_branch_id' => yii::$app->common->getBranch(), 'status' => 'active']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query1,
            'sort' => ['defaultOrder' => ['title' => SORT_ASC]],
        ]);


        return $this->render('classes', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeeGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            return [
                'title' => "View Fee Group details ",
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Close', [
                    'class' => 'classFeeGroup btn btn-default pull-left',
                    'data-dismiss' => 'modal',
                    'data-id' => $model->fk_class_id,
                    'data-url' => Url::to(['/fee-group']),
                ]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new FeeGroup model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new FeeGroup();
        $classModel = $this->findClassModel(yii::$app->request->get('id'));
        $isAdded = false;

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {

                return [
                    'title' => "Add New Fee Group to " . $classModel->title,
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', [
                        'class' => 'classFeeGroup btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                        'data-id' => yii::$app->request->get('id'),
                        'data-url' => Url::to(['/fee-group']),
                            ]
                    ) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $model->fk_branch_id = Yii::$app->common->getBranch();
                if ($model->validate()) {  // after validation
                    $groups = $request->post('mgroups'); // get group data
                    if (!empty($groups)) {
                        foreach ($groups as $dt) {
                            $modelNew = new FeeGroup();
                            $modelNew->fk_group_id = $dt;
                            $modelNew->fk_class_id = yii::$app->request->get('id');
                            $modelNew->fk_branch_id = $model->fk_branch_id;
                            $modelNew->fk_fee_head_id = $model->fk_fee_head_id;
                            $modelNew->amount = $model->amount;
                            $modelNew->is_active = 'yes';
                            $modelNew->save(false);
                        }
                        $isAdded = true;
                    } else {
                        if ($model->save()) {
                            $isAdded = true;
                        }
                    }
                }


                if ($isAdded) {
                    return [
//                        'forceReload'=>'#crud-datatable-pjax',
                        'title' => "Add New Fee Group to " . $classModel->title,
                        'content' => '
                            <div class="alert alert-success" role="alert">
                            <strong><i class="fa fa-check-circle"></i> Congratulation</strong>  fee group has been added successfully!.
                           </div>',
                        'footer' => Html::button('Close', [
                            'class' => 'classFeeGroup btn btn-default pull-left',
                            'data-dismiss' => 'modal',
                            'data-id' => yii::$app->request->get('id'),
                            'data-url' => Url::to(['/fee-group']),
                                ]
                        ) .
                        // Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                        Html::a('Add another Fee Group', ['create', 'id' => (yii::$app->request->get('id')) ? yii::$app->request->get('id') : ""], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                } else {
                    return [
                        'title' => "Add New Fee Group to " . $classModel->title,
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('Close', [
                            'class' => 'classFeeGroup btn btn-default pull-left',
                            'data-dismiss' => 'modal',
                            'data-id' => yii::$app->request->get('id'),
                            'data-url' => Url::to(['/fee-group']),
                                ]
                        ) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                    ];
                }
            } else {
                return [
                    'title' => "Create new FeeGroup to " . $classModel->title,
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', [
                        'class' => 'classFeeGroup btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                        'data-id' => yii::$app->request->get('id'),
                        'data-url' => Url::to(['/fee-group']),
                            ]
                    ) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post())) {
                $model->fk_branch_id = Yii::$app->common->getBranch();
                $model->save();
                // $model->refresh();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing FeeGroup model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $classModel = $this->findClassModel($model->fk_class_id);
        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update: " . $classModel->title,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', [
                        'class' => 'classFeeGroup btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                        'data-id' => $model->fk_class_id,
                        'data-url' => Url::to(['/fee-group']),
                    ]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
//                    'forceReload'=>'alert("hi");',
//                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Update: " . $classModel->title,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', [
                        'class' => 'classFeeGroup btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                        'data-id' => $model->fk_class_id,
                        'data-url' => Url::to(['/fee-group']),
                    ]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update: " . $classModel->title,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', [
                        'class' => 'classFeeGroup btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                        'data-id' => $model->fk_class_id,
                        'data-url' => Url::to(['/fee-group']),
                    ]) .
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
     * Delete an existing FeeGroup model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new FeeGroupSearch();
        $id = Yii::$app->request->post('classid');
        if ($id) {
            $searchModel->fk_class_id = $id;
        }
        $searchModel->fk_branch_id = Yii::$app->common->getBranch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $view = $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
            'classModel' => $this->findClassModel($id),
        ]);

        return json_encode(['details' => $view]);
    }

    public function actionRemove($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $id = $model->fk_class_id;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update Fee Group",
                    'content' => 'delete',
                    'footer' => Html::button('Close', [
                        'class' => 'btn btn-default pull-left',
                        'data-dismiss' => 'modal',
                    ]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else {
                
            }
        }
    }

    public function actionDelete($id) {
        $isDependent = false;
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $id = $model->fk_class_id;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $searchModel = new FeeGroupSearch();
            $searchModel->fk_branch_id = Yii::$app->common->getBranch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            if ($isDependent) {
                return [
                    'title' => " Warning ",
                    'content' => '
                            <div class="alert alert-warning" role="alert">
                            <strong><i class="fa fa-info"></i></strong>  The fee group is linked with following..
                           </div>',
                    'footer' => Html::button('Close', [
                        'class' => 'classFeeGroup btn btn-success pull-right',
                        'data-dismiss' => 'modal',
                        'data-id' => $id,
                        'data-url' => Url::to(['/fee-group']),
                    ])
                ];
            } else {
                if ($model->delete()) {
                    return [
                        'title' => " Congratulations ",
                        'content' => '<span class=" text-success "> <i class="fa fa-check-circle"></i> Fee group has been deleted successfully!.</span>',
                        'footer' => Html::button('Close', [
                            'class' => 'classFeeGroup btn btn-success pull-right',
                            'data-dismiss' => 'modal',
                            'data-id' => $id,
                            'data-url' => Url::to(['/fee-group']),
                        ])
                    ];
                }
            }

//               
        } else {

            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing FeeGroup model.
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
//            return ['forceClose'=>true];
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the FeeGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeeGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = FeeGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findClassModel($id) {
        if (($model = RefClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
