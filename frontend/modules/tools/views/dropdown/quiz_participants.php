<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::$app->name . ' - Tools';
$sub_title = 'Quiz Participants';
/*$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="quiz-participants-index">
    <div class="panel panel-info" style="margin-top: 20px;">
        <div class="panel-heading">           
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-th"></span>
                <?= $sub_title ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'dropdown-quiz-participants-form']); ?>
            <div class="row">
                      
                        <div class="col-md-3">
                            <?=
                            $form->field($model, 'user_id')->inline()->dropDownList(
                                    $usersModel, ['prompt' => '--Select User--']
                            )->label('User')
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?=
                            $form->field($model, 'quiz_id')->inline()->dropDownList(
                                    $quizModel, ['prompt' => '--Select Quiz--']
                            )->label('Quiz')
                            ?>
                        </div>
                        
                        <div class="col-md-1">
                            <div class="col-md-1"><p>&nbsp;</p></div>
                            <input type="hidden" name="hasNew" value="true">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Add', ['class' => 'btn btn-success btn-sm', 'data-loading-text' => 'Adding...']) ?>                                
                        </div>
            </div>
            <?php ActiveForm::end(); ?>

            <div style="clear: both;"></div>

            <div id="category-widget"> 
                <?= $this->render(Url::to('quiz_participants_list'), [
                        'dataProvider' => $dataProvider,
                    'searchModel'=>$searchModel,
                ]) ?> 
            </div>
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

