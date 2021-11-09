<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::$app->name . ' - Tools';
$sub_title = 'Quiz Summary';
/*$this->params['breadcrumbs'][] = $this->title;*/
?>
<style>
    .table-striped thead {
        background-color: #006699;
        color: #fff;
    }
    .form-control {
        height:26px;
        font-size: 12px;
    }
    .table > thead > tr >td{
        padding: 4px;
    }
</style>
<div class="quiz-participants-index">
    <div class="panel panel-info" style="margin-top: 20px;">
        <div class="panel-heading">           
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-th"></span>
                <?= $sub_title ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php \yii\widgets\Pjax::begin(['id' => 'quiz','enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=>$searchModel,
                 'filterRowOptions' => ['class' => 'filters','style'=>''],
                'layout'=>"{items}\n{summary}\n{pager}",
                'options'=>[
                    'class'=>'editable-grid',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    ['attribute'=>'user',
                      'value'=>'user.username'
                    ],
                    ['attribute'=>'quiz',
                      'value'=>'quizdescription.title'
                    ],
                    'assign_date',
                    'completed_date',
                    'score',
                   /* ['attribute'=>'results',
                      'value'=>$model->results=='FAILED'?'<span><FAILED></span>':
                        
                    ]*/
                    'results',
                    ['class' => 'yii\grid\ActionColumn','template'=>'{update}',
                        'buttons'=>[
                            'update'=>function ($url,$model, $key) {
                                        /** @var ActionColumn $column */
                                        echo "<input type='hidden' id='hello' value'hi'>";
                                        $url = Url::to([Yii::$app->controller->id.'/quizparticipantreset', 'id' => $model->quiz_id,'user_id'=>$model->user_id]);
                                        return Html::a('<button type="button" class="btn btn-xs btn-success">RESET</button>', $url, [
                                                'title' => Yii::t('yii', 'Reset'),
                                        ]);
                            },
                        ],

                    ],
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                                                $url = Url::to([Yii::$app->controller->id.'/view', 'id' => $model['id']]);
                                                return ['data-id' => $model->id,'style'=>'cursor:auto'];
                                                    },
            ]); ?>

            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>
<?php
    $this->registerJs("

        $('#dropdown-category-form').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            addDropdownValue($(this),'quiz');
            return false;
        });

    ");
?>

