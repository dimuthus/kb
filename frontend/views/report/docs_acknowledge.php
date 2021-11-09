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
$sub_title = 'Documents Acknowledge';
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
             <?php $this->registerJsFile(Url::base() .'/js/jquery.js', ['position' => \yii\web\View::POS_END]); ?>
            <?php \yii\widgets\Pjax::begin(['id' => 'acknowledge','enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
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
                    
                    ['attribute'=>'document',
                      'value'=>'documents.original_filename'
                    ],
                     ['attribute'=>'description',
                      'value'=>'documents.description'
                    ],
                     
                    ['attribute'=>'user',
                      'value'=>'user.username'
                    ],
                    ['attribute'=>'aknowledge_date',
             
                    'value'=>'aknowledge_date',
                    'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel,'attribute'=>'aknowledge_date','dateFormat' => 'yyyy-MM-dd','clientOptions' => [
                               'todayHighlight' => true
                                 ],
                            'clientEvents' => [
                                'changeDate' => false
                            ],
                            'options' => [
                                'readonly' => 'readonly'
                            ],
                        ]),
                     'format' => 'html',
                   ],
                    ['class' => 'yii\grid\ActionColumn','template'=>'{view}',
                        'buttons'=>[
                            'view'=>function ($url,$model, $key) {
                                        /** @var ActionColumn $column */
                                        echo "<input type='hidden' id='hello' value'hi'>";
                                        $url = Url::to(['documents/view', 'id' => $model->doc_id]);
                                        
                                        return Html::a('<button type="button" class="btn btn-xs btn-success">View Document</button>', $url, [
                                                'title' => Yii::t('yii', 'Reset'),
                                        ]);
                            },
                        ],

                    ],
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                                                //$url = Url::to([Yii::$app->controller->id.'/view', 'id' => $model['id']]);
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

