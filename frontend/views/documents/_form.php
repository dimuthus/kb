<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\documents\DocCategory;
$this->title = $model['original_filename']; //var_dump($model['original_filename']); die();
$this->params['breadcrumbs'][] = ['label' => 'Document', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="document-form">

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

    Fields with <span style="color:red">*</span> are mandatory.<br/><br/>
    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($model, 'category_id')->dropDownList(
                    ArrayHelper::map(docCategory::find()->where('deleted != :id', ['id' => 1])->orderBy('name')->all(), 'id', 'name'), ['prompt' => '--Select Category--']
            )->label('Category')
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 5])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($model, 'acknowledge')->checkBox()->label('Acknowledged')
            ?>
        </div>
    </div>
     <div class="row">
        <div class="col-sm-4">
            <?=
            $form->field($model, 'original_filename')->fileInput()->label('Attachement')
            ?>
        </div>
    </div>
    
    <div class="form-group"></div>
<div class="form-group">
    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <?= Html::submitButton($model->id ? 'Update document' : 'Save Changes', ['class' => $model->id ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
        </div>
</div>
       </div>
<?php ActiveForm::end(); ?>

</div>
