<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\documents\DocCategory;
use yii\helpers\Url;
use asmoday74\ckeditor5\EditorInline;


$this->title = 'FAQs Uploader'; //var_dump($model['original_filename']); die();
$this->params['breadcrumbs'][] = ['label' => 'Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php EditorInline::begin([
		'name' => 'editor-inline',
		
	]);?>
		<h1>The three greatest things you learn from traveling</h1>
		<p>Like all the great things on earth traveling teaches us by example. 
		Here are some of the most precious lessons I’ve learned over the years of traveling.</p>
	<?php EditorInline::end();?>
<div class="faqsuploader-form">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{hint}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-4 col-sm-left-align',
                        'offset' => 'col-sm-offset-1',
                        'wrapper' => 'col-sm-6 error-enabled-custom-field',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    
    <div class="row">
        <div class="col-sm-4">
            <?=
            $form->field($model, 'file_name')->fileInput()->label('Attachement')
            ?>
        </div>
    </div>
   
    
    <div class="row">
        <div class="col-md-3 col-md-offset-1" style='background-color: #d9edf7; padding:4px;'>
            <a href='<?= Url::base() . '/uploads/' . 'faqsSample.csv'; ?>'>Download sample csv file(csv)</a>
        </div>
    </div>
     <div class="form-group"></div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-2 col-md-offset-2">
                <?= Html::submitButton($model->id ? 'Upload FAQs' : 'Upload', ['class' => $model->id ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>

</div>
