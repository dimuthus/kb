<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bayer KB';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .feedback-index{
        overflow: auto;
    }
    #divfeedbackList{
        width:30%;
        float:left;
    }
    #divfeedbackDetails{
        width:65%;
        float:right;
    }
    #feedbackText{
        padding-top:15px;
    }
</style>
<div class="feedback-index">
    <div id='divfeedbackList'>
        <?= $this->render('feedbackList', [
                        'feedList' => $feedbackList, 
                    ]) ?>
       
    </div>
   <?php if(isset($feedbackDetails) && isset($feedbackList)) {
       
        ?>
         <div id='divfeedbackDetails'>
             <?= $this->render('feedbackDetails', [
                             'feedbackDetails' => $feedbackDetails,
                             'feedbackList'=>$feedbackList,

                         ]) ?>
         </div>
    <?php } 
    else{ 
        ?>
    <div id='divfeedbackDetails'>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">                
                    <div class="row" >                    
                        <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Feedback Content</div>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <div class="row" style="margin: 0px;padding: 0px;">
                    

                </div>
            </div>
        </div>
    </div>
    <?php }?> 

</div>
