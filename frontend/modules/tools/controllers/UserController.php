<?php

namespace frontend\modules\tools\controllers;

use Yii;
use frontend\modules\tools\models\user\User;
use mdm\admin\models\searchs\AuthItem as AuthItemSearch;
use yii\rbac\Item;
use mdm\admin\models\AuthItem;
use frontend\modules\tools\models\user\UserTeam;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update','resetpassword','role'],
                'rules' => [
                    [
                       'actions' => ['index', 'view'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->can('User Management'))
                                throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                            return true;
                        }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                             if(!Yii::$app->user->can('User Management'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                             if(!Yii::$app->user->can('Create User'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                             return true;
                         }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                             if(!Yii::$app->user->can('User Management'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                             if(!Yii::$app->user->can('Update User'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                             return true;
                         }
                    ],
                    [
                        'actions' => ['resetpassword'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                             if(!Yii::$app->user->can('User Management'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationErrorAction']);
                             if(!Yii::$app->user->can('Reset User Password'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationErrorAction']);
                             return true;
                         }
                    ],
                    [
                        'actions' => ['role'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                             if(!Yii::$app->user->can('Role Management'))
                                 throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
                             return true;
                         }
                    ],
               ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }



        $dataProvider = new ActiveDataProvider([
            'pagination' => array('pageSize' => 10),
            'query' => User::find()
            ->joinWith('status'),
            //->where('user.role_id != :role_id', ['role_id'=>'Admin']),
            'sort' => ['attributes' => [
                    'username',
                    'email',
                    'full_name' => [
                        'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                        'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                    'status.name' => [
                        'asc' => ['user_status.name' => SORT_ASC],
                        'desc' => ['user_status.name' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                    'role.name'
                ]
            ]
        ]);
        $click = new \frontend\controllers\ClicksController; $click->saveClick(Yii::$app->controller->id,71);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //if($id == 1)
        //    throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }


        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }



        $model = new User();
        $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = Yii::$app->user->identity->id;
            if($model->save()) {
                try {
                    $manager = Yii::$app->authManager;
                    $item = $manager->getRole($model->role_id);
                    $item = $item ? : $manager->getPermission($model->role_id);
                    $manager->assign($item, $model->id);
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                    return $this->render('create', [
                        'model' => $model,
                        'error' => $error
                    ]);
                }
            }
            else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            $model->status_id = 1;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       // if($id == 1)
         //   throw new ForbiddenHttpException(Yii::$app->params['authorizationError']);
        
       
        if(Yii::$app->user->identity->firsttime==0){

                        return $this->redirect(['//user/changepassword']);

                    }



        $model = $this->findModel($id);
        $role = $model->role_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->role_id != $role) {
                try {
                    $manager = Yii::$app->authManager;
                    $item = $manager->getRole($role);
                    $item = $item ? : $manager->getPermission($role);
                    $manager->revoke($item, $model->id);

                    $item = $manager->getRole($model->role_id);
                    $item = $item ? : $manager->getPermission($model->role_id);
                    $manager->assign($item, $model->id);

                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                    return $this->render('update', [
                        'model' => $model,
                        'error' => $error
                    ]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If reset password is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionResetpassword($id)
    {



        // if(Yii::$app->user->identity->firsttime==0){

        //                 return $this->redirect(['//user/changepassword']);

        //             }





        $model = $this->findModel($id);
        $model->scenario = 'resetpassword';
        $model->firsttime=0;
        
        $model->password_hash = $model->default_password; 
        $click = new \frontend\controllers\ClicksController; $click->saveClick('password',74);
        if ($model->save()) {
            return $this->redirect(['view', 'id'=>$id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionRole()
    {



        // if(Yii::$app->user->identity->firsttime==0){

        //                 return $this->redirect(['//user/changepassword']);

        //             }


        $click = new \frontend\controllers\ClicksController; $click->saveClick('role',72);
        if (Yii::$app->request->post('hasNew')) {
            $model = new AuthItem(null);
            $model->load(Yii::$app->request->post());
            $model->type = Item::TYPE_ROLE;
            $model->ruleName = 3;

            $hasError = true;
            if($model->save()) {
                $hasError = false;
            }
            echo Json::encode(['hasError'=>$hasError]);
            return;
        }

        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $message = ''; 
            $item = Yii::$app->getAuthManager()->getRole($id);
            if ($item) {
                $model = new AuthItem($item);
                $model->name = Yii::$app->request->post('name');
                if(!$model->save()){
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
                $item = Yii::$app->getAuthManager()->getRole($id);
                if ($item) {
                    $model = new AuthItem($item);
                    $model->ruleName = ($state == 'true')?3:4;
                    if($model->save()){
                        $saved = true;
                    }
                }
                
            }
            echo Json::encode(['saved'=>$saved]);
            return;
        }

        $model = new AuthItem(null);

        $searchModel = new AuthItemSearch(['type' => Item::TYPE_ROLE]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('role', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionTeam()
    {
       
        // if(Yii::$app->user->identity->firsttime==0){

        //                 return $this->redirect(['//user/changepassword']);

        //             }


        $click = new \frontend\controllers\ClicksController; $click->saveClick('team',72);
        if (Yii::$app->request->post('hasNew')) {
            $model = new UserTeam(NULL);
            $model->load(Yii::$app->request->post());

            $hasError = true;
            if($model->save()) {
                $hasError = false;
            }
            echo Json::encode(['hasError'=>$hasError]);
            return;
        }

        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            if($id){
                $model = UserTeam::findOne($id);
                $index = Yii::$app->request->post('editableIndex');
                $model->name = Yii::$app->request->post()['UserTeam'][$index]['name'];
                $model->save();
                echo Json::encode(['output'=>'', 'message'=>'']);
                return;
            }
        }

        if (Yii::$app->request->get('hasToggle')) {
            $state = Yii::$app->request->get('state');
            $id = Yii::$app->request->get('id');
            $saved = false;
            if(isset($state) && isset($id)) {
                $model = UserTeam::findOne($id);
                $model->isactive = ($state == 'true')?1:0;
                if($model->save(false)){
                    $saved = true;
                }   
            }
             echo Json::encode(['saved'=>$saved]);
            return;
        }

        $model=new UserTeam();
        $query = UserTeam::find();

        //$searchModel = new AuthItemSearch(['type' => Item::TYPE_ROLE]);
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        //$dataProvider->pagination = ['pageSize' => 10];

        return $this->render('team', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
