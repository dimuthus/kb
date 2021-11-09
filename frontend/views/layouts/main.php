<?php
use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;

use frontend\models\Marquee;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this); 
?>

<?php $this->beginPage() ?>
<?php $this->registerCssFile(Url::base() .'/css/main.css', ['position' => \yii\web\View::POS_HEAD]); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="<?= Url::base()?>/images/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title>BOC KB</title>
    <?php $this->head() ?>    
    
</head>
<body  data-root="<?= Url::base()?>">
    <?php $this->beginBody() ?>

    <div class="wrap bodyBack">
        <div id="top" style="width:100%; z-index:120">
            <?php
                NavBar::begin([
                    'brandLabel' => Html::img('@web/images/boc-logo.jpg', ['alt'=>'BOC KBSSSSS']),
                    'brandOptions' => ['class' => 'myclass', 'style' => 'background-color: #FFF;'],//options of the brand
                    'options' => [
                        'class' => 'navbar-custom navbar-fixed-top img-responsive',
                        'activateItems' => 'true',
                        'activateParents' => 'true',
                    ],
                   
                ]);
                $menuItems = [
                     [
                        'label' => '<span class="glyphicon glyphicon-home"></span> Home',
                        'url' => ['/home'], 
                        'visible' => Yii::$app->user->can('Home Page'),
                        'active' =>  $this->context->route == 'home/index' || (strpos($this->context->route, 'customer/') !== FALSE)
                    ],
                    
                    [
                        'label' => '<span class="glyphicon glyphicon-file"></span> Documents',
                        'url' => ['/documents'], 
                        'visible' => Yii::$app->user->can('Documents Page'),
                        'active' =>  $this->context->route == 'documents/index' || (strpos($this->context->route, 'document/') !== FALSE)
                    ],
                 
                    [
                        'label' => '<span class="glyphicon glyphicon-star"></span> FAQ', 
                        'url' => ['/faq'], 
                        'visible' => Yii::$app->user->can('FAQ Page'),
                        'active' => $this->context->route == 'faq/index'
                    ],
                     [
                        'label' => '<span class="glyphicon glyphicon-edit"></span> Forum', 
                        'url' => ['/forum'], 
                        'visible' => Yii::$app->user->can('Forum Page'),
                        'active' => $this->context->route == 'forum/index'
                    ],
                    [
                        'label' => '<span class="glyphicon glyphicon-question-sign"></span> Quiz',
                        'url' => ['/quiz'],
                        'visible' => Yii::$app->user->can('Quiz Page'),
                        'items' => [  
                            [
                                'label' => 'My Quiz', 
                                'url' => ['/quiz/myquiz'], 
                                'visible' => Yii::$app->user->can('Quiz Page'),
                                'active' => $this->context->route == 'quiz/myquiz'
                            ],
                            [
                                'label' => 'My Results', 
                                'url' => ['/quiz/myresults'], 
                                'visible' => Yii::$app->user->can('Quiz Page'),
                                'active' => $this->context->route == 'quiz/myresults'
                            ],
                        ], 
                       'active' => (strpos($this->context->route, 'quiz/') !== FALSE)
                    ],
                    [
                        'label' => '<span class="glyphicon glyphicon-comment"></span> Feedbacks', 
                        'url' => ['/feedback'], 
                        'visible' => Yii::$app->user->can('Feedbacks Page'),
                        'active' => $this->context->route == 'feedback/index'
                    ],
        //================================= TOOLS MODULE ==========================================
                    [
                        'label' => '<span class="glyphicon glyphicon-cog"></span> Tools', 
                        'visible' => Yii::$app->user->can('Tools Page'),   
                        'items' => [    
                       
                            '<li class="dropdown-header" style="display:'
                            .
                            (   Yii::$app->user->can('Tools Management') ||
                                Yii::$app->user->can('User Management') ||
                                Yii::$app->user->can('Role Management') ||
                                Yii::$app->user->can('Permission Management') 
                                ?'block':'none'
                            )
                            .
                            '">User Administration</li>',
                            [
                                'label' => 'User Management', 
                                'url' => ['/tools/user'], 
                                'visible' => Yii::$app->user->can('User Management'),
                                'active' => $this->context->route == 'tools/user/index'
                            ],
                            [
                                'label' => 'Roles Management', 
                                'url' => ['/tools/user/role'], 
                                'visible' => Yii::$app->user->can('Role Management'),
                                'active' => $this->context->route == 'tools/user/role'
                            ],
                            [
                                'label' => 'Team Management', 
                                'url' => ['/tools/user/team'], 
                                'visible' => Yii::$app->user->can('Team Management'),
                                'active' => $this->context->route == 'tools/user/team'
                            ],
                            [
                                'label' => 'Permission Management', 
                                'url' => ['/tools/permission'],
                                'visible' => Yii::$app->user->can('Permission Management'),
                                'active' => $this->context->route == 'tools/user/permission'
                            ],
                            '<li class="divider"></li>',
                            '<li class="dropdown-header" style="display:'
                            .
                            (   
                                Yii::$app->user->can('User Management') ||
                                Yii::$app->user->can('Role Management') ||
                                Yii::$app->user->can('Permission Management') 
                                ?'block':'none'
                            )
                            .
                            '">Documents Administration</li>',
                            [
                                'label' => 'Upload Document', 
                                'url' => ['/documents/create'],
                                'visible' => Yii::$app->user->can('Upload Document'),
                                'active' => $this->context->route == 'documents/create'
                            ],
                            [
                                'label' => 'Category Management', 
                                'url' => ['/tools/dropdown/category'],
                                'visible' => Yii::$app->user->can('Category Management'),
                                'active' => $this->context->route == 'tools/dropdown/category'
                            ],
                            '<li class="divider"></li>',
                            '<li class="dropdown-header" style="display:'
                            .
                            (   
                                Yii::$app->user->can('Tools Management') ||
                                Yii::$app->user->can('FAQ Management') ||
                                Yii::$app->user->can('Permission Management') 
                                ?'block':'none'
                            )
                            .
                            '">FAQs Administration</li>',
                            [
                                'label' => 'Upload FAQ', 
                                'url' => ['/tools/faqmng/uploadfaq'],
                                'visible' => Yii::$app->user->can('Upload FAQ'),
                                'active' => $this->context->route == 'tools/faqmng/uploadfaq'
                            ],
                            [
                                'label' => 'FAQ Management', 
                                'url' => ['/tools/faqmng'],
                                'visible' => Yii::$app->user->can('FAQ Management'),
                                'active' => $this->context->route == 'tools/faqmng'
                            ],
                            '<li class="divider"></li>',
                            '<li class="dropdown-header" style="display:'
                            .
                            (   
                                Yii::$app->user->can('User Management') ||
                                Yii::$app->user->can('Role Management') ||
                                Yii::$app->user->can('Permission Management') 
                                ?'block':'none'
                            )
                            .
                            '">Quiz Administration</li>',
                            [
                                'label' => 'Quiz Upload', 
                                'url' => ['/tools/quizdescription'], 
                                'visible' => Yii::$app->user->can('Quiz Upload'),
                                'active' => $this->context->route == 'tools/quizdescription'
                            ],
                            [
                                'label' => 'Quiz Participants', 
                                'url' => ['/tools/dropdown/quizparticipants'], 
                                'visible' => Yii::$app->user->can('Quiz Participants'),
                                'active' => $this->context->route == 'tools/dropdown/quizparticipants'
                            ],
                            '<li class="divider"></li>',
                            '<li class="dropdown-header" style="display:'
                            .
                            (   
                                Yii::$app->user->can('User Management') ||
                                Yii::$app->user->can('Role Management') ||
                                Yii::$app->user->can('Permission Management') 
                                ?'block':'none'
                            )
                            .
                            '">Others</li>',
                            [
                                'label' => 'Announcement Management', 
                                'url' => ['/tools/announcement'],
                                'visible' => Yii::$app->user->can('Announcement Management'),
                                'active' => $this->context->route == 'tools/announcement'
                            ],
                             [
                                'label' => 'World Time Management', 
                                'url' => ['/tools/dropdown/country'], 
                                'visible' => Yii::$app->user->can('World Time Management'),
                                'active' => $this->context->route == 'tools/dropdown/country'
                            ],
                            [
                                'label' => 'Marquee Management', 
                                'url' => ['/tools/marquee'], 
                                'visible' => Yii::$app->user->can('Marquee Management'),
                                'active' => $this->context->route == 'tools/dropdown/marquee'
                            ],
                        ],
                        'active' => (strpos($this->context->route, 'tools/') !== FALSE)
                    ],
            //================================ REPORTS MODULE =================================
                    [
                        'label' => '<span class="glyphicon glyphicon-stats"></span> Reports', 
                        'visible' => Yii::$app->user->can('Report Management'),
                        'items' => [  
                            [
                                'label' => 'Agents Logins', 
                                'url' => ['/report/logins'], 
                                'visible' => Yii::$app->user->can('Reporting Page (Agents Logins)'),
                                'active' => $this->context->route == 'report/logins'
                            ],
                            [
                                'label' => 'Frequently Accessed Links', 
                                'url' => ['/report/accesslinks'], 
                                'visible' => Yii::$app->user->can('Reporting Page (Frequently Accessed Links)'),
                                'active' => $this->context->route == 'report/accesslinks'
                            ],
                            [
                                'label' => 'Quiz Summary', 
                                'url' => ['/report/quizsummary'], 
                                'visible' => Yii::$app->user->can('Reporting Page (Quiz Summary)'),
                                'active' => $this->context->route == 'report/quizsummary'
                            ],
                            [
                                'label' => 'Visiting/Ranking Documents', 
                                'url' => ['/report/visitingdocs'], 
                                'visible' => Yii::$app->user->can('Reporting Page (Ranking Documents)'),
                                'active' => $this->context->route == 'report/visitingdocs'
                            ],
                            [
                                'label' => 'Document Acknowledgments', 
                                'url' => ['/report/ackndocs'], 
                                'visible' => Yii::$app->user->can('Reporting Page (Document Acknowledgments)'),
                                'active' => $this->context->route == 'report/ackndocs'
                            ],
                        ], 
                        
                        'active' => (strpos($this->context->route, 'report/') !== FALSE)
                    ],
                ];
                
                echo NavX::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => $menuItems,
                     'encodeLabels' => false,
                ]);
                ?>
            
            <div class="log-info" style="margin-top:10px;">
				<div class="row" >
					<div class="col-sm-8">
						<span style="color: #181818"><?php echo date('Y-m-d'); ?>&nbsp;<span id="clock1" ></span></span>
						<div class="logoS">
								<font style="font-size: 14px; font-weight: bold; text-transform: uppercase;">
									<?= Html::a(Yii::$app->user->identity->username, ['/user']) ?>
								</font>
						</div>
					</div>            
					<div class="col-sm-4" >
						<?= Html::a('<span class="glyphicon glyphicon-log-out"></span> logout', ['/user/logout'], ['data-method'=>'post',
																	'class' => 'btn btn-xs btn-danger console-button']) ?>
					</div>
				</div>
			</div>
                <?php 
                NavBar::end();
            ?>
        </div>
        <div style="margin-top:50px;">
        <?php \yii\widgets\Pjax::begin(['id' => 'marquee','enablePushState'=>FALSE,'timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>

            <?php $marquee = Marquee::findOne(1);
                if($marquee->enabled == 1) { ?>
                    <div id="marquee-box" class="marquee alert-info">
                        <marquee scrollamount="<?= $marquee->speed; ?>"><?= $marquee->message; ?></marquee>
                    </div>
            <?php } ?>

            <?php \yii\widgets\Pjax::end(); ?>
            </div>
            
        <div class="container" >
            <div class='leftside'></div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
            <div class='rightside'></div>
        </div>
    </div>

    <footer class="footer">
        <div class="container" >
        <p class="text-center"><?= Yii::$app->name ?> &copy; <?=date('Y') ?> by Scicom (MSC) Berhad.All rights reserved.</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
<script>
    


    $(document).ready(function(){
         function getdate(){
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
             if(s<10){
                 s = "0"+s;
             }
             $("#clock1").css({fontsize:"12", fontFamily:"century gothic",fontColor:"lightgreen",fontWeight:"bold",background:"#ffde00",color:"#181818"});
            $("#clock1").text(h+" : "+m+" : "+s);
             setTimeout(function(){getdate()}, 500);
            }

            getdate();

})


    



</script>


</html>
<?php $this->endPage() ?>
