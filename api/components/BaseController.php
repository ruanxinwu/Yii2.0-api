<?php
/**
 * Created by PhpStorm.
 * User: ruanxinwu
 * Date: 2018/8/22
 * Time: 14:53
 */

namespace api\components;

use api\exceptions\ApiException;
use api\models\AdminUserToken;
use common\components\ControllerTrait;
use Yii;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use Detection\MobileDetect;
class BaseController extends Controller
{
    use ControllerTrait;
    const CLIENT_DEVICE_DESKTOP = 1;
    const CLIENT_DEVICE_IOS = 2;
    const CLIENT_DEVICE_ANDRIOD = 3;

    /**
     * 获取客户端类型 1 电脑; 2 IOS; 3 ADNRIOD
     */
    public static function getClientType()
    {
        $detect = new MobileDetect();

        if($detect->isTablet() || $detect->isMobile())
        {
            if($detect->isiOS())
            {
                return self::CLIENT_DEVICE_IOS;
            }else
            {
                return self::CLIENT_DEVICE_ANDRIOD;
            }
        }
        return self::CLIENT_DEVICE_DESKTOP;
       //var_dump($detect->isMobile(),$detect->isTablet(),$detect->isiOS(),$detect->isAndroidOS());die;
    }

    // 正常返回
    public function response($data = [],$message = 'success',$code = ApiException::SUCCESS)
    {
        return ['code' => (int)$code,'msg' => $message,'data' => ([] == $data)?(object)$data:$data];
    }

    //错误返回
    public function responseError($code, $message = '') {
        $message = empty($message) ? ApiException::$errorMessage[$code] : $message;
        return $this->response([], $message, $code);
    }
}