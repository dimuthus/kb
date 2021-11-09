<?php

namespace frontend\controllers;

use Yii;
use frontend\models\home\Home;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\feedback\Feedback;

/**
 * HomeController implements the CRUD actions for Home model.
 */
class HomeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Home models.
     * @return mixed
     */
    public function actionIndex()
    {



            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        $query = new Query;
         $query->select('c.code, c.name,c.iso3,w.id,w.country_code,w.gmt')
            ->from('world_time w')
            ->join('INNER JOIN', 'countries c','w.country_code =c.code')
            ->where('c.enabled =1');
         
        $worldTime = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query = new Query;
        $query->select('d.id,d.original_filename AS file_name,d.uploaded_date, c.name')
            ->from('documents d')
            ->join('INNER JOIN', 'doc_category c','d.category_id =c.id')
            ->where('d.deleted =0')
            ->orderby('visited_count');
        
        $topDocs = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $query = new Query;
        $query->select('title,message,creation_date,updated_date')
            ->from('announcement')
            ->where('active =1')
            ->orderby('updated_date DESC');
        
        $announcement = new ActiveDataProvider([
            'query' => $query,
        ]);
        $click = new ClicksController; $click->saveClick(Yii::$app->controller->id,1);
        return $this->render('index', [
            'worldTime' => $worldTime->getModels(),
            'topDocs' => $topDocs,
            'announce' => $announcement->getModels(),
        ]);
    }

    /**
     * Displays a single Home model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }





        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Home model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {



            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




        $model = new Home();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Home model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {



            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }




        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Home model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {




            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }



        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Home model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Home the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */    
    public function actionSend_feedback()
    {  


            if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['user/changepassword']);

                    }





        $model = new Feedback;
        if (Yii::$app->request->post()) {
            $request = Yii::$app->request;
            $params = $request->bodyParams;
            $subject = $request->getBodyParam('feedback-subject');
            $content = $request->getBodyParam('feedback-content');
            $model->user_id = Yii::$app->user->identity->id;
            $model->subject=$subject;
            $model->content=$content;
            //var_dump($model); die();
            $model->save();
            return $this->redirect(['index']);
        }
        else{
            return $this->render('sendFeedback', [
                'model' => $model, 
            ]);
        }
        return;
    }
    
    protected function findModel($id)
    {
        if (($model = Home::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
