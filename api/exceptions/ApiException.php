<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2018/8/21
 * Time: 17:30
 */
namespace api\exceptions;
class ApiException extends \Exception{
    // success
    const SUCCESS = 200;

    // public errors
    const ERROR = 400;                                  // 系统异常
    const NO_AUTH = 401;                                // 未通过验证
    const NOT_FOUND = 404;                              // 页面未找到
    const UPLOAD_FILE_TYPE_ERROR = 1001;                // 上传文件类型错误
    const REQUEST_DATA_IS_EMPTY = 1002;                 // 接收数据为空
    const REQUEST_PARAMETER_ERROR = 1003;               // 请求参数错误
    const REQUEST_ACCESS_RESTRICTED = 1004;             // 访问限制

    // LOGIN errors
    const LOGIN_INVALID = 1100;                         // 登陆无效

    // order_dictionary errors
    const ORDER_DICTIONARY_LIST_NOT_EXIST = 1200;       // 订单列表不存在
    const ORDER_DICTIONARY_OPTION_FAIL = 1201;          // 订单操作失败
    const ORDER_DICTIONARY_INVALID = 1202;              // 无效订单

    // OCR errors
    const OCR_ERROR = 1300;                             // OCR识别错误

    // OSS errors
    const OSS_UPLOAD_ERROR = 1400;                      // OSS上传错误

    // Channel_source
    const CHANNEL_ADD_FAIL = 1500;                      // 渠道新增失败
    const CHANNEL_IS_NOT_EXIST = 1501;                  // 渠道不属于当前用户
    public static $errorMessage = [
        self::SUCCESS => 'success',

        self::ERROR => '系统异常',
        self::NO_AUTH => '验证未通过',
        self::NOT_FOUND => '页面未找到',
        self::UPLOAD_FILE_TYPE_ERROR => '上传文件类型错误',
        self::REQUEST_DATA_IS_EMPTY => '接收数据为空',
        self::REQUEST_PARAMETER_ERROR => '请求参数错误',
        self::REQUEST_ACCESS_RESTRICTED => '访问限制',

        self::LOGIN_INVALID => '登录无效',

        self::ORDER_DICTIONARY_LIST_NOT_EXIST => '订单列表不存在',
        self::ORDER_DICTIONARY_OPTION_FAIL => '订单操作失败!',
        self::ORDER_DICTIONARY_INVALID => '无效订单!',

        self::OCR_ERROR=>'OCR识别错误',

        self::OSS_UPLOAD_ERROR=>'OSS上传错误',

        self::CHANNEL_ADD_FAIL => '渠道新增失败!',
        self::CHANNEL_IS_NOT_EXIST => '渠道不属于当前用户',
    ];


}