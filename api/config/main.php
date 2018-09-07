<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => [
        'log',
        //全局内容协商
        [
            //ContentNegotiator 类可以分析request的header然后指派所需的响应格式给客户端，不需要我们人工指定
            'class'     => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => yii\web\Response::FORMAT_JSON,
                //  'application/xml' => yii\web\Response::FORMAT_XML,
            ],
        ]
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'controllerMap'=>[
                'assignment'=>[
                    'class'=>'mdm\admin\controllers\AssignmentController',
                    'usernameField'=>'username',
                    'searchClass'=>'api\models\AdminUserSearch'
                ],
            ]
        ],

        'website' => [
            'class' => 'api\modules\website\Module'
        ],

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'admin/*',
            'order-dictionary/*',
            //'*'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\models\AdminUser',
            'enableAutoLogin' => true,
            'enableSession' => false,
           // 'identityCookie' => ['name' => '_identity-backend'],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
    // RUANXINWU
                $response = $event->sender;
                if(!$response->isSuccessful){

                    $data=[];
                    $data['code']=\api\exceptions\ApiException::ERROR;
                    $data['msg']=\api\exceptions\ApiException::$errorMessage[\api\exceptions\ApiException::ERROR];
                    PD($response->data);
                    if(YII_ENV=='prod'){//正式环境
                        $data['data']=new \stdClass();
                    }else{
                        $data['data']=$response->data;
                    }

                    $response->data=$data;
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,      // 美化URL
            'enableStrictParsing' => true,  //启用严格解析,ture启用，启用后下面的rules是规则
            'showScriptName' => true,      // 隐藏index.php
           // 'suffix' => '.htmjl',            // 设置后缀.html
            'rules' => [
                'GET post' => 'post/index',    // GET 表示只能是GET传送

                'post/searchAbc' => 'post/search-abc', // 表示什么类型传送都可以

                'POST site/login' => 'site/login', // POST 表示只能是POST传送
                //'POST site'

                'GET orderDictionary/index' => 'order-dictionary/index',
                'GET orderDictionary/single' => 'order-dictionary/single-order-dictionary',
                'POST orderDictionary/add' => 'order-dictionary/add',
                // Channel admin
                'POST addChannel' => 'channel-source/add-channel',

                // admin_user
                'POST adminUser/addUser' => 'admin-user/add-user',

                //
                'GET website/Plan' => 'website/plan/index'
            ],
        ],

//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                'system'=>[
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                    'logFile'=>'@runtime/logs/day/'.date('Ymd').'.log',
//                    //'logVars'=>['_GET','_POST','_FILES','_COOKIE'],
//                ],
//                'test'=>[
//                    'class'=>'yii\log\FileTarget',
//                    'levels'=>['error','warning'],
//                    'categories'=>['test'],
//                    'logFile'=>'@runtime/logs/test.log',
//                    //    'logVars'=>['_GET','_POST','_FILES','_COOKIE'],
//                ]
//            ],
//
//        ],
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect'
        ],
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'gKQM9KOPziCYt7blOqKvkKMMt0gEexSQ',
        ],

    ],
    'params' => $params,
];
