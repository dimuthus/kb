<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\quiz\Quizdescription */

$this->title = 'Create Quiz';
$this->params['breadcrumbs'][] = ['label' => 'Quiz Descriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quizdescription-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;<?= Html::encode($this->title) ?></div>
                </div>               
            </h3>
            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#"></a></div>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
   
    

</div>
