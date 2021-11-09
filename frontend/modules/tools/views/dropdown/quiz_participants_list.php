<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;

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
<?php $this->registerJsFile(Url::base() .'/js/jquery.js', ['position' => \yii\web\View::POS_END]); ?>
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
            'results',
            ['class' => 'yii\grid\ActionColumn','template'=>'{delete}',
                'buttons'=>[
                    'delete'=>function ($url,$model, $key) {
                                /** @var ActionColumn $column */
                                //$url = $column->createUrl($model, $key, $index, 'delete');
                                $url = Url::to([Yii::$app->controller->id.'/quizparticipantdelete', 'id' => $model->id]);
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
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
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>