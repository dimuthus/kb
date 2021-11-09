<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$this->title = $title; //var_dump($model['original_filename']); die();
//$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .error-enabled-custom-field div, .error-enabled-custom-field input, .error-enabled-custom-field select {
    float: none;
}
.control-label{
    display:none; 
}

div.required label::after {
    color: red;
    content: "";
}
label{
    display: block;
    padding-left:15px;
    font-weight: normal;
}
</style>
<div class="document-form">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id'=>'quizForm',
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
    ]);
    ?>
    <br>
    <?php 
    //var_dump($model); //die();
    $questions=$model->getModels();
    $i=0;
    foreach($questions as $data){ 
        $options=explode('||',$data['choice']);
        //var_dump($options); var_dump($data['choice']);
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?=++$i.'.&nbsp;'.$data['question']?>
                <?= Html::radioList('quiz_'.$data['id'].'_'.$data['testId'].'_'.$data['sequenceNo'],NULL,$options,[]);?>
            </div>
        </div>   
    <?php } ?>
<div class="form-group">
    <div class="row">
        <div class="col-md-2 col-md-offset-2">
             <input type="hidden" name="action" value="submit" />
            <?= Html::submitButton($model->id ? 'Save Answers' : 'Submit', ['class' => $model->id ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
</div>
    
<?php ActiveForm::end(); ?>

</div>
