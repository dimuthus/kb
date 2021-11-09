<?php

namespace frontend\controllers;
use frontend\models\faq\Faq;
use frontend\models\faq\Faqfav;
use frontend\models\faq\Faqfavlog;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii;

class FaqController extends \yii\web\Controller
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
                    if (!Yii::$app->user->can('FAQ Page'))
                        throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                    return true;
                    }

                    ],
                ],
            ]
        ];
    }
    public function actionIndex()
    {   

        
            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        
        $faqData = new ActiveDataProvider([
            'query' => Faq::find()->orderBy('category_name'),
        ]);
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,3);
        return $this->render('index',
                [
                    'faqData'=>$faqData->getModels(),
                ]);
    }
    
    //--------------------------- FAQ Favourite Save Start ---------------------------------------
    
	public function actionSave_fav() {
		
		if(Yii::$app->user->identity->firsttime==0){

			return $this->redirect(['user/changepassword']);

		}

        $model = new Faqfav;
        $request = Yii::$app->request;
        
        $faq_id = $_POST['faq_id'];
        $user_id = $_POST['user_id'];
        $opt = $_POST['opt'];
		
		//echo $faq_id."<br/>";
		//echo $user_id."<br/>";
		//echo $opt."<br/>";
        
        $exist = $this->isAlreadyExist($faq_id,$user_id);
			if (!$exist) {// Insert Favourite

				$model->faq_id = $faq_id;
				$model->user_id = $user_id;
				$model->isfavourite = $opt;
				//var_dump($model);
				//die();
				$model->save(false);
				//var_dump($model);
				
				$model_log = new Faqfavlog;
				$model_log->faq_id = $faq_id;
				$model_log->user_id = $user_id;
				$model_log->isfavourite = $opt;
				$model_log->action="INSERT";
				$model_log->save(false);

			}
        
			else {// Update Favourite
				//var_dump("fgfgfg");
				//echo "exist !";
				$fav_fetch = Faqfav::findOne($exist);
                $fav_ids= $fav_fetch->id;
				//var_dump($fav_ids)."<br/>";
				
				$querybegin= "update faq_favourite set ".
                             "isfavourite = '$opt' ".
                             "where user_id='$user_id' and id = '$fav_ids'; ";
                $distresult=Yii::$app->db->createCommand($querybegin)->execute();
                
                
                $model_log = new Faqfavlog;
                $model_log->ref_id = $fav_ids;
				$model_log->faq_id = $faq_id;
				$model_log->user_id = $user_id;
				$model_log->isfavourite = $opt;
				$model_log->action="UPDATE";
				$model_log->save(false);
			}

        return $this->redirect(['faq/']);
    }
    //--------------------------- FAQ Favourite Save Ends ---------------------------------------
    
    //--------------------------- Check FAQ Exist Start -----------------------------------------
    
   protected function isAlreadyExist($faq_id,$user_id) {
       $connection = Yii::$app->getDb();
       $command = $connection->createCommand("
         SELECT  id,faq_id,user_id
         FROM faq_favourite
         WHERE faq_id = '$faq_id' AND user_id = '$user_id' ");

       $result = $command->queryAll();
       if (count($result) > 0) {
		
			foreach ($result as $modelData) {
				if ($user_id != "" ||$user_id != NULL ){
					if ($user_id == $modelData['user_id']) {
						return $modelData['id'];
					}
				}
				else {			 
				}
			}
			 return true;
       } 
       else {
		return false;
		}
   }
    
    //--------------------------- Check FAQ Exist Ends -----------------------------------------
   
}
