<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - Forum'; 

?>

<div class="request-view" style="margin: 0px;padding: 0px;">
    <h3 class="panel-title">
        <?php if(Yii::$app->user->can('Create Discussion')) { ?>
            <div style='color:white; display:inline-block'><?= Html::a('New Discussion', ['create'], ['class' => 'btn btn-success btn-small']) ?></div>
        <?php } ?>
    </h3><br>
    <div class="panel panel-info">
        
        <div class="panel-heading">
            
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Forum</div>
                        </div>
                    
            </h3>
        </div>
        <div class="panel-body">
            <div class="row" style="margin: 0px;padding: 0px;">

                <?=
                GridView::widget([
                    
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'id' => 'forum-widget',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                       
                        [
                            'attribute' => 'title',
                            'contentOptions' => ['style' => 'width: 20%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'created By',
                            'value'=>'user.username',
                            'contentOptions' => ['style' => 'width: 30%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        
                        [
                            'attribute' => 'created_date',
                            'format' => ['date', 'php:d M y @ h:i a'],
                             'contentOptions' => ['style' => 'width: 15%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                             'contentOptions' => ['style' => 'width: 7%;'],
                            'template' => '{view}&emsp;&emsp;{delete}', 
                            'header'=>'Action',
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
                                $url = Url::to([Yii::$app->controller->id.'/view', 'id' => $model['id']]);
                                return ['data-id' => $model->id,'style'=>'cursor:auto'];
                                    },
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

