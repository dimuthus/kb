<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\faq\Faq */

$this->title = 'Update Faq: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faq-update">

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
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
