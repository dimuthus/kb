<?php

use yii\helpers\Html;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model frontend\models\home\Home */

?>
<style>
    h4{margin:0px;}
    .star-rating{
        display:inline-block;
    }
    .caption{
        display:none !important;
    }
</style>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
             <?php if (!isset($docAckn)) { ?>
            <span class="glyphicon glyphicon-thumbs-up"></span>
                I hereby acknowledge that I have read this document.&emsp;
                <div style='color:white; display:inline-block'><?= Html::a('Acknowledge', ['save_doc_acknowledge', 'id' => $model->id], ['class' => 'btn btn-success btn-small']) ?></div>
             <?php } else { ?>
                This document ALREADY acknowledged 
             <?php } ?>
        </h3>
        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#"></a></div>
    </div>
    <div class="panel-body">
         <?php if (isset($docRating) && $docRating->rating) { 
             echo StarRating::widget(['model' => $docRating, 'attribute' => 'rating',
                'name' => 'docRating',
                'pluginOptions' => ['disabled'=>true, 'showClear'=>false,'size'=>'sm']
            ]);
         } else {?>
            <form accept-charset="UTF-8"  action='save_doc_rating' method="POST">
            <?= StarRating::widget(['model' => $docRating, 'attribute' => 'rating',
                    'name' => 'docRating',
                    'pluginOptions' => ['disabled'=>false, 'showClear'=>false,'size'=>'sm']
                ]);
            ?>
                <input type='hidden' id='doc_id' name='doc_id' value='<?=$model->id?>'/>
                <button class="btn btn-info" style='margin:4px;' type="submit">Save Rating</button>
            </form>
         <?php } ?>
        <form accept-charset="UTF-8"  action='save_doc_feedback' method="POST">
            <input type='hidden' id='doc_id' name='doc_id' value='<?=$model->id?>'/>
            <input style='display:inline-block; width:80%;' type='text' id='doc-feedback-text' name='doc-feedback-text' width='80%' placeholder='Type in your document feedback' class='form-control' required/>
            <button class="btn btn-info" type="submit">Save Feedback</button>
        </form>
    </div>
</div>

