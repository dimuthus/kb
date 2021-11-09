<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\documents\Documents */

$this->title = $model->original_filename;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .doc-index{
        overflow: auto;
    }
    #doc_category{
        width:25%;
        float:left;
        margin-right:5px;
    }
    #ackn,#docViewer{
        width:70%;
        float:left;
    }
    #docViewer{
       
        float:left;
         width:100%;
    }
</style>
<div class="documents-view doc-index">
    <div id='doc_category'>
        <div style="float:left; width:100%;" >
            <?= $this->render('docList',[
                    'model'=>$model,
                    'allDocuments'=>$allDocs,
                    'allDocCategories'=>$allCategories,
                ]);  
            ?>
        </div>
    </div>
    <div id='ackn'>
        <?= $this->render('docAknlg',[
                    'model'=>$model,
                    'allDocuments'=>$allDocs,
                    'allDocCategories'=>$allCategories,
                    'docRating'=>$docRating,
                    'docAckn'=>$docAckn,
                ]);  
            ?>
        <div id='docViewer'>            
            <?= $this->render('docViewer',[
                    'model'=>$model,
                ]);  
            ?>
    </div>
    </div>
</div>
