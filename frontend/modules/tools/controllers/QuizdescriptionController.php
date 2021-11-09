<?php

namespace frontend\modules\tools\controllers;

use Yii;
use frontend\models\quiz\QuizDescription;
use frontend\models\quiz\QuizDescriptionSearch;
use frontend\models\quiz\Questions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/**
 * QuizdescriptionController implements the CRUD actions for Quizdescription model.
 */
class QuizdescriptionController extends Controller
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
     * Lists all Quizdescription models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }



        $searchModel = new QuizDescriptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $click = new \frontend\controllers\ClicksController; $click->saveClick('quiz',78);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

public function actionUpload()
    {
		        $model = new Quizdescription();

		$file = UploadedFile::getInstance($model, 'upload');
var_dump($file);die('Tes');
            if ($file)
            {
                $mystr = round(microtime(true)) . rand(1000, 9999);
                $filename = $file->name;
                $size = $file->size;
                $upload = $file->saveAs('web/uploads/' . $filename);
              
            }
    $arr = array ('uploaded'=>true,'url'=>'http://127.0.0.1/uploaded-image.jpeg');
return json_encode($arr);
   
    }
    /**
     * Displays a single Quizdescription model.
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
     * Creates a new Quizdescription model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     *//*
    public function actionCreate()
    {
        $model = new Quizdescription();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
      * 
      */
   
    public function actionUpdate($id)
    {


        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }




        $model = $this->findModel($id);

        $userId=Yii::$app->user->identity->id;
        $click = new \frontend\controllers\ClicksController; $click->saveClick('Quiz Update',78);
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file_name');
            $time = new \DateTime('now');
            $mystr = round(microtime(true)) . rand(1000, 9999);
            $filename = "Uploaded_File_" . $mystr . "." . $file->extension;
            $upload = $file->saveAs('uploads/' . $filename);
            $model->uploaded_by=$userId;
            // print_r($upload);
            // die(21342);
            if ($upload && $model->save(false)) {

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify('uploads/' . $filename);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load('uploads/' . $filename);
                } catch (Exception $e) {
                    die('Error');
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $count = 0;
                $resultData = [];
                $Message='';
                $question = new Questions();
                $question->deleteAll(['testId'=>$id]);
                for ($row = 1; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    if ($row == 1 || $row==2) {
                        continue;
                    }
                    $question = new Questions(NULL);
                    $question->testId=$model->id;
                    $question->sequenceNo=$row-2;
                    $question->question=$rowData[0][0];
                    $question->choice=$rowData[0][1];
                    $question->answer=$rowData[0][2];
                    
                    
                    if (str_replace('"', '', $rowData[0][0]) == "" || str_replace('"', '', $rowData[0][0]) == NULL) 
                        $Message = "Wrong Data Format.";
                    if (str_replace('"', '', $rowData[0][1]) == "" || str_replace('"', '', $rowData[0][1]) == NULL) 
                        $Message = "Wrong Data Format.";
                      if (str_replace('"', '', $rowData[0][2]) == "" || str_replace('"', '', $rowData[0][2]) == NULL) 
                        $Message = "Wrong Data Format.";
                      $question->save(false);
                }
                if(!$Message)  return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);             
    }

    /**
     * Deletes an existing Quizdescription model.
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
        $question = new Questions();
        $question->deleteAll(['testId'=>$id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Quizdescription model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quizdescription the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCreate() {
        
        
        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }

        
        $userId=Yii::$app->user->identity->id;
        $click = new \frontend\controllers\ClicksController; $click->saveClick('Quiz Create',78);
        $model=new Quizdescription();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file_name');
            $time = new \DateTime('now');
            $mystr = round(microtime(true)) . rand(1000, 9999);
            $filename = "Uploaded_File_" . $mystr . "." . $file->extension;
            $upload = $file->saveAs('uploads/' . $filename);

            // print_r($upload);
            // die(21342);
            if ($upload && $model->save(false)) {

                try {
                    $inputFileType = \PHPExcel_IOFactory::identify('uploads/' . $filename);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load('uploads/' . $filename);
                } catch (Exception $e) {
                    die('Error');
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $count = 0;
                $resultData = [];
                $Message='';
                for ($row = 1; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    if ($row == 1 || $row==2) {
                        continue;
                    }
                    $question = new Questions();
                    $question->testId=$model->id;
                    $question->sequenceNo=$row-2;
                    $question->question=$rowData[0][0];
                    $question->choice=$rowData[0][1];
                    $question->answer=$rowData[0][2];
                    
                    
                    if (str_replace('"', '', $rowData[0][0]) == "" || str_replace('"', '', $rowData[0][0]) == NULL) 
                        $Message = "Wrong Data Format.";
                    if (str_replace('"', '', $rowData[0][1]) == "" || str_replace('"', '', $rowData[0][1]) == NULL) 
                        $Message = "Wrong Data Format.";
                      if (str_replace('"', '', $rowData[0][2]) == "" || str_replace('"', '', $rowData[0][2]) == NULL) 
                        $Message = "Wrong Data Format.";
                      $question->save(false);
                }
                if(!$Message)  return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);             
        
    }
    
    protected function findModel($id)
    {
        if (($model = Quizdescription::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
