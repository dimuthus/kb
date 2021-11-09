<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
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
<?php
    if($feedbackList->getCount()>0)
        $feedback=$feedbackList->getModels()[0];
    else 
        $feedback=$feedbackList->getModels();
    
    if($feedbackDetails->getCount()>0)
        $model=$feedbackDetails->getModels()[0];
    else 
        $model=$feedbackDetails->getModels();
    //$model=$feedbackDetails; 
    if(!empty($feedback)) {
        $this->title = $feedback['subject'];
        $this->params['breadcrumbs'][] = ['label' => 'Feedback', 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;<?=$feedback['subject'];?></div>
                </div>
            </h3>
            <br><div><?=$feedback['user']['username'];?></div><div style='display:inline-block;font-size: 14px; color:darkgreen'><?=$feedback['content'];?></div><br><div class='sub-title'><span style='color: #31708f;'>Posted on</span>&emsp;<?=$feedback['datetime']?></div>
        </div>
        <div class="panel-body">
                <table id="feedbackReplies" class="items table table-bordered">
                    <thead> 
                    </thead>
                    <tbody>
                    <?php 
                    if(!empty($model)) 
                        foreach($feedbackDetails->getModels() as $data){ 
                            echo "<tr><td>";
                            echo "<div class='title'>".$data['user']['username']."</div>"; 
                            echo "<p class='message'>".$data['reply']."</p>";
                            echo "<div class='sub-title'><span style='color: green'>Posted on </span>".$data['created_date']."</div>"; 
                            echo "</td></tr>";
                        } else echo ' No feedback replies to show..'?>
                </table>
        </div>
    </div>
</div>
    <?php } ?>
<div class="well">
    <form accept-charset="UTF-8" action="save/<?=$feedback['id']?>" method="POST">
        <textarea class="form-control" id="feedback-reply-text" name="feedback-reply-text" placeholder="Type in your reply" rows="3"></textarea><br>
        <button class="btn btn-info" type="submit">Post New Reply</button>
    </form>
</div>

