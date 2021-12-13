<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ChangePassword;
use yii\web\UploadedFile;
 

class MeController extends Controller {

    /**
     * {@inheritdoc}
     */
    public $layout = 'me';

    public function behaviors() {
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionView() {
        return $this->render('view', [
                    'model' => $this->findModel(),
        ]);
    }

    public function actionEdit() {
        $model = $this->findModel();
        $model_old = $this->findModel();
        $is_uploaded = true;
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at=date('Y-m-d H:i:s');

            if ($model->Image = UploadedFile::getInstance($model, 'Image')) {
                $file = $model->Image;
                $ext = $model->Image->getExtension();
                $model->Image = $model->getPhotoName() . '.' . $ext;
                $is_uploaded = true;
            } else {
                $model->Image = $model_old->Image;
            }

            if ($model->save()) {
                if ($is_uploaded && isset($file)) {
                    $folder = yii::$app->common->createFolderStructure();
                    if (file_exists($folder . "/" . $model_old->Image) && $model_old->Image != null && $model_old->Image != '') {
                        unlink($folder . "/" . $model_old->Image);
                    }
                    $file->saveAs($folder . "/" . $model->Image);
                }
                $msg = 'Your profile has been changed successfully.';
                Yii::$app->session->setFlash('message', $msg);
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('message', 'Something wrong please try again later.');
                return $this->refresh();
            }
        }

        return $this->render('edit', [
                    'model' => $model,
        ]);
    }

  

    public function actionChangepassword() {


        $model = new ChangePassword();
        $model->password=null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $myModel = $this->findModel();
                $myModel->setPassword($model->password);
                if ($myModel->save(false)) {
                    Yii::$app->session->setFlash('message', 'You password has been changed successfully.');
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('message', 'Something wrong please try again later.');
                    return $this->refresh();
                }
            }
        }
        return $this->render('changepassword', [
                    'model' => $model,
        ]);
    }

    protected function findModel() {
        if (($model = User::findOne(Yii::$app->user->identity->id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
