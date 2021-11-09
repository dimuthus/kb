<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::$app->name . ' - Tools';
$sub_title = 'Access Links';
/*$this->params['breadcrumbs'][] = $this->title;*/
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
<?php $this->registerJsFile(Url::base() .'/js/jquery.js', ['position' => \yii\web\View::POS_END]); ?>
    <?php \yii\widgets\Pjax::begin(['enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
 <div id="export-box">
        <?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
				//'autoXlFormat'=>true,
                'columns' =>['user.username','click_date'],
                'showColumnSelector'=>false,
								'filename' => 'Customer_Data',
                'exportConfig'=> [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_CSV => true,
				     ExportMenu::FORMAT_CSV   => [
                    'label'           => Yii::t('app', 'CSV'),
					],
					ExportMenu::FORMAT_EXCEL_X => [
                    'label'           => Yii::t('app', 'Excel'),
					],
                ],
                'dropdownOptions' => [
                    'label' => 'Export',
                    'class' => 'btn btn-sm btn-primary'
                ]
            ]);
        ?>
    </div>
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
             'url',
            ['attribute'=>'login_date',
             'value'=>'click_date',
             'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel,'attribute'=>'click_date','dateFormat' => 'yyyy-MM-dd','clientOptions' => [
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
           
        ],
        
    ]); ?> 
   
    <?php
    $this->registerJs("

        $('td').click(function (e) {
            var id = $(this).closest('tr').data('id');
            if(e.target == this && id != undefined)
                location.href = '" . Url::to(['/tools/user']) . "/' + id;
        });

    ");
    ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
    </div>
    </div>


<?php /*
->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        //'pickButtonIcon' => 'glyphicon glyphicon-time',
        'clientOptions' => [
           'todayHighlight' => true
             ],
        'clientEvents' => [
            'changeDate' => false
        ],
        'options' => [
            'readonly' => 'readonly'
        ]
 * 
 */