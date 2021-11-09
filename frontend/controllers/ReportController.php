<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\db\Query;
use yii\filters\AccessControl;
//use frontend\models\report\DailyLogins;
//use frontend\models\report\DailyLoginsSearch;
use frontend\modules\tools\models\user\User;
use frontend\models\report\DailyLogins;
use frontend\models\report\DailyLoginsSearch;
use frontend\models\report\UserClicks;
use frontend\models\report\UserClicksSearch;
use frontend\models\quiz\QuizAssign;
use frontend\models\quiz\QuizSummarySearch;
use frontend\models\quiz\QuizAnswers;
use frontend\models\documents\DocAcknowledge;
use frontend\models\documents\DocAcknowledgeSearch;
use frontend\models\documents\DocVisiting;
use frontend\models\documents\DocVisitingSearch;
use frontend\models\quiz\QuizDescription;
use yii\helpers\ArrayHelper;

class ReportController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['search', 'complete', 'summary','history'],
                'rules' => [
                    [
                       'actions' => ['complete'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('Reporting Page (Complete)'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }

                    ],
                    [
                       'actions' => ['summary'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('Reporting Page (Summary)'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }

                    ],
                    [
                       'actions' => ['history'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('Reporting Page (History)'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }

                    ],
                    [
                       'actions' => ['search'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                           return Yii::$app->request->isAjax;
                       }
                    ]
               ],
            ]
        ];
    }

    public function actionLogins()
    {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }


       // $searchModel = new ReportSearch();
        $searchModel = new DailyLoginsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        $userModel=ArrayHelper::map(User::find()->asArray()->all(), 'username', 'username');
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,8);
        return $this->render('dailylogins', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usersModel'=>$userModel,
        ]);
        
    }

    public function actionAccesslinks()
    {
        // $searchModel = new ReportSearch();
if(Yii::$app->user->identity->firsttime==0){
   return $this->redirect(['user/changepassword']);


                    }

        $searchModel = new UserClicksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        $userModel=ArrayHelper::map(User::find()->asArray()->all(), 'username', 'username');
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,8);
        return $this->render('user_clicks', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usersModel'=>$userModel,
        ]);

    }
    
     public function actionQuizsummary()
    {
        //die('quiz participants');

if(Yii::$app->user->identity->firsttime==0){

                          return $this->redirect(['user/changepassword']);

                    }

        $model = new QuizAssign;
        $userModel=ArrayHelper::map(User::find()->where('status_id !=0')->orderBy('username')->all(), 'id', 'username');
        $quizModel=ArrayHelper::map(QuizDescription::find()->orderBy('title')->all(), 'id', 'title');
        $searchModel = new QuizSummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,8);
        return $this->render('quiz_summary', [
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel,
            'model' => $model,
            'usersModel'=>$userModel,
            'quizModel'=>$quizModel,
        ]);
    }
    //=======================END QUIZ PARTICIPANTS ======================================
    public function actionQuizparticipantreset($id,$user_id)
    {     

if(Yii::$app->user->identity->firsttime==0){

   return $this->redirect(['user/changepassword']);

                    }



        $model = QuizAssign::findOne(['user_id'=>$user_id,'quiz_id'=>$id]);
        $model->assign_date=date('Y-m-d h:i:s');
        $model->completed_date=NULL;
        $model->score=NULL;
        $model->results=NULL;
        if($model->save(false))        //$model->delete();
            QuizAnswers::deleteAll(['userId'=>$user_id,'testId'=>$id]);
        $this->actionQuizsummary();
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,8);
        actionQuizsummary();
    }
    
    public function actionVisitingdocs()
    {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




        $searchModel = new DocVisitingSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,8);
        return $this->render('docs_visiting', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionAckndocs()
    {

            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




         $searchModel = new DocAcknowledgeSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,8);
        return $this->render('docs_acknowledge', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);

    }
    
}
