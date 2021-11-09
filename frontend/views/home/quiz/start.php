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
<?php $model=$quizStart->getModels(); ?>
<style>
    h4{
        font-size: 16px !important;
        width:80%;
        padding-left:10%;
         
    }
    div:not(.modal-header) > h4 {
        margin-left:10%;
    }
    li{
        line-height: 200%;
         font-size: 14px !important;
         color:white;
         
         padding-left:10px;
    }
    .frame{}
</style>
<div class="start-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;You are going to do <strong><?=$model[0]['title'];?></strong></div><br>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <div class="row" style="margin: 0px;padding: 0px; background: #428bca none repeat scroll 0 0; border-radius: 5px;">
                <h4>Welcome <strong><?= Yii::$app->user->identity->username ?></strong> !!</h4><br/>
                <div id='frame'>
                    <ul>
                        <li>Once you start the quiz you may not save the session.</li>                       
                        <li>   Once you start the quiz you may not save the session.<br/></li>
                        <li>   Once you submit the answers you cannot retake the quiz.<br/></li>
                        <li>   Please complete all questions displayed.<br/></li>
                        <li>   Do not refresh the page or system may render you taken the quiz.<br/></li>
                        <li>  There is a time limit of <strong><?php echo $model[0]['duration'];?> minutes </strong> for you to attend the questions after which auto submission will be enforced.<br/></li>
                        <li>   Timer is located at the left top corner of the page.<br/></li>
                        <li>  To proceed click on start button. <br/></li>
                    </ul>
                </div>
            </div>
            <div style='color:white; display:inline-block; margin-left:45%; padding-top:4px;'><?= Html::a('Start Quiz', ['startquiz', 'id' => $model[0]['id']], ['class' => 'btn btn-success ','id'=>'start_quiz']) ?></div>
        </div> 
    </div>  
</div>

<?php
$this->registerJs("
    $('#start_quiz').click(function (e) {
        result = confirm('Are you sure you want to start this Quiz? Once started, you must complete the Quiz or wait for you time to end.');
       return result;
    });
");
?>