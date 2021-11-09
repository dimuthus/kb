<?php

namespace frontend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use frontend\models\forum\Forum;
use frontend\models\forum\ForumReplies;

class ForumController extends \yii\web\Controller
{
    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Forum Page'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Forum Page'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Create Discussion'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Update Discussion'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                }
                    ],
                            [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if (!Yii::$app->user->can('Delete Discussion'))
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



        $query = Forum::find()
            ->where('forum_topics.is_deleted != 1')
            ->joinWith('forumReplies')
                ->joinWith('user')
            ->orderBy('forum_topics.created_date DESC');
            
        //if(!Yii::$app->user->can('View Service Reuqests Created by All Agents'))
            //$query->andFilterWhere(['service_request.created_by'=> Yii::$app->user->identity->id]);
//var_dump($query); die();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          
        ]);
    //Decrypt Data for Customer Full Name
//        foreach ($dataProvider->models as $key => $model) {      
//            $model['customer']->full_name=$this->decryptString($model['customer']->full_name);
//        }
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,4);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        return $this->render('viewReplies', [
            'allReplies' => forumReplies::find()->where(['forum_replies.topic_id'=>$id,'is_deleted'=>0])
             ->joinWith('user')->asArray()->all(),
            'topic'=>Forum::find()->where(['id'=>$id])->asArray()->one(),
        ]);
    }
    public function actionCreate()
    {  


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }





        if (Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $params = $request->bodyParams;
            $title = $request->getBodyParam('forum-topic');
            $details = $request->getBodyParam('forum-text');
            $model = new Forum;
           // echo  $details;
           // echo $title;
            $model->createdby = Yii::$app->user->identity->id;
            $model->title=$title;
            $model->details=$details;
            //var_dump($model); die();
            $model->save();
            return $this->redirect(['index']);
        }
        else{
            $model= new Forum;
            return $this->render('newTopic', [
                'model' => $model, 
            ]);
        }
        return;
    }
     public function actionDelete($id)
    {  

            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }

        $model =Forum::findOne($id);
        $model->setAttributes(['is_deleted'=>1],true);
        $model->save(false);
        return $this->redirect(['index']);
    }

    public function actionSavereply($id)
    {

            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $param = $request->getBodyParam('text');
        $fReplies = new ForumReplies;
        $fReplies->user_id = Yii::$app->user->identity->id;
        $fReplies->topic_id=$id;
        $fReplies->message =$param; 
		$fReplies->save();
        return $this->redirect(['view', 'id' => $id]);
    }
    
    public function actionEditreply($id)
    {


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



         if (Yii::$app->request->post()) {

            $model =ForumReplies::findOne($id); 
            $message = Yii::$app->request->getBodyParam('forum-reply-text');
            $post=[];
            $post['message']=$message;
            $model->setAttributes($post,true);
			
            if($message) $model->save(false);
            return $this->redirect(['view', 'id' => $model->topic_id]);
        }
        else{
            $model =ForumReplies::findOne($id);
            return $this->render('editReply', [
                'model' => $model, 
            ]);
        }
        return;

    }
    public function actionDeletereply($id)
    {

        
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }
        

        
        $model =ForumReplies::findOne($id);
        $model->setAttributes(['is_deleted'=>1],true);
        //var_dump($model); die();
        $model->save(false);
        return $this->redirect(['view', 'id' => $model->topic_id]);
    }
}
