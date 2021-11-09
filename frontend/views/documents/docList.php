<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>


<style>

#tree ul:not(#root){padding-left: 20px;}
#tree > ul > li{padding: 2px;}
#tree > ul > li > span{font-size: 0.9em !important;}
#tree {border:none;}
#tree span {font-weight: bold;font-size: 0.8em;display: inline-block;}
#tree a {color: #0000FF !important;font-weight: bold;}    
</style>
<script>
    
$(document).ready(function(){
   
  $("#outerdiv").width($("#docViewDiv").width());
  $("#tree").tree({
          collapseDuration: 100,
          expandDuration: 100,
          dnd: false
        });
        
    
});

function refreshIframe() {
  $("#pc").attr("src", $("#pc").attr("src"));
  
}



</script>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-th"></span>
           Document Navigator
        </h3>
        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#"></a></div>
    </div>
    <div class="panel-body">
        <div id="tree">
            <ul id="root" style="margin-left:1px; list-style-type:none;">
                <?php 

                    foreach($allDocCategories->each() as $category) {
                        echo "<li>";
                        echo "<span>".$category->name."</span>";
                        echo "<ul>";
                        foreach($allDocuments->each() as $document) {
                          if($category['id'] == $document['category_id']) {
                              $url = Url::to([Yii::$app->controller->id, 'id' => $document['id']]);
                            ?>
                            <li><span><a href='<?php echo $document['id']; ?>' ><?php echo $document['original_filename']; ?></a><input type='hidden' id='docId' value="<?php echo $document['id']; ?>"/></span></li>
                            <?php }
                        }
                        echo "</ul>";
                        echo "</li>";
                    }?>
            </ul>
        </div>
    </div>
</div>
