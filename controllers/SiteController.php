<?php

namespace app\controllers;

use app\models\Dashboard;
use app\models\RefClass;
use app\models\RefGroup;
use app\models\RefSection;
use app\models\RefSectionSearch;
use app\models\search\SubjectsSearch;
use app\models\Subjects;
use app\models\Exam;
use app\models\FeeDiscountTypes;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use arogachev\excel\import\basic\Importer; // for excel
use yii\web\UploadedFile;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'get-group'], // add all actions to take guest to login page
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    public function actionSms() {
        return $this->render('sms');
    }

    public function actionSend() {
        //print_r($_POST);
        $mblNo = $_POST['number'];
        $from = $_POST['from'];
        $msg = $_POST['msg'];

        //return 'http://221.132.117.58:7700/sendsms_url.html?Username=03028501396&Password=123.123&From=MesaqDir&To='.$mblNo.'&Message="'.$msg;
        //$params=['Username'=>'03028501396', 'Password'=>'123.123', 'From'=>'MesaqDir','Message'=>$msg,'To'=>$mblNo];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://221.132.117.58:7700/sendsms_url.html");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'Username=03028501396&Password=123.123&From=MesaqDir&To=' . $mblNo . '&Message=' . $msg);

        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        // further processing ....

        if ($server_output == 'Message Sent Successfully!') {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            $studentInfo = \app\models\StudentInfo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            if (Yii::$app->user->identity->fk_role_id == 3) {
                return $this->redirect(['student/profile', 'id' => $studentInfo->stu_id]);
            } else {
                $dashboard = Dashboard::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()/* ,'status'=>1 */])->all();

                /* student daily attendance */
                $attendance_std_query = \app\models\StudentAttendance::find()
                        ->select(['count(*) as total', 'student_attendance.leave_type'])
                        ->innerJoin('student_info si', 'si.stu_id=student_attendance.fk_stu_id')
                        ->where(['si.fk_branch_id' => Yii::$app->common->getBranch(), 'date(student_attendance.date)' => date('Y-m-d'), 'si.is_active' => 1])
                        ->groupBy('student_attendance.leave_type')
                        ->asArray()
                        ->all();
                /* student attedance array */
                $attenance_std_data = [];
                foreach ($attendance_std_query as $key => $attendance_details) {
                    $attenance_std_data['leave_type'][] = $attendance_details['leave_type'];
                    $attenance_std_data['total'][] = $attendance_details['total'];
                }
                /* employee daily attendance */
                $attendance_emp_query = \app\models\EmployeeAttendance::find()
                        ->select(['count(*) as total', 'employee_attendance.leave_type'])
                        ->innerJoin('employee_info ei', 'ei.emp_id=employee_attendance.fk_empl_id')
                        ->where([
                            'ei.fk_branch_id' => Yii::$app->common->getBranch(),
                            'date(employee_attendance.date)' => date('Y-m-d'),
                            'ei.is_active' => 1
                        ])
                        ->groupBy('employee_attendance.leave_type')
                        ->asArray()
                        ->all();
                /* employee attedance array */
                $attenance_emp_data = [];
                foreach ($attendance_emp_query as $key => $attendance_emp_details) {
                    $attenance_emp_data['leave_type'][] = $attendance_emp_details['leave_type'];
                    $attenance_emp_data['total'][] = $attendance_emp_details['total'];
                }
                return $this->render('dashboard', [
                            'attendance_data' => $attenance_std_data,
                            'attendance_emp_data' => $attenance_emp_data,
                            'dashboard' => $dashboard,
                ]);
            }
        } else {
            return $this->render('index');
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->getUser();
//            $user->last_login=strtotime("now");
            $user->last_login=date('Y-m-d H:i:s');
            $user->update(false);
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /*
     * group sections
     * parameters $cid, $gid
     */

    public function actionGroupSection($cid, $gid = null) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            $searchModel1 = new RefSectionSearch();
            $searchModel2 = new SubjectsSearch();

            /* show all the pharmacist added by nurse logged in. */
            $querySections = RefSection::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'class_id' => $cid, 'fk_group_id' => $gid]);

            $querySubjects = Subjects::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'fk_class_id' => $cid, 'fk_group_id' => $gid]);

            $dataProviderSection = new ActiveDataProvider([
                'query' => $querySections,
            ]);
            $dataProviderSubject = new ActiveDataProvider([
                'query' => $querySubjects,
            ]);

            return $this->render('group-section', [
                        'searchModel1' => $searchModel1,
                        'dataprovider1' => $dataProviderSection,
                        'searchModel2' => $searchModel2,
                        'dataprovider2' => $dataProviderSubject,
            ]);
        }
    }

    /* get groups */

    /**
     * @return Action
     */
    public function actionGetGroup() {
        // THE CONTROLLER

        $class_id = Yii::$app->request->post('depdrop_parents')[0];


        if ($class_id) {
            if ($class_id != null) {
                $out = Yii::$app->common->getGroup($class_id);
                return Json::encode(['output' => $out, 'selected' => '']);
//                return null;
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }

    /* get Sections */

    /**
     * @return Action
     */
    public function actionGetSection() {
        $group_id = Yii::$app->request->post('depdrop_all_params')['group-id'];
        $class_id = Yii::$app->request->post('depdrop_all_params')['class-id'];
        if (!empty($class_id) && $group_id == 'Loading ...') {
            $count_group = RefGroup::find()->where(['fk_class_id' => $class_id, 'fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active'])->count();
            if ($count_group == 0) {
                $out = Yii::$app->common->getSection($class_id, Null);
                return Json::encode(['output' => $out, 'selected' => '']);
            } else {
                return false;
            }
        } elseif (!empty($class_id) && !empty($group_id)) {
            $out = Yii::$app->common->getSection($class_id, $group_id);
            return Json::encode(['output' => $out, 'selected' => '']);
        } else {
            $count_group = RefGroup::find()->where(['fk_class_id' => $class_id, 'fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active'])->count();
            if ($count_group == 0) {
                $out = Yii::$app->common->getSection($class_id, Null);
                return Json::encode(['output' => $out, 'selected' => '']);
            } else {
                return false;
            }
        }
    }

    /* get exam list */
    /* get exams list */

    public function actionGetExamsList() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post('depdrop_all_params');
                $class = $data['class-id'];
                $group = (isset($data['group-id'])) ? $data['group-id'] : null;
                $section = $data['exam-section-id'];

                /* listing options. */
                $filtered_exams = Exam::find()
                        ->select(['exam.fk_exam_type id', 'et.type name'])
                        ->innerJoin('exam_type et', 'et.id = exam.fk_exam_type')
                        ->where([
                            'exam.fk_branch_id' => Yii::$app->common->getBranch(),
                            'exam.fk_class_id' => $class,
                            'exam.fk_group_id' => (empty($group)) ? null : $group,
                            'exam.fk_section_id' => $section
                        ])
                        ->asArray()
                        ->all();
                return Json::encode(['output' => $filtered_exams, 'selected' => '']);
            }
        }
    }

    public function actionImport() {

        $model = new \app\models\ImportForm();
        $msgs = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->file = UploadedFile::getInstance($model, 'file')) {
               
                if ($this->importNow($model->file->tempName)) {
                    Yii::$app->session->setFlash('msg');
                    return $this->refresh();
                }
            }
        }
        return $this->render('import', [
                    'model' => $model,
        ]);
    }

    public function importNow($file) {
        // Yii::getAlias('@webroot')
//        $file=Yii::$app->request->baseUrl.'/uploads/test/ExcelFormat.xlsx';
//        echo $file; exit;
        $fields = [
            [
                'className' => \app\models\AttendanceMode::className(),
//                'labels'=>['Reg#'],
               'useAttributeLabels' => false,
                'standardAttributesConfig' => [
                    [
                        'name' => 'mode',
                        'valueReplacement' => function ($value) {
                            return $value;
                        },
//                        'valueReplacement' => function ($value) {
//                        return $value ? Html::tag('p', $value) : '';
//                    },
//                    'valueReplacement' => Test::getTypesList(),
                    ],
//                    [
//                        'name' => 'description',
////                    'valueReplacement' => function ($value) {
////                        return $value ? Html::tag('p', $value) : '';
////                    },
//                    ],
//                    [
//                        'name' => 'fk_branch_id',
//                        'valueReplacement' => function ($value) {
//                            return Yii::$app->common->getBranch();
//                        },
//                    ],
                ],
            ],
        ];
        $importer = new Importer([
//             'filePath' => basename(dirname(__FILE__)) . '/ExcelFormat.xlsx',
            'filePath' => $file,
//            'sheetNames' => ['mode'],
            'standardModelsConfig' => $fields,
            
        ]);
        
         
        if (!$importer->run()) {
            echo $importer->error;

            if ($importer->wrongModel) {
                echo Html::errorSummary($importer->wrongModel);
            }
        }
    }

}
