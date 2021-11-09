<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::$app->name . ' - Tools';
$sub_title = 'Countries';
$this->registerJsFile(Url::base() .'/js/jquery.js', ['position' => \yii\web\View::POS_END]);
/* $this->params['breadcrumbs'][] = $this->title; */
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

<div class="country-index">
    <div class="panel panel-info" style="margin-top: 20px;">
        <div class="panel-heading">           
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-th"></span>
                <?= $sub_title ?>
            </h3>
        </div>
        <div class="panel-body"> 
            <div id="country-widget">
               <?php \yii\widgets\Pjax::begin(['id' => 'country','enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>

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

                        [
                            'class' => 'kartik\grid\EditableColumn',
                            'attribute'=>'name', 
                            'editableOptions' => [
                                'inputType' => Editable::INPUT_TEXT,
                                'asPopover' => false,
                                'inlineSettings' => [
                                    'templateBefore' =>'<div class="kv-editable-form-inline"><div class="form-group"></div>',
                                    'templateAfter' =>'<div class="form-group">{buttons}{close}</div></div>'
                                ],
                                'options' => [
                                    'pluginOptions' => ['min'=>0, 'max'=>250]
                                ]
                            ],
                            'pageSummary' => true
                        ],
                        [
                            'attribute' => 'enabled',
                            'filter'=>array('1'=>'Active','0'=>'Inactive'),
                            'format' => 'raw',
                            'contentOptions'=>['class'=>'switch'],
                            'value' => function ($model) {   

                                    $switch = SwitchInput::widget([
                                                'name'=>'Status',
                                                'value'=>($model->enabled == 1)?1:0,
                                                'pluginOptions'=>[
                                                    'handleWidth'=>40,
                                                    'size'=>'mini',
                                                    'offColor' => 'danger',
                                                    'onColor' => 'success',
                                                    'onText'=>'Active',
                                                    'offText'=>'Inactive',
                                                 ],
                                                'pluginEvents'=> [
                                                    'switchChange.bootstrapSwitch' => 
                                                        'function(event, state) { 
                                                            toggleDeleted(state, "'.Url::to(['/tools/dropdown/country',
                                                                                                    'id' => $model->id,
                                                                                                    'hasToggle'=>true
                                                                                                    ]).'"); 
                                                        }',
                                                ]
                                            ]);

                                    return $switch;
                            },
                        ]
                    ]
                ]); ?>

                <?php \yii\widgets\Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("

        $('#dropdown-country-form').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            addDropdownValue($(this),'country');
            return false;
        });

    ");
?>

