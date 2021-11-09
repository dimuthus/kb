<?php

use yii\jui\Accordion;
use yii\helpers\Html;

use frontend\models\faq\Faqfav;

use frontend\modules\tools\models\user\User;
/* @var $this yii\web\View */
$this->title = Yii::$app->name . ' - FAQ';
?>
<style type="text/css">
  h4{
  text-align:left !important;
  font-size: 16px !important;
  }

  #Wrapper {
  margin: 10px 0px 10px 0px;
  overflow: auto !important;
  width: 100%;
  height: 500px;
  border-radius: 3px;
  }

  .clipped {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  }

  .collapseall{
  background: #4c4c4c none repeat scroll 0 0;
  color:#FFF;
  padding-left:5px;
  height:25px;
  font-size:18px;
  }

  .panel{
  border: 1px solid transparent !important;
  }

  .panel-default > .panel-heading {
  color: #000000;
  cursor: pointer;
  background-color: #FFF !important;
  border-color: #FF9D1E !important;
  border: 1px soild !important;
  }

  .panel-heading {
  padding: 5px 15px;
  border-top-right-radius: 3px;
  border-top-left-radius: 3px;
  }

  .collapsed {
  background-color: #FFDE00 !important;
  color: #000 !important;
  }

  .panel-title {
  margin-top: 0;
  margin-bottom: 0;
  font-size: 16px;
  color: inherit;
  }

  .panel-body {
  padding: 10px !important;
  background-color: #fcfcfc !important;
  }

  .panel-default > .panel-heading {
  color: #000000;
  cursor: pointer;
  }
  .faqfavourited {
  border-radius: 3px 5px 2px 4px;
  background: #00bff1;
  padding: 2px;
  color: #CF3616;
  font-size: 13px;
  cursor: pointer;
  }

  .faqmakefavourit {
  border-radius: 3px 5px 2px 4px;
  background: #00bff1;
  padding: 2px;
  color: #FFFFFF;
  font-size: 13px;
  cursor: pointer;
  }

  .mj{
  background-color: #FFF;
  border: 1px solid #FF9D1E !important;
  }

  .mj2{
  background-color: #FFF;
  border: 1px solid #FFDE00 !important;
  }
</style> 
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">                
            <div class="row" >                    
                <div class="col-sm-8"><span class="glyphicon glyphicon-th"></span>&nbsp;FAQs</div>
            </div>  
        </h3>
    </div>
    <?php
      $user_id = Yii::$app->user->identity->id;
      $sqltotaluser = "SELECT * from faq_favourite WHERE user_id=".$user_id." ";
      //echo   $sqltotaluser."<br/>";
      $connection = Yii::$app->get('db');
      $command = $connection->createCommand($sqltotaluser);

      $result = $command->queryAll();
      $countfavfaq= count($result);
      //echo $countfavfaq;
    ?>
  
    <div class="panel-body">
        <div id="Wrapper">
            <div id="accordion">
                <div class="panel panel-default">
                    <div class="collapseall" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" style="cursor: pointer;">
                      Collapse \ Expand
                      <span style="float:right;">
                        Favourite : <?php echo $countfavfaq; ?>&nbsp;&nbsp;
                      </span>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                      <div class="panel-body">
                        <?php
