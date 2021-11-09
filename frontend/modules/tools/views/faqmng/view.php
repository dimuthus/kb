<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\faq\Faq */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-view">
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
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'category_name',
                    'sub_category_name',
                    'content_qestion:ntext',
                    'content_answer:ntext',
                    'created_date',
                    //'created_by',
                ],
            ]) ?>
        </div>
    </div>
</div>
