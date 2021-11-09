<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\widgets\SwitchInput;

?>
<style>
    .table-striped thead {
        background-color: #006699;
        color: #fff;
    }
</style>
<?php $this->registerJsFile(Url::base() .'/js/jquery.js', ['position' => \yii\web\View::POS_END]); ?>
<?php \yii\widgets\Pjax::begin(['id' => 'team','enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}\n{summary}\n{pager}",
        'options'=>[
            'class'=>'editable-grid',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute'=>'name',

                'editableOptions' => function($model, $key, $index, $widget){
                    return [
                        'name'=>'name',
                        'value' => $model->name,
                        'inputType' => Editable::INPUT_TEXT,
                        'asPopover' => false,
                        'inlineSettings' => [
                            'templateBefore' =>'<div class="kv-editable-form-inline"><div class="form-group"></div>',
                            'templateAfter' =>'<div class="form-group">{buttons}{close}</div></div>'
                        ],
                        'options' => [
                            'pluginOptions' => ['min'=>0, 'max'=>250],

                        ]
                    ];
                },
                'pageSummary' => true
            ],
            [
                'attribute' => 'Status',
                'value'=>'type',
                'format' => 'raw',
                'contentOptions'=>['class'=>'switch','style' => 'width: 10%;'],
                'value' => function ($model) {   

                        $switch = SwitchInput::widget([
                                    'name'=>'type',
                                    'value'=>($model->isactive == 1)?1:0,
                                    'pluginOptions'=>[
                                        'handleWidth'=>40,
                                        'size'=>'mini',
                                        'onColor' => 'success',
                                        'offColor' => 'danger',
                                        'onText'=>'Active',
                                        'offText'=>'Inactive',
                                            
                                     ],
                                    'pluginEvents'=> [
                                        'switchChange.bootstrapSwitch' => 
                                            'function(event, state) { 
                                                toggleDeleted(state, "'.Url::to(['/tools/user/team',
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