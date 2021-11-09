<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BOC KB';
//$this->params['breadcrumbs'][] = $this->title;

unset($this->assetBundles['yii\web\JqueryAsset']);
?>
<style>
    .home-index{
        overflow: auto;
    }
    #worldTime{
        width:30%;
        float:left;
    }
    #topDocs,#announcements{
        width:65%;
        float:right;
    }
    #announcement{
        padding-top:15px;
    }
    .feedback{
        padding-left:32%;
        margin-top:20px;
    }
/*


*/

/*[ FONT SIZE ]
///////////////////////////////////////////////////////////
*/
</style>
<div class="home-index">
    <div id='worldTime'>
         


            <?php Yii::$app->assetManager->bundles = ['yii\web\JqueryAsset' => false,]?>
        <?= $this->render('worldTimer', [
                        'vWorldTime' => $worldTime, 
                    ]) ?>
        <?php if (Yii::$app->user->can('Send Feedback')) { ?>
        <div class='feedback'>
           <?= Html::a('Send Feedback', ['send_feedback'], ['class' => 'btn btn-success btn-small']) ?>
        </div>
        <?php } ?>

        
    </div>
   
    <div id='topDocs'>

        <?= $this->render('topDocs', [
                        'vTopDocs' => $topDocs, 
                    ]) ?>
   
    
        <div id='announcement'>

             <?= $this->render('announcements', [
                            'vAnnounce' => $announce, 
                        ]) ?>
        </div>
    </div>



    

</div>


