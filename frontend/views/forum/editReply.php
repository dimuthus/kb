<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - Forum'; //var_dump($model); echo $model->message; die(); 

?>

<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Edit Reply</div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <form accept-charset="UTF-8"  method="POST">
                <textarea class="form-control" id="forum-reply-text" name="forum-reply-text" rows="3" required><?=  $model->message?></textarea><br>
                <button class="btn btn-info" type="submit">Save Reply</button>
            </form>
        </div>
    </div>
</div>

<div class="well">
   
</div>