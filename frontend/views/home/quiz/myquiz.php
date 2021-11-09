<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - My Quiz';
$quizModels=$currentQuizes->getModels(); 
if($quizModels) 
{
    $quizModel=$quizModels[0];
?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.countdown.js',['position' => \yii\web\View::POS_BEGIN]); ?>
<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Current Questions</div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <div class="row" style="margin: 0px;padding: 0px;">
                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    
                    'dataProvider' => $currentQuizes,
                    //'filterModel' => $searchModel,
                    'id' => 'documents-widget',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                       
                        [
                            'attribute' => 'title',
                            'contentOptions' => ['style' => 'width: 15%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                       
                        [
                            'attribute' => 'description',
                            'contentOptions' => ['style' => 'width: 40%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'duration',
                            'value'=>function($model){return $model['duration'].' Min';},
                            'contentOptions' => ['style' => 'width: 10%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'Time left',
                            'value'=>'duration',
                            'contentOptions' => ['id'=>"jqcountdown".$quizModel['id'],'style' => 'width: 28%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                             'contentOptions' => ['style' => 'width: 7%;'],
                            'template' => '{view}', 
                            'header'=>'Start',
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                            'buttons'=>[
                                'view'=>function ($url,$model, $key) {
                                            /** @var ActionColumn $column */
                                            //$url = $column->createUrl($model, $key, $index, 'delete');
                                           // $url = Url::to([Yii::$app->controller->id.'/quizparticipantdelete', 'id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-play"></span>', $url, [
                                                    'title' => Yii::t('yii', 'Delete'),
                                            ]);
                                },
                            ],
                        ],
                    ],
                    'rowOptions' => function ($model, $key, $index, $grid) {
                                $url = Url::to([Yii::$app->controller->id.'/view', 'id' => $model['id']]);
                                return ['data-id' => $model->id,'style'=>'cursor:auto'];
                                    },
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php 
$this->registerJs("
    $('#jqcountdown".$quizModel['id']."').countdown({until:mysqlTimeStampToDate('".$quizModel['stopTime']."'),
                         format: 'HMS', timezone: +8.0,
                         onExpiry: function disableRun(){
                                        $('#row_".$quizModel['id']."').hide();
                                    },
                         expiryText: \"<div class='over'>It's all over</div>\"}
                        );
    ");
}
else
{ ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Current Questions</div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            No Question to Show.
        </div>
    </div>
                            
<?php }
?>

