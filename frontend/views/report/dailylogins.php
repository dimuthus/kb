
<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::$app->name . ' - Tools';
$sub_title = 'Daily Logins';
/*$this->params['breadcrumbs'][] = $this->title;*/
?>

<?php
    $this->registerJs("

        $('td').click(function (e) {
            var id = $(this).closest('tr').data('id');
            if(e.target == this && id != undefined)
                location.href = '" . Url::to(['/tools/user']) . "/' + id;
        });
		$('.table').DataTable({
		
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel'
		]
	});
    ");
    ?>
<style>
    .table-striped thead {
        background-color: #006699;
        color: #fff;
    }
</style>
<div class="user-index">
<div class="panel panel-info" style="margin-top: 20px;">
        <div class="panel-heading">           
            <h3 class="panel-title">
                <span class="glyphicon glyphicon-th"></span>
                <?= $sub_title ?>
            </h3>
        </div>
        <div class="panel-body">
    <div style="clear: both;"></div>
    <?php /*var_dump($dataProvider->getModels()); die(); */
     ?>

    <?php \yii\widgets\Pjax::begin(['enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'=>$searchModel,
        'layout'=>"{items}\n{summary}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'user',
              'value'=>'user.username',
              'filter'=>$usersModel,
                ],
            ['attribute'=>'loginDate',
             
             'value'=>'loginDate',
             'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel,'attribute'=>'login_date','dateFormat' => 'yyyy-MM-dd','clientOptions' => [
                        'todayHighlight' => true
                          ],
                     'clientEvents' => [
                         'changeDate' => false
                     ],
                     'options' => [
                         'readonly' => 'readonly'
                     ],
                 ]),
              'format' => 'html',
            ],
            'cLogins',
        ],
        
    ]); ?>



    <?php \yii\widgets\Pjax::end(); ?>

</div>
    </div>
    </div>
