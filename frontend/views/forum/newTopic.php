<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - Forum'; //var_dump($model); //(); 

?>

<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >          
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Create New Topic</div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <form accept-charset="UTF-8"  method="POST">
                <input type="text" class="form-control" id="forum-topic" name='forum-topic' placeholder='Type in your title' required><br>

                <textarea class="form-control" id="forum-text" name="forum-text" placeholder="Type in your message" rows="3" required></textarea><br>
                <button class="btn btn-info" type="submit">Save Topic</button>
            </form>
        </div>
    </div>
</div>
