<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use frontend\models\feedback\Feedback;
use frontend\models\feedback\FeedbackReplies;

use yii;

class FeedbackController extends \yii\web\Controller
{
     public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view', 'update','delete','create'],
                'rules' => [
                    
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Feedbacks Page'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                            [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Feedbacks Page'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Create Feedback'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Update Feedback'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                            [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Delete Feedback'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        $user_id=Yii::$app->user->identity->id;
        if(Yii::$app->user->identity->role_id=='Admin')
         $dataProvider = new ActiveDataProvider([
            'query' => Feedback::find()->where(['is_deleted'=>0]),
             ]);
        else
            $dataProvider = new ActiveDataProvider([
            'query' => Feedback::find()->where(['is_deleted'=>0,'user_id'=>$user_id]),
             ]);
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,6);
        return $this->render('index',[
           'feedbackList' =>$dataProvider,
        ]);
    }
    
    public function actionView($id)
    {       


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




        $dataProvider1 = new ActiveDataProvider([
            'query' => Feedback::find()->where(['id'=>$id,'is_deleted'=>0]),
            ]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => FeedbackReplies::find()->where(['feedback_id'=>$id,'is_deleted'=>0])->joinWith('user'),
             ]);
        return $this->render('index',[
            'feedbackList'=>$dataProvider1,
           'feedbackDetails' =>$dataProvider2,
        ]);
    }
    public function actionViewreplies($id)
    {       




            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }





        $dataProvider1 = new ActiveDataProvider([
            'query' => FeedbackReplies::find()->where(['feedback_id'=>$id,'is_deleted'=>0]),
             ]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => Feedback::find()->where(['id'=>$id,'is_deleted'=>0]),
            ]);
        return $this->render('index',[
            'feedback'=>$dataProvider1,
           'feedbackDetails' =>$dataProvider2,
        ]);
    }
    public function actionSave($id)       
    {   



            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }





        $model=new FeedbackReplies();        
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $param = $request->getBodyParam('feedback-reply-text');
        $model->user_id = Yii::$app->user->identity->id;
        $model->feedback_id=$id;
        $model->reply=$param;
        $model->save();
        return $this->redirect(['view','id'=>$id]);
    }
    public function actionDelete($id)
    {  

        
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }
            



        $model =Feedback::findOne($id);
        $model->setAttributes(['is_deleted'=>1],true);
        $model->save(false);
        return $this->redirect(['index']);
    }  

}
