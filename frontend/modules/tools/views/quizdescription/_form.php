<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\documents\DocCategory;
use yii\helpers\Url;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
//use dosamigos\ckeditor\CKEditor;
use asmoday74\ckeditor5\EditorClassic;

/* @var $this yii\web\View */
/* @var $model frontend\models\quiz\Quizdescription */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quizdescription-form">

    <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-2 col-sm-left-align',
                        'offset' => 'col-sm-offset-1',
                        'wrapper' => 'col-sm-6 error-enabled-custom-field',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 2]) ?>
	
	   <?= $form->field($model, 'description')->textInput() ?> 

	/*
	< ?= $form->field($model, 'description')->widget(EditorClassic::className(),[
		'clientOptions' => [
			'language' => 'en',
			//'uploadUrl' => 'upload', 	//url for upload files
			//'uploadField' => 'jpg',	//field name in the upload form
			
		]
	]); ?>  */
   <!-- < ?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advanced'
    ]) ?> -->
   <!-- < ?= $form->field($model, 'description')->textInput() ?> -->

   <!-- < ?= $form->field($model, 'startTime')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter event time ...'],
    'type' => DateTimePicker::TYPE_INLINE,

    'pluginOptions' => [
        'autoclose' => true
    ]
]); ?>
    
    < ?= $form->field($model, 'stopTime')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Select start date time ...'],
    'type' => DateTimePicker::TYPE_INLINE,
    'pluginOptions' => [
        'autoclose' => true
    ]
]) ?> -->

    <?= $form->field($model, 'duration')->textInput()->label('Duration (Min)') ?> 
    

    <?= $form->field($model, 'maxSkips')->textInput() ?>

    <?= $form->field($model, 'noOfQuestion')->textInput() ?>

    <?= $form->field($model, 'passRate')->textInput() ?>

        
    <?= $form->field($model, 'file_name')->fileInput()->label('Attachement') ?>

    <div class="row">
        <div class="col-md-4 col-md-offset-1" style='background-color: #d9edf7; padding:4px;'>
            <a href='<?= Url::base() . '/uploads/' . 'SampleQuiz.xlsx'; ?>'>Please download the Sample Quiz xlsx File from here</a>
        </div>
    </div>
    <div class="form-group"></div>
    
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    

    <?php ActiveForm::end(); ?>

</div>
