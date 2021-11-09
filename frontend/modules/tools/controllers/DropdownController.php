<?php

namespace frontend\modules\tools\controllers;

use Yii;

use frontend\modules\tools\models\user\User;
use frontend\models\Country;
use frontend\models\CountrySearch;
use frontend\models\Marquee;
use frontend\models\documents\DocCategory;
use frontend\models\documents\DocCategorySearch;

use frontend\models\quiz\QuizAssign;
use frontend\models\quiz\QuizAssignSearch;
use frontend\models\quiz\QuizDescription;


use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class DropdownController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['category','country'],
                'rules' => [
                    [
                       'actions' => ['category','country'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('Tools Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }
                    ]
               ],
            ],
        ];
    }
//============================================= BEGIN CATEGORY =============================================
    public function actionCategory()
    {


        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }




        //die('doc category');
        $click = new \frontend\controllers\ClicksController; $click->saveClick(Yii::$app->controller->id,75);
        if (Yii::$app->request->post('hasNew')) {
               
            $model = new DocCategory(null);
            $model->load(Yii::$app->request->post());
            //$model->name = Item::TYPE_ROLE;
           // $model->ruleName = 3;
           
            $hasError = true;
            if($model->save(false)) {
                $hasError = false;
            }
            echo Json::encode(['hasError'=>$hasError]);
            return;
        }

        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $index = Yii::$app->request->post('editableIndex');
            $message = ''; 
           // var_dump(Yii::$app->request->post());
           // die();
           // $item = Yii::$app->getAuthManager()->getRole($id);
            if ($id) {
                $model = DocCategory::findOne($id);
                $model->name = Yii::$app->request->post()['DocCategory'][$index]['name'];
                if(!$model->save(false)){
                    $message = ' ';
                }
            }
            echo Json::encode(['output'=>'', 'message'=>$message]);
            return;
        }

        if (Yii::$app->request->get('hasToggle')) {
            $state = Yii::$app->request->get('state');
            $id = Yii::$app->request->get('id');
            $saved = false;
            if(isset($state) && isset($id)) {
                $model = DocCategory::findOne($id);
                $model->deleted = ($state == 'true')?0:1;
                if($model->save()){
                    $saved = true;
                }   
            }
            echo Json::encode(['saved'=>$saved]);
            return;
        }

        $model = new DocCategory;
        $searchModel = new DocCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('doc_category', [
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel,
            'model' => $model
        ]);
    }
    //=======================END CATEGORY ======================================
    
    
    //======================== BEGIN QUIZ PARTICIPANTS =========================
    public function actionQuizparticipants()
    {



        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }





        //die('quiz participants');
        $model = new QuizAssign;
        if (Yii::$app->request->post('hasNew')) {
               
            $model->load(Yii::$app->request->post());
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $model->assign_date = date('Y-m-d h:i:s');
            //$model->ruleName = 3;
            $hasError = true;
            if(!$model->save(false)) {
                $hasError = false;
                echo Json::encode(['hasError'=>$hasError]);
                return;
            }
            
        }
        $userModel=ArrayHelper::map(User::find()->where('status_id !=0')->orderBy('username')->all(), 'id', 'username');
        $quizModel=ArrayHelper::map(QuizDescription::find()->orderBy('title')->all(), 'id', 'title');
        $searchModel = new QuizAssignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        $click = new \frontend\controllers\ClicksController; $click->saveClick('quiz',79);
        return $this->render('quiz_participants', [
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel,
            'model' => $model,
            'usersModel'=>$userModel,
            'quizModel'=>$quizModel,
        ]);
    }
    //=======================END QUIZ PARTICIPANTS ======================================
     public function actionQuizparticipantdelete($id)
    {



        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }





        $model = QuizAssign::findOne($id);
        $model->delete();
        $this->actionQuizparticipants();
    }

    public function actionCountry()
    {

            
        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }




         $click = new \frontend\controllers\ClicksController; $click->saveClick(Yii::$app->controller->id,711);
        if (Yii::$app->request->post('hasNew')) {
            $model = new Country();
            $model->load(Yii::$app->request->post());

            $model->created_by = Yii::$app->user->identity->id;
            $hasError = true;
            if($model->save()) {
                $hasError = false;
            }
            echo Json::encode(['hasError'=>$hasError]);
            return;
        }

        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = Country::findOne($id);
            $message = ''; 

            $post = [];
            $posted = current($_POST['Country']);
            $post['Country'] = $posted;

            if ($model->load($post)) {
                if(!$model->save())
                    $message = ' ';
            } 
            echo Json::encode(['output'=>'', 'message'=>$message]);
            return;
        }

        if (Yii::$app->request->get('hasToggle')) {
            $state = Yii::$app->request->get('state');
            $id = Yii::$app->request->get('id');
            $saved = false;
            if(isset($state) && isset($id)) {
                $model = Country::findOne($id);
                $model->enabled = ($state == 'true')?1:0;
                if($model->save()){
                    $saved = true;
                }
            }
            echo Json::encode(['saved'=>$saved]);
            return;
        }
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Country();

        return $this->render('country', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
}
