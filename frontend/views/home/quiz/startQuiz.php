<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use Zelenin\yii\SemanticUI\Elements;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - My Quiz';

?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.countdown.js',['position' => \yii\web\View::POS_BEGIN]); ?>

<span id="quizTime" class="countdown_hms"></span><br>
<div id="countdowntimer"><span id="future_date"><span></div>
<?php 

$min=$quizDesc['duration'];
//$min=1;
date_default_timezone_set("Asia/Kuala_Lumpur");
$finishDateTime= date("Y-m-d h:i:s", strtotime("+".$min." minutes"));?>
<div class="customer-update">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                
            </h3>
            <span id="quizTime" class="countdown_hms"></span>
            <div id="countdowntimer"><span id="future_date"><span></div>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $questions,
                'title'=>$quizDesc['title'],
            ])
            ?>
        </div>
    </div>
</div>
<?php
$this->registerJs("

    $('#quizTime').countdown({until:mysqlTimeStampToDate('".$finishDateTime."'),
        format: 'HMS', description: 'till your time ends.', timezone: +8.0,
        expiryText: \"<div class='over'>It's all over</div>\",
        onExpiry: function(){
                    $('#quizForm').yiiActiveForm('submitForm');
            }
        });
");
?>
 <script>
    jQuery(document).on('click',function (e) {
        if(document.activeElement.type=='')
           // result = confirm('Are you sure you want to start this Quiz? Once started, you must complete the Quiz or wait for you time to end.');
        //alert result;
        return false;
    });
 </script>
 <?php /*
   var form = $('#quizForm');
    form.on('submit', function(e) {
        alert('form already submitted');
      return form.yiiActiveForm('submitForm');
   }); 
    var isPostback = false;
    window.onbeforeunload  =unloading;
    function unloading(){
        if (!isPostback){
            return 'Caution: The timer will not be paused.';
        }
    }
  */
            