<?php
namespace frontend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
use frontend\models\documents\Documents;
use frontend\models\documents\DocumentsSearch;
use frontend\models\documents\DocCategory;
use frontend\models\documents\DocAckn;
use frontend\models\documents\DocFeedback;
use frontend\models\documents\DocumentsRating;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class DocumentsController extends Controller
{

    public function behaviors()
    {

        return ['access' => ['class' => AccessControl::className() , 'only' => ['view', 'update', 'delete', 'create'], 'rules' => [['actions' => ['view'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function ($rule, $action)
        {
            if (!Yii::$app
                ->user
                ->can('Documents Page')) throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
            return true;
        }
        ], ['actions' => ['create'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function ($rule, $action)
        {
            if (!Yii::$app
                ->user
                ->can('Create Document')) throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
            return true;
        }
        ], ['actions' => ['update'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function ($rule, $action)
        {
            if (!Yii::$app
                ->user
                ->can('Update Document')) throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
            return true;
        }
        ], ['actions' => ['delete'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function ($rule, $action)
        {
            if (!Yii::$app
                ->user
                ->can('Delete Document')) throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
            return true;
        }
        ], ], ],
        // 'verbs' => [
        // 'class' => VerbFilter::className(),
        // 'actions' => [
        // 'delete' => ['post'],
        // ],
        // ],
        ];
    }

    /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionIndex()
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {
            return $this->redirect(['user/changepassword']);
        }
        $searchModel = new DocumentsSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];
        $click = new ClicksController;
        $click->saveClick(Yii::$app
            ->controller->id, 2);

        $connection = Yii::$app->getDb();
        $qry = "SELECT doc_category.id,doc_category.`name` FROM documents LEFT OUTER JOIN  doc_category ON documents.category_id=doc_category.id WHERE doc_category.deleted=0 ";
        //echo $qry."</br>";
        $command = $connection->createCommand($qry);
        $result = $command->queryAll();
        $docCategory = "";
        if (count($result) > 0)
        {
            $i = 0;
            $x = "";
            foreach ($result as $modelData)
            {
                $i++;
                $dt = $this->drowDocTable($modelData['id']);
                if (($i % 3) == 0)
                {
                    $x .= '<div class="col-sm-4"><div class="tile orange"><h3 class="title">' . $modelData['name'] . '</h3><p>' . $dt . '</p></div></div>';
                }
                else
                {
                    $x .= '<div class="col-sm-4"><div class="tile orange"><h3 class="title">' . $modelData['name'] . '</h3><p>' . $dt . '</p></div></div>';

                }

            }
            $docCategory = '<div class="container bootstrap snippets bootdey"><div class="row">' . $x . '</div>';

        }

        //die();
        return $this->render('index', [
        // 'searchModel' => $searchModel,
        // 'dataProvider' => $dataProvider,
        'docCategory' => $docCategory]);
    }

    public function drowDocTable($catid)
    {
        $connection = Yii::$app->getDb();

        $qry = "SELECT id,`original_filename` FROM documents WHERE category_id=$catid  AND deleted=0";
        //echo $qry."</br>";
        $command = $connection->createCommand($qry);
        $result = $command->queryAll();
        $docCategory = "";
        $actionTh = "";
        foreach ($result as $modelData)
        {
            $original_filename = $modelData['original_filename'];
            $url = Url::to([Yii::$app
                ->controller->id . '/view', 'id' => $modelData['id']]);
            $actionTd = "";

            if (Yii::$app
                ->user
                ->can('Delete Document'))
            {
                $delUrl = Url::to([Yii::$app
                    ->controller->id . '/delete', 'id' => $modelData['id']]);
                $upUrl = Url::to([Yii::$app
                    ->controller->id . '/update', 'id' => $modelData['id']]);
                $actionTd = "<td><a href=" . $upUrl . " ><span class='glyphicon glyphicon-pencil'></span></a>
			   <a href=" . $delUrl . " ><span class='glyphicon glyphicon-trash' ></span></a></td>";
                $actionTh = "<th></th>";
            }
            // $catid
            $docCategory .= "<tr><td><a href=" . $url . " >" . $original_filename . "</a></td>" . $actionTd . "</tr>";

        }
        $tblStr = "<table class=\"mytbl\"><thead><th></th>" . $actionTh . "</thead><tbody>" . $docCategory . "</tbody></table>";
        return $tblStr;
    }

    public function actionView($id)
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        $userId = Yii::$app
            ->user
            ->identity->id;
        $click = new ClicksController;
        $click->saveClick('view', $id);
        $model = $this->findModel($id);
        $model->visited_count = $model->visited_count + 1;
        $model->save(false);
        return $this->render('view', ['model' => $this->findModel($id) , 'allDocs' => documents::find()->where('deleted != 1') , 'allCategories' => DocCategory::find()
            ->where('deleted != 1') , 'docRating' => DocumentsRating::findOne(['doc_id' => $id, 'user_id' => $userId]) , 'docAckn' => DocAckn::findOne(['doc_id' => $id, 'user_id' => $userId]) ]);
    }

    public function actionCreate()
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        $model = new Documents;
        $click = new ClicksController;
        $click->saveClick('tool', 74);
        if ($model->load(Yii::$app
            ->request
            ->post()))
        {

            $params = Yii::$app
                ->request
                ->post() ['Documents'];
            $ackn = $params['acknowledge'];
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $model->modify_date = date('Y-m-d h:i:s');
            $model->acknowledge = $ackn;
            $file = UploadedFile::getInstance($model, 'original_filename');

            if ($file)
            {
                $mystr = round(microtime(true)) . rand(1000, 9999);
                $filename = $file->name;
                $size = $file->size;
                //$filename = 'Data.'.$file->extension;
                $model->original_filename = $filename;
                $model->totalbytes = $size;
                $upload = $file->saveAs('uploads/' . $filename);
                if ($model->save())
                {
                    return $this->redirect(['index']);
                }
                else
                {
                    return $this->render('create', ['model' => $model, ]);
                }
            }
            else
            {
                if ($model->save())
                {
                    return $this->redirect(['index']);
                }
                else
                {
                    return $this->render('create', ['model' => $model, ]);
                }
            }
        }
        else
        {
            return $this->render('create', ['model' => $model, ]);
        }
    }

    public function actionUpdate($id)
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        $model = $this->findModel($id);
        if ($model->load(Yii::$app
            ->request
            ->post()))
        {

            $params = Yii::$app
                ->request
                ->post() ['Documents'];
            $ackn = $params['acknowledge'];
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $model->modify_date = date('Y-m-d h:i:s');
            $model->acknowledge = $ackn;
            $file = UploadedFile::getInstance($model, 'original_filename');
            if ($file)
            {
                $mystr = round(microtime(true)) . rand(1000, 9999);
                $filename = $file->name;
                $size = $file->size;
                //$filename = 'Data.'.$file->extension;
                $model->original_filename = $filename;
                $model->totalbytes = $size;
                $upload = $file->saveAs('uploads/' . $filename);
                if ($model->save())
                {
                    return $this->redirect(['index']);
                }
                else
                {
                    return $this->render('update', ['model' => $model, ]);
                }
            }
            else
            {
                if ($model->save())
                {
                    return $this->redirect(['index']);
                }
                else
                {
                    return $this->render('update', ['model' => $model, ]);
                }
            }
        }
        else
        {
            return $this->render('update', ['model' => $model, ]);
        }
    }

    public function actionDelete($id)
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        $model = $this->findModel($id);
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $model->modify_date = date('Y-m-d h:i:s');
        $model->deleted = 1;
        if ($model->save(false))
        {
            return $this->redirect(['index']);
        }
        return $this->redirect(['index']);
    }

    public function actionSave_doc_acknowledge($id)
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        //$model =DocAcknowledge::findOne($id);
        $ackn = new DocAckn;
        $ackn->user_id = Yii::$app
            ->user
            ->identity->id;
        $ackn->doc_id = $id;
        if ($ackn->save()) return $this->redirect(['view', 'id' => $id]);
        return;
    }

    public function actionSave_doc_rating()
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        $model = new DocumentsRating;
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        //$param = $request->getBodyParam('DocumentsRating');
        $rating = $params['docRating'];
        $id = $params['doc_id'];
        //var_dump($request->bodyParams); die();
        $model->user_id = Yii::$app
            ->user
            ->identity->id;
        $model->doc_id = $id;
        $model->rating = $rating;
        //var_dump($model); die();
        $model->save(false);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSave_doc_feedback()
    {

        if (Yii::$app
            ->user
            ->identity->firsttime == 0)
        {

            return $this->redirect(['user/changepassword']);

        }

        $model = new DocFeedback;
        //var_dump($model);  die('here');
        $id = $_POST['doc_id'];
        $docFeedback = $_POST['doc-feedback-text'];
        $model->user_id = Yii::$app
            ->user
            ->identity->id;
        $model->doc_id = $id;
        $model->feedback = $docFeedback;
        //var_dump($model); die();
        $model->save();
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Genereate the dropdown list for request detail type based on request type selected.
     * @return mixed
     */
    protected function findModel($id)
    {

        if (($model = Documents::findOne($id)) !== null)
        {
            //            $model->company_name = $model->decryptString($model->company_name);
            //            $model->full_name = $model->decryptString($model->full_name);
            //            $model->mobile_number = $model->decryptString($model->mobile_number);
            //            $model->alternate_contact_number = $model->decryptString($model->alternate_contact_number);
            //            $model->email = $model->decryptString($model->email);
            //            $model->postal_address = $model->decryptString($model->postal_address);
            //            $model->customer_id = $model->decryptString($model->customer_id);
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Return the decrypted value of the field (does NOT assign
     * the decrypted value back to the attribute)
     * @return string
     */

}

