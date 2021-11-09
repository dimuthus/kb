<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\home\Home */

?>
<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Most Visited Documents</div>
                </div>     
            </h3>
        </div>
        <div class="panel-body">
            <div class="row" style="margin: 0px;padding: 0px;">
                <?php $model=$vTopDocs->getModels(); ?>
                <?=
                GridView::widget([
                    
                    'dataProvider' => $vTopDocs,
                    //'filterModel' => $searchModel,
                    'id' => 'documents-widget',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                       
                        [
                            'attribute' => 'file_name',
                            'contentOptions' => ['style' => 'width: 8%;'],
                            'headerOptions' => ['style' => 'background-color:#4c4c4c; color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'name',
                            'label'=>'Category Name',
                            'contentOptions' => ['style' => 'width: 30%;'],
                            'headerOptions' => ['style' => 'background-color:#4c4c4c; color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'uploaded_date',
                            'format' => ['date', 'php:d M y @ h:i a'],
                             'contentOptions' => ['style' => 'width: 20%;'],
                            'headerOptions' => ['style' => 'background-color:#4c4c4c; color:#fff;font-weight: bold;'],
                        ],
                        
                    ],
                    'rowOptions' => function ($model, $key, $index, $grid) {
                                //$url=Yii::$app->controller->id;
                                $url = Url::to(['documents/view', 'id' => $model['id']]);
                               // echo $url;
                                return ['data-id' => $model['id'], 'onClick'=> "window.location.href='{$url}'"];
                                    },
                ]);
                ?>
            </div>
        </div>
    </div>
</div>