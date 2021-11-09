<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = 'Feedback'; //var_dump($model); //(); 
$this->params['breadcrumbs'][] = ['label' =>$this->title, 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Send Feedback</div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <form accept-charset="UTF-8"  method="POST">
                <input type="text" class="form-control" id="feedback-subject" name='feedback-subject' placeholder='Type in your subject' required><br>
                <textarea class="form-control" id="feedback-content" name="feedback-content" placeholder="Type in your message" rows="3" required></textarea><br>
                <button class="btn btn-success btn-small" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>