//-------------------------------------------------------- Category --------------------------------------------------------	
                        $CountCategory = 0;
                        $categoryName = '';
                        $subCategoryName = '';
                        $a = 0;
                        foreach ($faqData as $key => $value)
                          if ($categoryName != $value['category_name']) {
                            $categoryName = $value['category_name'];
                            $category_name = $value['category_name'];
                            $CountCategory = $CountCategory + 1;
                            //echo $value['category_name']."<br/>";
                            $a++
                        ?>
                          <div class="panel panel-default mj" style="margin-top:0px;margin-bottom:0px;">
                            <div class="panel-heading" style="/*background-color:#FF9D1E; */padding:0px 1px !important;" data-toggle="collapse" data-parent="#collapse_<?php echo $CountCategory; ?>" href="#collapse_<?php echo $CountCategory; ?>">
                              <h4 class="panel-title">
                                <span style="color:#000;">
                                  <strong>
                                    <?php echo $a . ". " . $category_name; ?>
                                  </strong>
                                </a>
                              </h4>
                            </div>
                            <div id="collapse_<?php echo $CountCategory; ?>" class="panel-collapse collapse in">
                              <div class="panel-body">
                                <?php
                          //}
//-------------------------------------------------------- Sub Category -----------------------------------------------------          
                                  $CountSubCategory = 0;
                                  $b = 0;
                                  foreach ($faqData as $key => $value)
                                    if (($value['category_name'] == $category_name) && ($value['sub_category_name'] != $subCategoryName)) {
                                      $subCategoryName = $value['sub_category_name'];
                                      $CountSubCategory = $CountSubCategory + 1;
                                      $sub_category_name = $value['sub_category_name'];
                                      $b++;
                                  //}
                                ?>
                                <div class="panel panel-default mj2" style="margin-top:0px; margin-bottom:0px;">
                                  <div class="panel-heading" data-toggle="collapse" data-parent="#collapse_<?php echo $CountCategory . "_" . $CountSubCategory; ?>" href="#collapse_<?php echo $CountCategory . "_" . $CountSubCategory; ?>">
                                    <h5 class="panel-title">
                                      <?php echo $b . ". " . $sub_category_name; ?>
                                    </h5>
                                  </div>
                                  <div id="collapse_<?php echo $CountCategory . "_" . $CountSubCategory; ?>" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                      <?php
//---------------------------------------------------------- Content --------------------------------------------------------
                                        $contentQestion = '';
                                        $contentAnswer = '';
                                        $c = 0;
                                        foreach ($faqData as $key => $value)
                                          if (($value['category_name'] == $category_name) && ($value['sub_category_name'] == $sub_category_name) && ($contentQestion != $value['content_qestion']) && ($contentAnswer = $value['content_answer'])) {
                                            $contentQestion = $value['content_qestion'];
                                            $contentAnswer = $value['content_answer'];
                                            $content_qestion = $value['content_qestion'];
                                            $content_answer = $value['content_answer'];
                                            $c++
                                      ?>

                                        <div>
                                          <div class="row" >
                                            <div class="col-md-11">
                                              <div class="row" >
                                                <div class="col-md-12" >
                                                  <a data-toggle="collapse" data-parent="#collapseQ_"
                                                    <?php echo $value['id']; ?>" href="#collapseQ_<?php echo $value['id']; ?>">
                                                    <div style="padding:6px 15px; font-size:12px; color: #000;">
                                                      <font style="color:red; font-weight:bold;">Q </font><?php echo $c . " : " . $content_qestion; ?>
                                                    </div>
                                                  </a>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-12">
                                                    <div id="collapseQ_<?php echo $value['id']; ?>" class="panel-collapse collapse">
                                                  <div style="background-color:#F7F7F7; padding:6px 15px; font-size:12px;">
                                                    <font style="color:green; font-weight:bold;">A </font>: <?php echo $content_answer; ?>
                                                  </div>
                                                </div>
                                                    
                                                    
                                                </div>
                                              </div>  
                                            </div>

                                            <div class="col-md-1" style="text-align:center; padding:10px 0px 10px 0px;">
                                              <?php 		
                                              $userFavCnt=0;
								                              $queryfav="SELECT * FROM faq_favourite WHERE  ".
                                                        "faq_id=".$value['id']." and  user_id=".$user_id." ".
                                                        "AND isfavourite=0";
									                            //echo   $queryfav."<br/>"; "AND isfavourite=0 ORDER BY id DESC LIMIT 1";
                                              $connection = Yii::$app->get('db');
                                              $command = $connection->createCommand($queryfav);

                                              $resultfav = $command->queryAll();
                                              $userFavCnt= count($resultfav);
                                              //echo $userFavCnt;
                                            ?>

                                              <form accept-charset="UTF-8" action='faq/save_fav' method="POST">
                                                <input type='hidden' id='faq_id' name='faq_id' value='<?=$value['id']?>'/>
                                                <input type='hidden' id='user_id' name='user_id' value='<?=$user_id?>'/>
                                                <?php

                                                if ($userFavCnt==0) {
                                                  echo "<button class='glyphicon glyphicon-heart faqmakefavourit' type='submit'></button>";
                                                  echo "<input type='hidden' id='opt' name='opt' value='0'/>";
                                                }
                                                                            
                                                else {
                                                  echo "<button class='glyphicon glyphicon-heart faqfavourited' type='submit'></button>";
                                                  echo "<input type='hidden' id='opt' name='opt' value='1'/>";
                                                }
                                              ?>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <div style="border-bottom: 1px solid #ddd; margin-bottom:5px;"></div>
                                    <?php }
                                    ?>
                                    </div>
                                  </div>
                                </div>
                                <br/>
                                <?php }
                                ?>
                              </div>
                            </div>
                          </div>
                        <br/>
                          <?php }
                          ?>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>