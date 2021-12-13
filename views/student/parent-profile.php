<?php


use yii\helpers\Url;
use app\models\SmsLog;
use app\widgets\Alert;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Parent Profile';
?>

<div class="student-profile-index content_col">
  <h1 class="p_title"></h1>
  <div class="student-profile mid_center">
    <div class="profile_shade">
      <div class="pp_section row">
        <div class="col-sm-2 nopad">
          <div class="student-avator shade">
            <div class="avt_std"> <img class="img-responsive" src="<?= Url::to('@web') ?>/img/male.jpg" alt="HASEEN KHWAJA  "> </div>
            <div class="st_caption">
              <h3>HASEEN KHWAJA </h3>
              <p>S/O KHWAJA MAHMOOD </p>
            </div>
          </div>
        </div>
        <div class="col-sm-10 nopad">
          <div class="col-sm-6">
            <div class="widget">
              <p>Attendance</p>
              <img src="<?= Url::to('@web') ?>/img/g2.png" alt="MIS"> </div>
          </div>
          <div class="col-sm-6 nopad">
            <div class="widget">
              <p>Attendance</p>
              <img src="<?= Url::to('@web') ?>/img/g3.png" alt="MIS"> </div>
          </div>
        </div>
      </div>
      <div class="pp_section row">
        <div class="col-sm-2 nopad">
          <div class="student-avator shade">
            <div class="avt_std"> <img class="img-responsive" src="<?= Url::to('@web') ?>/img/male.jpg" alt="HASEEN KHWAJA  "> </div>
            <div class="st_caption">
              <h3>HASEEN KHWAJA </h3>
              <p>S/O KHWAJA MAHMOOD </p>
            </div>
          </div>
        </div>
        <div class="col-sm-10 nopad">
          <div class="st_widget shade st_results">
            <div class="tab-content">
              <ul class="nav nav-tabs exams-list">
                <li class="res_title">Results</li>
                <li class="active"> <a href="#Monthly" data-examdivid="Monthly">Monthly</a> </li>
                <li> <a href="#Mid-Term" data-examdivid="Mid-Term">Mid Term</a> </li>
                <li> <a href="#Final-Term" data-examdivid="Final-Term">Final Term</a> </li>
              </ul>
              <div id="Monthly" class="tab-pane fade">
                    <div class="col-sm-9">
                        <div class="info_st">
                            <ul>
                                <li class="col-sm-4"><span>Biology</span>85</li>
                                <li class="col-sm-4"><span>Mathematics</span>60</li>
                                <li class="col-sm-4"><span>Marks Obtained</span>
                                    <p class="obtain_m">670</p></li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>Chemistry</span>76</li>
                                <li class="col-sm-4"><span>Islamiyat</span>65</li>
                                <li class="col-sm-4"><span>Total Marks</span>850</li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>Physics</span>31</li>
                                <li class="col-sm-4"><span>Pak-Studies</span>57</li>
                                <li class="col-sm-4"><span>Grade</span>B</li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>English</span>72</li>
                                <li class="col-sm-4"><span>Urdu</span>58</li>
                            </ul>
    
                        </div>
                    </div>
                    <div class="col-sm-3 res_chart">
                        <img src="<?= Url::to('@web/img/result-chat.svg') ?>" alt="MIS">
                    </div>
                </div>
              <div id="Mid-Term" class="tab-pane fade in active">
                    <div class="col-sm-9">
                        <div class="info_st">
                            <ul>
                                <li class="col-sm-4"><span>Biology</span>70</li>
                                <li class="col-sm-4"><span>Mathematics</span>85</li>
                                <li class="col-sm-4"><span>Marks Obtained</span>
                                    <p class="obtain_m">570</p></li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>Chemistry</span>75</li>
                                <li class="col-sm-4"><span>Islamiyat</span>62</li>
                                <li class="col-sm-4"><span>Total Marks</span>800</li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>Physics</span>81</li>
                                <li class="col-sm-4"><span>Pak-Studies</span>67</li>
                                <li class="col-sm-4"><span>Grade</span>A</li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>English</span>72</li>
                                <li class="col-sm-4"><span>Urdu</span>58</li>
                            </ul>
    
                        </div>
                    </div>
                    <div class="col-sm-3 res_chart">
                        <img src="<?= Url::to('@web/img/result-chat.svg') ?>" alt="MIS">
                    </div>
                </div>
              <div id="Final-Term" class="tab-pane fade">
                    <div class="col-sm-9">
                        <div class="info_st">
                            <ul>
                                <li class="col-sm-4"><span>Biology</span>90</li>
                                <li class="col-sm-4"><span>Mathematics</span>88</li>
                                <li class="col-sm-4"><span>Marks Obtained</span>
                                    <p class="obtain_m">1000</p></li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>Chemistry</span>95</li>
                                <li class="col-sm-4"><span>Islamiyat</span>92</li>
                                <li class="col-sm-4"><span>Total Marks</span>800</li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>Physics</span>89</li>
                                <li class="col-sm-4"><span>Pak-Studies</span>68</li>
                                <li class="col-sm-4"><span>Grade</span>A +</li>
                            </ul>
                            <ul>
                                <li class="col-sm-4"><span>English</span>72</li>
                                <li class="col-sm-4"><span>Urdu</span>58</li>
                            </ul>
    
                        </div>
                    </div>
                    <div class="col-sm-3 res_chart">
                        <img src="<?= Url::to('@web/img/result-chat.svg') ?>" alt="MIS">
                    </div>
                </div> 
            </div>
          </div>
        </div>
      </div>
      <div class="pp_section row">
        <div class="col-sm-2 nopad"> 
        </div>
        <div class="col-sm-10 nopad">
          <div class="st_widget shade st_results">
            <div class="tab-content">
              <ul class="nav nav-tabs exams-list">
                <li class="res_title">Performance</li>
                <li class="active"> <a href="#Current" data-examdivid="Current">Current</a> </li>
                <li> <a href="#practices" data-examdivid="practices">Practices</a> </li> 
              </ul>
              <div id="Current" class="tab-pane fade">
                    <div class="col-sm-12">
                        <img src="<?= Url::to('@web/img/multiple_sons.png') ?>" alt="MIS">
                    </div>
                </div>
              <div id="practices" class="tab-pane fade in active">
                    <div class="col-sm-12">
                        <img src="<?= Url::to('@web/img/multiple_sons.png') ?>" alt="MIS">
                    </div>
                </div>  
            </div>
          </div>
        </div>
      </div>
      <div class="pp_section row">
        <div class="col-sm-2 nopad"> 
        </div>
        <div class="col-sm-10 nopad">
          <div class="st_widget shade result_calender"> <img src="<?= Url::to('@web/img/calender-1.svg') ?>" alt="MIS"> </div>
        </div>
      </div>
      <div class="pp_section row"> 
            <div class="col-sm-2 nopad"> 
            </div>
            <div class="col-sm-10 nopad">
              <div class="panel-group sms_log shade sms-logs" id="sms-logs">
                  <div class="sms_log_title">
                     <h4>SMS Communication </h4>
                  </div> 
                  <div class="sms_log_con cscroll mCustomScrollbar" data-mcs-theme="dark">
                 
                   <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sms-logs" href="#sms_log_2">
                            Sed ut perspiciatis unde omnis iste natusolor error...
                               <div class="rig-sms_tt">
                                <time>12: 25 pm</time>
                                <span> 
                                Monday 23 , Jan 2017
                                </span>
                                <img src="<?= Url::to('@web/img/down-arrow.svg') ?>" alt="MIS">
                            </div>
                        </a>
                      </h4>
                    </div>
                    <div id="sms_log_2" class="panel-collapse collapse in">
                      <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                      minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                      commodo consequat.</div>
                    </div>
                  </div> 
                   <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sms-logs" href="#sms_log_3">
                            Sed ut perspiciatis unde omnis iste natusolor error...
                               <div class="rig-sms_tt">
                                <time>12: 25 pm</time>
                                <span> 
                                Monday 23 , Jan 2017
                                </span>
                                <img src="<?= Url::to('@web/img/down-arrow.svg') ?>" alt="MIS">
                            </div>
                            </a>
                      </h4>
                    </div>
                    <div id="sms_log_3" class="panel-collapse collapse">
                      <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                      minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                      commodo consequat.</div>
                    </div>
                  </div> 
                   <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sms-logs" href="#sms_log_4">
                            Sed ut perspiciatis unde omnis iste natusolor error...
                               <div class="rig-sms_tt">
                                <time>12: 25 pm</time>
                                <span> 
                                Monday 23 , Jan 2017
                                </span>
                                <img src="<?= Url::to('@web/img/down-arrow.svg') ?>" alt="MIS">
                            </div>
                            </a>
                      </h4>
                    </div>
                    <div id="sms_log_4" class="panel-collapse collapse">
                      <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                      minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                      commodo consequat.</div>
                    </div>
                  </div> 
                   <div class="panel panel-default">
                     <div class="panel-heading">
                       <h4 class="panel-title">
                         <a data-toggle="collapse" data-parent="#sms-logs" href="#sms_log_5">
                             Sed ut perspiciatis unde omnis iste natusolor error...
                                <div class="rig-sms_tt">
                                 <time>12: 25 pm</time>
                                 <span> 
                                 Monday 23 , Jan 2017
                                 </span>
                                 <img src="<?= Url::to('@web/img/down-arrow.svg') ?>" alt="MIS">
                             </div>
                             </a>
                       </h4>
                     </div>
                     <div id="sms_log_5" class="panel-collapse collapse">
                       <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                       sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                       minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                       commodo consequat.</div>
                     </div>
                   </div>  
                </div> 
             </div>
            </div> 
          </div>
      </div>
    </div>
  <div class="notif_widget">
  	<div class="widget">
        <div class="wed-head">
            <a class="wid-close" href="#">
                <img src="<?= Url::to('@web/img/close.svg') ?>" alt="Close">
            </a>
            <div class="wed-ico">
                <img src="<?= Url::to('@web/img/alert-ico.svg') ?>" alt="Close">
            </div>
            <div class="wed-altcol">
                <h5>Winter Vacation</h5>
                <p>Lorem ipsum dolor sit amet, consect etur adipiscing elit.</p>
                <span>Friday 28th January 2017</span>
            </div>
        </div>
    </div>
  </div>
  </div>
</div>
