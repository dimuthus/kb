<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\quiz\QuizdescriptionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quizdescription-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'startTime') ?>

    <?= $form->field($model, 'stopTime') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'verifyAnswer') ?>

    <?php // echo $form->field($model, 'maxSkips') ?>

    <?php // echo $form->field($model, 'noOfQuestion') ?>

    <?php // echo $form->field($model, 'passRate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
