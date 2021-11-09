<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Request */
$this->title = Yii::$app->name . ' - Documents';
//unset($this->assetBundles['yii\web\JqueryAsset']);

?>
<?php
    $this->registerJs("

		$('.mytbl').DataTable({
		
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel'
		]
	});
	
	$('.glyphicon-trash').click(function(){
		var result = confirm('Are you sure to delete?');
    if(!result){
        return false;
    }
		
	})
	

    ");
    ?>
<style>
    .form-control {
        height:26px;
        font-size: 12px;
       /* width:230px;*/
    }
    .container input[type="text"]{
        width:none;
    }
    .table > thead > tr >td{
        padding: 4px;
    }

</style>
<div class="documents-view" style="margin: 0px;padding: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">                
                <div class="row" >                    
                    <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;Documents</div>
                </div>  
            </h3>
        </div>
        <div class="panel-body">
            <?php echo  $docCategory; ?>
			
        </div>
    </div>
</div>


                      
                   
<style>

                       
p, span, a, ul, li, button {
    font-family: inherit;
    font-size: inherit;
	font-weight: inherit;
	line-height: inherit;
}

strong {
	font-weight: 600;
}

h1, h2, h3, h4, h5, h6 {
	font-family: 'Open Sans', "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serify;
	line-height: 1.5em;
	font-weight: 300;	
}

strong {
  font-weight: 400;
}

.tile {  
    width: 100%;
    display: inline-block;
	box-sizing: border-box;
	background: #fff;		
	padding: 20px;
	margin-bottom: 30px;
} 

 .title {
    	margin-top: 0px;
  }

.purple, .blue, .red, .orange, .green {
    color: #fff;
  }
  
.purple {
    background: #5133AB;
}

 .purple:hover {
    background: darken(#5133AB, 10%);
 }	
 
.red { background: #AC193D;}

.red:hover {
    background: darken(#AC193D, 10%);
}		


.green {background: #00A600;}

 .green:hover {
	background: darken(#00A600, 10%);
}		


.blue {   background: #2672EC;}

.blue:hover {
	background: darken(#2672EC, 10%);
}	


.orange {  background: #DC572E;}

.orange:hover {
	background: darken(#DC572E, 10%);
}
                      
</style








