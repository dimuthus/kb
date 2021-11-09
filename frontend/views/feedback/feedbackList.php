<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - Feedback';
?>

<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Feedbacks</div>
                        </div>
            </h3>
        </div>
        <div class="panel-body">
            <div class="row" style="margin: 0px;padding: 0px;">
<?php    $model=$feedList->getModels();  ?>
                <?= 
                GridView::widget([
                    
                    'dataProvider' => $feedList,
                    //'filterModel' => $searchModel,
                    'id' => 'feedback-widget',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                       
                        [
                            'attribute' => 'Date',
                            'value' => 'datetime',
                            'format' => ['date', 'php:y/m/d'],
                             'contentOptions' => ['style' => 'width: 20%; font-size:11px'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                         [
                            'attribute' => 'Time',
                             'value'=>'datetime',
                            'format' => ['date', 'php:h:ia'],
                             'contentOptions' => ['style' => 'width: 20%; font-size:11px'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'subject',
                            'contentOptions' => ['style' => 'width: 25%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'User',
                            'value'=>'user.username',
                            'contentOptions' => ['style' => 'width: 20%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                             'header'=>'Action',
                             'template' => '{view}&nbsp;{delete}', 
                             'contentOptions' => ['style' => 'width: 15%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                            'buttons' => [                                
                                'delete'=>function($url,$model){
                                    if(Yii::$app->user->can('Delete Forum')){
                                     $options = [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'aria-label' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    ];
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                                    }
                                }
                            ]
                        ],
                    ],
                    'rowOptions' => function ($model, $key, $index, $grid) {
                                $url = Url::to([Yii::$app->controller->id.'/view', 'id' => $model->id]);
                                return ['data-id' => $model->id,'style'=>'cursor:auto'];
                                    },
                ]); 
                ?>
            </div>
        </div>
    </div>
</div>

