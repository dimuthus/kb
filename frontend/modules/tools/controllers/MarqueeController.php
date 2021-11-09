<?php

namespace frontend\modules\tools\controllers;

use Yii;
use frontend\models\Marquee;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class MarqueeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update'],
                'rules' => [
                    [
                       'actions' => ['index'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('Marquee Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }
                    ],
                    [
                       'actions' => ['update'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                           return Yii::$app->request->isAjax && Yii::$app->request->isPost;
                       }
                    ]
                ],
                
        ],
        ];
    }

    
    public function actionIndex() {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        $model = Marquee::findOne(1);
        $click = new \frontend\controllers\ClicksController; $click->saveClick(Yii::$app->controller->id,712);
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionUpdate() {

        
        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        $model = Marquee::findOne(1);

        $hasError = true;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                $hasError = false;
            }
        } 

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['hasError'=>$hasError];
    }

}
