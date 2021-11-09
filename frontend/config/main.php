<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'BOC KB',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
	
	    'request' => [
                'baseUrl' => '/bockb',
                'enableCsrfValidation' => false,
        ],
            'assetManager' => [
            'bundles' => [
            'yii\web\JqueryAsset' => [
               'js'=>[]
                ],
            ],
        ], 
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
             'baseUrl' => '/bockb',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
                'tools/<controller:\w+>/<id:\d+>' => 'tools/<controller>/view',
                'tools/<controller:\w+>/<action:\w+>/<id:\d+>' => 'tools/<controller>/<action>',
                'tools/<controller:\w+>/<action:\w+>' => 'tools/<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //'<controller:\w+>/<action:\w+>/<id:\d+>/<user_id:\d+>' => '<controller>/<action>',
                
            ),
        ],

		'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'session' => [
       'class' => 'yii\web\Session',
        // 'timeout'=>20,    
       ],
    
		
		
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => ['user/login'],  
            // 'authTimeout' => 30,
        ],
		
		'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', // add or remove allowed actions to this list
			'customer/*', // add or remove allowed actions to this list
        ]
		],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],	
    ],
    'modules' => [
        'tools' => [
            'class' => 'frontend\modules\tools\Tools',        
        ],
        'treemanager' =>  [
        'class' => '\kartik\tree\Module',
        //'creocoder\nestedsets\NestedSetsQueryBehavior',
       // 'class'=>'vendor\kartik-v\yii2-tree-manager\TreeViewInput';
        // other module settings, refer detailed documentation
    ]
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [

                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
