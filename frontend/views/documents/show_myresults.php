<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use Zelenin\yii\SemanticUI\Elements;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - My Results';
//die('my Results');
?>
<style>
    .qt{
        color:#31708f;
        background:#f2dede;
        /*border:1px green solid;*/
        padding:10px;
        border-radius: 5px;
        margin-bottom:5px;
    }
    .quiz{
        font-size:14px;
    }
    .adm{
        font-weight: bold;
    }
    .answer{
        color:red;
    }
</style>
<?php        
    
    $userName=Yii::$app->user->identity->username;
    $qAssign=$quizDesc['quizAssign']; //); die();
    $Qs=$questions->getModels();
    $As=$answers->getModels();

    $quiz_title=$quizDesc['title'];
    
?>
 
<div class="customer-update">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;<?=$quiz_title?> </div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <div class='qt'>
                <span class='quiz'>Hi <span class='adm'><?=$userName?></span> You have completed the <span class='adm'><?=$quiz_title?></span>
                    <br>Your Score: <?=$qAssign['score'];?>
                    <br> Final Result: <span style="font-weight:bold"><?=$qAssign['results'];?></span>
                </span>
            </div>
            <?php 
                $i=0;
                foreach($Qs as $data){ 
                    $options=explode('||',$data['choice']);
                    //var_dump($data); //."\n";
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?=++$i.'.&nbsp;'.$data['question']?>
                            
                            <?php
                            $j=1;
                            $class='';
                            foreach($options as $value){
                                $class='';
                                foreach ($As as $res){
                                    if($res['questionId']==$data['sequenceNo'] && $res['answer']==$value){
                                        $class='answer';
                                        break;
                                    }
                                }
                                //echo $class;
                                if($value==$data['answer'])
                                    echo "<br>&emsp;&emsp;".$j++.".&nbsp; <span class='".$class."' style='color:green'>".$value."</span>";
                                else
                                    echo "<br>&emsp;&emsp; <span class='".$class."'>".$j++.".&nbsp;".$value."</span>";
                            } ?>
                        </div>
                    </div>   
            <?php } ?>
           
        </div>
    </div>
</div>     