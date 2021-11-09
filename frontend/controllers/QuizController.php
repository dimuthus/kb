<?php

namespace frontend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Query;
use frontend\models\quiz\QuizDescription;
use frontend\models\quiz\Questions;
use frontend\models\quiz\QuizAnswers;
use frontend\models\quiz\QuizAssign;
use yii\db\Expression;
class QuizController extends \yii\web\Controller
{
     public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                       'actions' => ['index','view','myquiz','startquiz'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('Quiz Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }
                    ],
                    [
                       'actions' => ['myquiz'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                        if(!Yii::$app->user->can('Quiz Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                           return true;
                       }
                    ],
                    [
                       'actions' => ['view'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                        if(!Yii::$app->user->can('Quiz Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                           return Yii::$app->request->isAjax && Yii::$app->request->isPost;
                       }
                    ],
                            [
                       'actions' => ['startquiz'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                        if(!Yii::$app->user->can('Quiz Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                           return Yii::$app->request->isAjax && Yii::$app->request->isPost;
                       }
                    ]
                      
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {

     
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }


        return $this->render('index');
    }
    
    public function actionMyquiz()
    {  



            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



     $user_id=Yii::$app->user->identity->id;
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dataProvider = new ActiveDataProvider([
            'query'=>QuizDescription::find()->joinWith('quizAssign')->where(['user_id'=>$user_id])->andWhere(['>','stopTime',new Expression('NOW()')])->andWhere(['IS','completed_date',NULL]),
        ]);
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,5);
        return $this->render('myquiz',[
            'currentQuizes'=>$dataProvider,
        ]);
    }
    
    public function actionView($id)
    {



            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




        $dataProvider = new ActiveDataProvider([
            'query'=>QuizDescription::find()->where(['id'=>$id]),
        ]);
        return $this->render('start',[
            'quizStart'=>$dataProvider,
        ]);
    }
    
    public function actionMyresults()
    {


        
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




        $user_id=Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query'=>QuizDescription::find()->joinWith('quizAssign')->where(['user_id'=>$user_id])->andWhere(['IS NOT','completed_date',NULL])
        ]);
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,5);
        return $this->render('myresults',[
            'model'=>$dataProvider,
        ]);
    }
   public function actionShow_myresults($id)
    {


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        $user_id=Yii::$app->user->identity->id;
        $results=QuizDescription::find()->joinWith('quizAssign')->where(['user_id'=>$user_id,'quiz_id'=>$id])->asArray()->One();
        $qAssign=QuizAssign::findOne(['user_id'=>$user_id,'quiz_id'=>$id]);
        $dataProvider2 = new ActiveDataProvider([
            'query'=>Questions::find()->where(['testId'=>$id]),
        ]);
        $dataProvider3 = new ActiveDataProvider([
            'query'=>QuizAnswers::find()->where(['testId'=>$id,'userId'=>$user_id]),
        ]);
        return $this->render('show_myresults',[
            'quizDesc'=>$results,
            'questions'=>$dataProvider2,
            'answers'=>$dataProvider3,
            'qAssign'=>$qAssign,
        ]);
    }
    
    public function actionStartquiz($id)
    {


       
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }

            



        if(isset($_POST['action'])) {
            $params=Yii::$app->request->post();
            if (($key = array_search('submit', $params)) !== false) {
                unset($params[$key]); 
            }
            $correct=0;
            $user_id=Yii::$app->user->identity->id;
            if (count($params)>=1) {
                foreach ($params as $key=>$rec){
                    echo $key.'='.$rec;
                    echo $pos=strripos($key,'_',0);
                    $questionNo= substr($key,$pos+1);
                    $model = Questions::find()->where(['testId'=>$id,'sequenceNo'=>$questionNo])->asArray()->one();
                    $ansArray=explode('||',$model['choice']);
                    $answer=$ansArray[$rec];
                    // echo 'user answer='.$answer."& Correct Answer=".$model['answer'];
                    echo $correctness=(strcmp($answer,$model['answer']))?0:1;
                    $model=new QuizAnswers();
                    $model->userId=$user_id;
                    $model->testId=$id;
                    $model->questionId=$questionNo;
                    $model->answer=$answer;
                    $model->correctness=$correctness;
                    $correct+=$correctness;
                    $model->IP=Yii::$app->request->getUserIP();
                    $model->save(false);
                }
            }
            //sumbit assign quiz
            $qDesc=QuizDescription::find()->where(['id'=>$id])->asArray()->one();
            $noOfQuestions=$qDesc['noOfQuestion'];
            $passRate=$qDesc['passRate'];
            $qAssign=QuizAssign::findOne(['user_id'=>$user_id,'quiz_id'=>$id]); //->where(['user_id'=>$user_id,'quiz_id'=>$id]);
            //$qAssign->user_id=Yii::$app->user->identity->id;
            //$qAssign->quiz_id=$id;
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $qAssign->completed_date=date("Y-m-d h:i:s");
            $score=$correct/$noOfQuestions*100;
            $qAssign->score=$score;
            if($score>=$passRate)
                $results='PASS';
            else $results='FAILED';
            $qAssign->results=$results;
            $qAssign->save(false);
            //return $this->redirect(['myresults']);
            $qAssign=QuizAssign::find()->where(['user_id'=>$user_id,'quiz_id'=>$id])->asArray()->one();
            $qDesc=QuizDescription::find()->where(['id'=>$id])->asArray()->one();
            $dataProvider = new ActiveDataProvider([
                'query'=>Questions::find()->where(['testId'=>$id]),
            ]);
            $dataProvider2 = new ActiveDataProvider([
                'query'=>QuizAnswers::find()->where(['testId'=>$id]),
            ]);
            return $this->render('show_myresults',[
                'quizDesc'=>$qDesc,
                'qAssign'=>$qAssign,
                'questions'=>$dataProvider,
                'answers'=>$dataProvider2,
            ]);

        }
        else{
            
                $qDesc=QuizDescription::find()->where(['id'=>$id])->asArray()->one();
                
                $dataProvider = new ActiveDataProvider([
                'query'=>Questions::find()->where(['testId'=>$id]),
                ]);
            return $this->render('startQuiz',[
                'quizDesc'=>$qDesc,
                'questions'=>$dataProvider,
            ]);
        }
    }
}
