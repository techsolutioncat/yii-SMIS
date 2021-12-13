<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

if (!empty(Yii::$app->common->getBranchDetail()->logo)) {
    $logo = '/uploads/school-logo/' . Yii::$app->common->getBranchDetail()->logo;
} else {
    $logo = '/img/logo.png';
}
if (!Yii::$app->user->isGuest) {
    ?>
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="header-top pad">
                    <div class="logo">
                        <?php echo Html::a(Html::img('@web' . $logo), ['/site/index'], ['alt' => Yii::$app->common->getBranchDetail()->name . ' -logo']); ?>
                    </div>
                    <div class="search">
                        <div class="form-group">
                            <input type="text"
                                   placeholder="Search <?= ucfirst(Yii::$app->common->getBranchDetail()->name) ?>">
                            <img src="<?= Url::to('@web/img/search.svg') ?>"
                                 alt="<?= Yii::$app->common->getBranchDetail()->name . '-search' ?>">
                        </div>
                    </div>
                    <div class="head-right">
                        <ul class="notific">
                            <li>
                                <?php
                                ?>
                                <a href="#"><img src="<?= Url::to('@web/img/message.svg') ?>" alt="Messages"><span
                                        class="not-count">02</span></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= Url::to('@web/img/notification.svg') ?>" alt="Messages"><span
                                        class="not-count">02</span></a>
                            </li>
                            <li class="p-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="true">
                                    <span class="avator-img">
                                        <img class="img-responsive profile profile-image"
                                         src="<?php echo Yii::$app->common->getLoginUserProfilePicture(); ?>" alt="Profile picture">
                                    </span>
                                    <p>Hello!</p>
                                    <p>
                                        <b>
                                            <?php
                                             echo ucfirst(Yii::$app->user->identity->first_name);
//                                            echo ucfirst(Yii::$app->user->identity->first_name). ' '.ucfirst(Yii::$app->user->identity->middle_name).' '.ucfirst(Yii::$app->user->identity->last_name);;
                                            ?>

                                        </b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">

                                    <li> <?php echo Html::a('<i class="fa fa-picture-o"></i> View Profile', ['/me/view']); ?> </li>
                                    <li> <?php echo Html::a('<i class="fa fa-edit"></i> Edit Profile', ['/me/edit']); ?> </li>
                                    <li> <?php echo Html::a('<i class="fa fa-asterisk"></i> Change Password', ['/me/changepassword']); ?> </li>
                                    <li> <?php echo Html::a('<i class="fa fa-refresh"></i> Logout', ['/site/logout']); ?> </li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="header-in pad">
                    <nav class="navbar">
                        <div class="container-fluid">
                            <!--<div class="overlay-menu" style="display:none;"></div>-->
                            <?php
                            NavBar::begin([
                                //'brandLabel' => 'MIS',
                                //'brandUrl' => Yii::$app->homeUrl,
                                'options' => [
                                    'class' => 'main-navigation navbar',
                                    'id' => 'navigation',
                                ],
                            ]);
                            if (!Yii::$app->user->isGuest) {
                                /* logged in user will see the follwoing links */

                                /* if branch manager logged in the follwoing nav will be execute */
                                if (Yii::$app->user->identity->fk_role_id == 2) {
                                    echo Nav::widget([
                                        'options' => ['class' => 'navbar-nav nav_inn'],
                                        'encodeLabels' => false,
                                        'items' => [
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_3.svg') . '" /> Branches',
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp1.svg') . '" /></span>' . Yii::t('app', 'Branch Details'), 'url' => ['/branch']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp2.svg') . '" /></span>' . Yii::t('app', 'Create Branch'), 'url' => ['/branch/create']],
                                                ],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_3.svg') . '" /> Branch Reports',
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu1.svg') . '" /></span> ' . Yii::t('app', 'Statistics'), 'url' => ['/branch-reports/statistic']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu2.svg') . '" /></span> ' . Yii::t('app', 'Finances'), 'url' => ['/branch-reports/finances']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu3.svg') . '" /></span> ' . Yii::t('app', 'Academics'), 'url' => ['/branch-reports/academics']],
                                                ],
                                            ],
                                            Yii::$app->user->isGuest ? (
                                                    ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'Login'), 'url' => ['/site/login']]
                                                    ) : (
                                                    '<li class="mega-items signout-opt">'
                                                    . Html::beginForm(['/site/logout'], 'post')
                                                    . Html::submitButton(
                                                            '<img src="' . Url::to('@web/img/db-out.svg') . '" /> Signout', ['class' => 'mega-items signout-opt']
                                                    )
                                                    . Html::endForm()
                                                    . '</li>'
                                                    ),
                                        ],
                                    ]);
                                } elseif (Yii::$app->user->identity->fk_role_id == 3) {
                                    echo Nav::widget([
                                        'options' => ['class' => 'navbar-nav nav_inn'],
                                        'encodeLabels' => false,
                                        'items' => [
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_3.svg') . '" /> ' . Yii::t('app', 'Profile'), 'url' => ['/student/profile', 'id' => $studentInfo->stu_id]
                                            ],
                                            Yii::$app->user->isGuest ? (
                                                    ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'Login'), 'url' => ['/site/login']]
                                                    ) : (
                                                    '<li class="mega-items signout-opt">'
                                                    . Html::beginForm(['/site/logout'], 'post')
                                                    . Html::submitButton(
                                                            '<img src="' . Url::to('@web/img/db-out.svg') . '" /> ' . Yii::t('app', 'Signout'), ['class' => 'mega-items signout-opt']
                                                    )
                                                    . Html::endForm()
                                                    . '</li>'
                                                    ),
                                        ],
                                    ]);
                                } else {
                                    echo Nav::widget([
                                        'options' => ['class' => 'navbar-nav nav_inn'],
                                        'encodeLabels' => false,
                                        'items' => [
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_1.svg') . '" /> ' . Yii::t('app', 'Dashboard'), 'url' => ['/'],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_3.svg') . '" /> ' . Yii::t('app', 'Employees'),
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp1.svg') . '" /></span> ' . Yii::t('app', 'Employee Details'), 'url' => ['/employee']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp2.svg') . '" /></span> ' . Yii::t('app', 'Employee Attendance'), 'url' => ['/employee/calendar']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp3.svg') . '" /></span> ' . Yii::t('app', 'Add Employee'), 'url' => ['/employee/create']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp4.svg') . '" /></span> ' . Yii::t('app', 'Employee Attendance Report'), 'url' => ['/employee/empl-attnd-report']],
                                                ],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_2.svg') . '" /> ' . Yii::t('app', 'Students'),
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st1.svg') . '" /></span> ' . Yii::t('app', 'Section Analysis'), 'url' => ['/analysis']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st2.svg') . '" /></span> ' . Yii::t('app', 'Search Student'), 'url' => ['/student']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st3.svg') . '" /></span> ' . Yii::t('app', 'Student Attendance'), 'url' => ['/student/calendar']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st4.svg') . '" /></span> ' . Yii::t('app', 'Admission Wizard'), 'url' => ['/student/admission']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/check.svg') . '" /></span> ' . Yii::t('app', 'Activate Student'), 'url' => ['/student/inactive-student']],
                                                    //['label' => '<span><img src="'.Url::to('@web/img/st5.svg').'" /></span> Admission Form','url' => ['/student/create']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st5.svg') . '" /></span> ' . Yii::t('app', 'Promote Students'), 'url' => ['/student/promote-students']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st5.svg') . '" /></span> ' . Yii::t('app', 'Shuffle Students'), 'url' => ['/student/shuffle-students']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st2.svg') . '" /></span> ' . Yii::t('app', 'Sundry Account'), 'url' => ['/sundry-account']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st3.svg') . '" /></span> ' . Yii::t('app', 'Student Account'), 'url' => ['/update-account']],
                                                /* ['label' => '<span><img src="'.Url::to('@web/img/st6.svg').'" /></span> Student Profile','url' => ['/student/profile']], */
                                                ],
                                            ],
                                            ['label' => '<img src="' . Url::to('@web/img/db_4.svg') . '" /> ' . Yii::t('app', 'Subjects'), 'url' => ['/subjects']],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_5.svg') . '" /> ' . Yii::t('app', 'Exams'),
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu1.svg') . '" /></span> ' . Yii::t('app', 'Create Exam'), 'url' => ['/exams/create-exam']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu2.svg') . '" /></span> ' . Yii::t('app', 'View Exams'), 'url' => ['/exams/exam-details']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu3.svg') . '" /></span> ' . Yii::t('app', 'Award List'), 'url' => ['/exams/award-list']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu4.svg') . '" /></span> ' . Yii::t('app', 'DMC'), 'url' => ['/exams/dmc']],
                                                /* ['label' => '<span><img src="'.Url::to('@web/img/stu4.svg').'" /></span> Result','url' => ['/employee/chart']], */
                                                ],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_5.svg') . '" /> ' . Yii::t('app', 'Reports'),
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu1.svg') . '" /></span> ' . Yii::t('app', 'Statistics'), 'url' => ['/reports/statistics']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu2.svg') . '" /></span> ' . Yii::t('app', 'Finances'), 'url' => ['/reports/finances']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/stu3.svg') . '" /></span> ' . Yii::t('app', 'Academics'), 'url' => ['/reports/academics']],
                                                ],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_6.svg') . '" /> ' . Yii::t('app', 'Finance'),
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st1.svg') . '" /></span> ' . Yii::t('app', 'Fee submission'), 'url' => ['/fee']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st2.svg') . '" /></span> ' . Yii::t('app', 'Fee Generator'), 'url' => ['fee/generate-fee-challan']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st3.svg') . '" /></span> ' . Yii::t('app', 'Fee Structure'), 'url' => ['fee/structure']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st4.svg') . '" /></span> ' . Yii::t('app', 'Fee Plan'), 'url' => ['/fee-payment-mode']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st5.svg') . '" /></span> ' . Yii::t('app', 'Fee Heads'), 'url' => ['/fee-heads']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st6.svg') . '" /></span> ' . Yii::t('app', 'Assign Fee'), 'url' => ['/fee-group/classes']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/st7.svg') . '" /></span> ' . Yii::t('app', 'Student Plans'), 'url' => ['/fee-plan']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett7.svg') . '" /></span> ' . Yii::t('app', 'Discount Type'), 'url' => ['/discount-type']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett7.svg') . '" /></span> ' . Yii::t('app', 'Salary Settings'), 'url' => ['/salary-main/salary-settings']],
                                                // ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Fine Type','url' => ['/fine-type']],
                                                // ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Student Fine','url' => ['/student-fine']],
                                                // ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Discount Type','url' => ['/discount-type']],
                                                // ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Fee Discounts','url' => ['/fee-discounts']],
                                                ],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_7.svg') . '" /> ' . Yii::t('app', 'Transport'),
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/trn1.svg') . '" /></span> ' . Yii::t('app', 'Manage Vehicle'), 'url' => ['/vehicle-info']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/trn2.svg') . '" /></span> ' . Yii::t('app', 'Manage Zone'), 'url' => ['/zone']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/trn3.svg') . '" /></span> ' . Yii::t('app', 'Manage Route'), 'url' => ['/transport-main']],
                                                ],
                                            ],
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_8.svg') . '" /> ' . Yii::t('app', 'Hostel'),
                                                'items' => [

                                                    ['label' => '<span><img src="' . Url::to('@web/img/host1.svg') . '" /></span> ' . Yii::t('app', 'Manage Hostels'), 'url' => ['/hostel']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/host2.svg') . '" /></span> ' . Yii::t('app', 'Assign Hostel'), 'url' => ['/hostel-detail ']],
                                                ],
                                            ],
                                            Yii::$app->user->isGuest ? (
                                                    ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'Login'), 'url' => ['/site/login']]
                                                    ) : (
                                                    '<li class="mega-items signout-opt">'
                                                    . Html::beginForm(['/site/logout'], 'post')
                                                    . Html::submitButton(
                                                            '<img src="' . Url::to('@web/img/db-out.svg') . '" /> ' . Yii::t('app', 'Signout'), ['class' => 'mega-items signout-opt']
                                                    )
                                                    . Html::endForm()
                                                    . '</li>'
                                                    ),
                                            [
                                                'label' => '<img src="' . Url::to('@web/img/db_9.svg') . '" /> ' . Yii::t('app', 'Settings'),
                                                'options' => ['class' => 'mega-items setting-opt'],
                                                'items' => [
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett1.svg') . '" /></span> ' . Yii::t('app', 'Main Settings'), 'url' => ['/settings']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett2.svg') . '" /></span> ' . Yii::t('app', 'Manage Sessions'), 'url' => ['/session']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett3.svg') . '" /></span> ' . Yii::t('app', 'Manage Classes'), 'url' => ['/class']],
                                                    // ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Manage Groups','url' => ['/group']],
                                                    // ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Manage Sections','url' => ['/section']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett4.svg') . '" /></span> ' . Yii::t('app', 'Manage Departments'), 'url' => ['/department']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett5.svg') . '" /></span> ' . Yii::t('app', 'Manage Designations'), 'url' => ['/designation']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett6.svg') . '" /></span> ' . Yii::t('app', 'Manage Visitor Log'), 'url' => ['/visitor-info']],
                                                    //   ['label' => '<span><img src="'.Url::to('@web/img/attandance.svg').'" /></span> Mode Of Advertisement','url' => ['/visitor-advertisement']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/sett7.svg') . '" /></span> ' . Yii::t('app', 'Working days Employee'), 'url' => ['/working-days/create']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/attandance.svg') . '" /></span> ' . Yii::t('app', 'Working days Student'), 'url' => ['/working-days/stu-settings']],
                                                    ['label' => '<span><img src="' . Url::to('@web/img/emp1.svg') . '" /></span> ' . Yii::t('app', 'Manage Profession'), 'url' => ['/profession']],
                                                ],
                                            ],
                                        /* Yii::$app->user->isGuest ? (
                                          ['label' => '<img src="'.Url::to('@web/img/book-icon.png').'" /> Login', 'url' => ['/site/login']]
                                          ) : (
                                          '<li>'
                                          . Html::beginForm(['/site/logout'], 'post')
                                          . Html::submitButton(
                                          'Logout (' . Yii::$app->user->identity->username . ')',
                                          ['class' => 'btn btn-link logout']
                                          )
                                          . Html::endForm()
                                          . '</li>'
                                          ) */
                                        ],
                                    ]);
                                }
                            } else {
                                /* guest user will see the follwoing links */
                                echo Nav::widget([
                                    'options' => ['class' => 'navbar-nav nav_inn'],
                                    'encodeLabels' => false,
                                    'items' => [
                                        ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'Home'), 'url' => ['/site/index']],
                                        ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'About'), 'url' => ['/site/about']],
                                        ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                                        ['label' => '<img src="' . Url::to('@web/img/book-icon.png') . '" /> ' . Yii::t('app', 'Login'), 'url' => ['/site/login']]
                                    ],
                                ]);
                            }
                            NavBar::end();
                            ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php
}
?>