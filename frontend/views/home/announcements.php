<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\home\Home */

?>
<style>
    .title {
        color: #3a87ad;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
}
.sub-title {
    color: brown;
    font-size: 12px;
    font-style: italic;
    font-weight: bold;
    line-height: 25px;
}
</style>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-th"></span>
           Announcements
        </h3>
    </div>
    <div class="panel-body">
        <table id="annoucements" class="items table table-bordered">
        <thead> 
        </thead>
        <tbody>
            <?php 
                $i=0;
                foreach($vAnnounce as $record) {
                    if($i%2==0)
                        echo "<tr class='odd'>";
                    else
                        echo "<tr class='even'>";
                    
                    echo "<td>";
                    echo "<div class='title'>".$record['title']."</div>";
                    echo "<div class='sub-title'><span style='color: #000'>Posted on </span>".$record['updated_date']."</div>";
                    echo "<p>".$record['message']."</p>";
                    echo "</td></tr>";
                    $i++;
                }
            ?>
        </tbody>
    </table>
    </div>
</div>