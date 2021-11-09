<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */

$this->title = $topic['title'];
$this->params['breadcrumbs'][] = ['label' => 'Forum', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($allReplies); die();
?>
<style>
    .title {
        color: #3a87ad;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
}
.message{
    font-size:12px;
    font-weight: bold;
}
.sub-title {
    color: brown;
   /*font-size: 12px; */
    font-style: italic;
   /* font-weight: bold;*/
    line-height: 25px;
}

</style>
<div class="request-view" style="margin: 0px;padding: 0px;">
    
    <div class="panel panel-info">
        
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Topic: <div style='display:inline-block; font-weight: bold;'><?=$topic['title']?></div></div>
                  
                </div>   
            </h3>
            <br><div style='display:inline-block;font-size: 14px; color:darkgreen'><?=$topic['details'];?></div><br><div class='sub-title'><span style='color: #31708f;'>Posted on</span>&emsp;<?=$topic['created_date']?></div>
        </div>
        <div class="panel-body">
                <table id="annoucements" class="items table table-bordered">
                    <thead> 
                    </thead>
                    <tbody>
                        <?php 
                            $i=0;
                            //var_dump($allReplies); die();
                            foreach($allReplies as $record) {
                                $urlDelete = Url::to([Yii::$app->controller->id.'/deletereply', 'id' => $record['id']]);
                                $urlEdit = Url::to([Yii::$app->controller->id.'/editreply', 'id' => $record['id']]);
                                if($i%2==0)
                                    echo "<tr class='odd'>";
                                else
                                    echo "<tr class='even'>";
                                echo "<td>";
                                echo "<div class='title'>".$record['user']['username']."</div>"; 
                                echo "<p class='message'>".$record['message']."</p>";
                                echo "<div class='sub-title'><span style='color: green'>Posted on </span>".$record['created_date']."</div>";
                                echo "</td>";
                                if(Yii::$app->user->can('Edit Delete Reply'))
                                    echo "<td width='6%' style='vertical-align:bottom;text-align:center;'><a href={$urlEdit}><span style='cursor:pointer;' class='glyphicon glyphicon-edit'></span></a>&emsp;<a href={$urlDelete}><span style='cursor:pointer;' class='glyphicon glyphicon-trash'></span></a></td>";
                                echo "</tr>";
                                $i++;
                            }
                        ?>
                    </tbody>
                </table>
        </div>
        <div class="well">
            <form accept-charset="UTF-8" action="savereply/<?=$topic['id']?>" method="POST">
                <textarea class="form-control" id="text" name="text" placeholder="Type in your Comment" rows="3"></textarea><br>
                <button class="btn btn-info" type="submit">Post New Message</button>
            </form>
        </div>
    </div>
</div>

