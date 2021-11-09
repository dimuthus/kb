<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\faq\FaqmngSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FAQ Management';
//$this->params['breadcrumbs'][] = ['label' => 'Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .form-control {
        height:26px;
        font-size: 12px;
    }
    .table > thead > tr >td{
        padding: 4px;
    }
</style>
<div class="faq-index">
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
                <?= Html::a('Create FAQ', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'id' => 'faqmng-widget',
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                  //  'id',
                    'category_name',
                    'sub_category_name',
                    'content_qestion:ntext',
                    'content_answer:ntext',
                    // 'created_date',
                    // 'created_by',

                    ['class' => 'yii\grid\ActionColumn','header'=>'Action',],

                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                                        $url = Url::to([Yii::$app->controller->id.'/view', 'id' => $model['id']]);
                                        return ['data-id' => $model->id,'style'=>'cursor:auto'];
                                            },
            ]); ?>
        </div>
    </div>
</div>
   
