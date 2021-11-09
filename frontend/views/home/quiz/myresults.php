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
if($model->getCount()>=1)
    $quizModel=$model->getModels()[0];
else
    $quizModel=$model->getModels();
//var_dump($quizModel);
//die();
?>
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
                    
                    'dataProvider' => $model,
                    //'filterModel' => $searchModel,
                    'id' => 'documents-widget',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                       
                        [
                            'attribute' => 'title',
                            'contentOptions' => ['style' => 'width: 30%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                       
                        [
                            'attribute' => 'description',
                            'contentOptions' => ['style' => 'width: 30%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'duration',
                            'value'=>function($model){return $model['duration'].' Min';},
                            'contentOptions' => ['style' => 'width: 7%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'Complete Date',
                            'value'=>'quizAssign.completed_date',
                            'format' => ['date', 'php:d M Y @ h:i a'],
                            'contentOptions' => ['id'=>"jqcountdown".$model->id,'style' => 'width: 15%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                        [
                            'attribute' => 'results',
                            'value'=>'quizAssign.results',
                            'contentOptions' => ['id'=>"jqcountdown".$model->id,'style' => 'width: 10%;'],
                            'headerOptions' => ['style' => 'color:#fff;font-weight: bold;'],
                        ],
                    ],
                    'rowOptions' => function ($model, $key, $index, $grid) {
                                $url = Url::to([Yii::$app->controller->id.'/show_myresults', 'id' => $model['id']]);
                                return ['data-id' => $model->id,'onClick'=> "window.location.href='{$url}'"];
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
     $('td').click(function (e) {
        var id = $(this).closest('tr').data('id');
        if(e.target == this)
            location.href = '" . Url::to(['accountinfo/update']) . "?id=' + id;
    });
    ");
?>

