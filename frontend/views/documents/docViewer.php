
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\controllers\documentsController;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\home\Home */

?>
<style>
    .document_view {
        width: 100%;
        min-height: 700px;
    }
    img{
       /* width:100%;*/
        max-width:100%;
    }
</style>
<div class="panel panel-info">
    <div class="panel-heading">
         <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <?php $ext = pathinfo($model['original_filename'], PATHINFO_EXTENSION);
    if($ext=='png' || $ext=='jpeg' || $ext=='jpg' || $ext=='gif' || $ext=='tiff') {
    ?>
    <img src="<?php echo Url::base() . '/uploads/' . $model['original_filename']; ?>" >
    <?php } else {?>
        <iframe onload='javascript:resizeIframe(this);' class="document_view" src="<?php echo Url::base() . '/uploads/' . $model['original_filename']; ?>"></iframe>
    <?php } ?>
</div>
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
  
</script>