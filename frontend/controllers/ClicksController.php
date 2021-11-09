<?php
namespace frontend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\UserClicks;

/**
 * Site controller
 */
class ClicksController
    {
    /**
     * @inheritdoc
     */
        public function saveClick($link,$id){

            
            



            
        $userId = Yii::$app->user->identity->id;
        $model=new UserClicks;
        $model->user_id= $userId;
        $model->url=$link;
        $model->tab_id=$id;
        $model->save(false);
        //if(UserClicks::findOne())
        return;
    }
}