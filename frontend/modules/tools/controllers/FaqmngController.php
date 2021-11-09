<?php

namespace frontend\modules\tools\controllers;
use Yii;
use frontend\models\faq\Faq;
use frontend\models\faq\FaqsLog;
use frontend\models\faq\FaqmngSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FaqmngController implements the CRUD actions for Faq model.
 */
class FaqmngController extends Controller
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
     * Lists all Faq models.
     * @return mixed
     */
    public function actionIndex()
    {


        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        $searchModel = new FaqmngSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $click = new \frontend\controllers\ClicksController; $click->saveClick('FAQs',76);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faq model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Faq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {


        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        $model = new Faq();
        $model->created_by=Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {



        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

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
     * Deletes an existing Faq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {



        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionUploadfaq()
    {        //die("hhh");

    
        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


    
        $userId=Yii::$app->user->identity->id;
       // $model = new Import();
        //$model3=new FaqsLog();
        $click = new \frontend\controllers\ClicksController; $click->saveClick(Yii::$app->controller->id,77);
        $model=new FaqsLog();
        if ($model->load(Yii::$app->request->post())) {
            $file_name=UploadedFile::getInstance($model, 'file_name');
            $model->file_name= $file_name;
            $model->created_by=$userId;
            
            if ( $model->file_name )
                {
                    $time = time();
                    $currentFile_name=$time. '.' . $model->file_name->extension;
                    $model->file_name->saveAs('uploads/' .$currentFile_name);
                    $model->file_name = 'uploads/' .$currentFile_name;

                    $handle = fopen($model->file_name, "r");
                    $i=0; //excape first row as headers
                    while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                    { 
                        if($i++) {
                            $model2=new Faq();
                            $model2->category_name=$fileop[0];
                            $model2->sub_category_name=$fileop[1];
                            $model2->content_qestion=$fileop[2];
                            $model2->content_answer=$fileop[3];
                            $model2->created_by=$userId;
                            $model2->save(false);
                        }
                    }
                }
            $model->file_name= $file_name;
            $model->current_fileName=$currentFile_name;
            $model->save(false);  
            return $this->redirect(['../faq/index']);                   
        }
        return $this->render('uploadfaq', [
                    'model' => $model,
        ]);             
    }

    /**
     * Finds the Faq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faq::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
