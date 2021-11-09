<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\home\Announcement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="announcement-form">
<?php //die('here00'); 
?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => 1000]) ?>
    
    <?= $form->field($model, 'active')
                        ->radioList(
                            [1 => 'Yes', 0 => 'No']
                        )
                    ->label('Active');
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
