<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
?>
<div class="customer-update">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-th"></span>
                Upload Document
            </h3>
        </div>
        <div class="panel-body">
<?=
$this->render('_form', [
    'model' => $model,
])
?>
        </div>
    </div>
</div>