<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:35
 */
return [
    'SUCCESS' => 200, 'AUTHENTICATION_FAILURE' => 401,
    'ERROR'         => 400,
    'FORBIDDEN'     => 403,
    'FAIL'          => 500,

    //    0=> 待付款，1=>待发货，2=> 待收货, 3=>已收货

    'ORDER_STATUS_NOT_PAYMENT' => 0, // 待付款
    'ORDER_STATUS_DELIVERY' => 1,    // 待发货
    'ORDER_STATUS_DISPATCHED' => 2,  // 待收货
    'ORDER_STATUS_SUCCESS' => 3,     // 收货成功

    'RED_EXPIRE' => 1,   // 红包过期
    'RED_NOT_EXPIRE' => 0, // 红包未过期

    'RED_PUBLISH' => 1, // 发布红包
    'RED_NOT_PUBLISH' => 0, // 不发布红包

    'RED_RECEIVE' => 1,  // 已领取红包
    'RED_NOT_RECEIVE' => 0, // 未领取红包

    'INVATE_CODE_LENGTH' => 6,
    'ORDER_NUMBER_LENGTH' => 12,  // 订单号长度
    'GOODS_PUBLISH' => 1, // 发布商品
    'GOODS_NOT_PUBLISH' => 0, // 不发布商品

    'USE_RED_PACKET' => 1, // 使用红包
    'NOT_RED_PACKET' => 0, // 不适用红包

    'ONLINE_PAY'    => 1, // 在线支付
    'UNDER_LINE_PAY' => 0, // 货到付款

    'MARKET_MONEY_PERCENT' => 'marker_money_percent', // 销售工资百分比键
    'MARKET_MONEY_PERCENT_VALUE' => 0.02,  // 销售工资百分比值

    'ORDER_AUTO_EXPIRE' => 'order_auto_expire', // 订单自动失效键
    'ORDER_AUTO_EXPIRE_VALUE' => 60*10,  // 订单自动失效值

    'ORDER_AUTO_SUCCESS' => 'order_auto_success', // 订单自动收货键
    'ORDER_AUTO_SUCCESS_VALUE' => 60*60*8,  // 订单自动收货值

    'SERVICE_CENTER' => "service_center",   // 服务中心键
    'SERVICE_CENTER_VALUE' => "这是一篇文章...", // 服务中心值

    'CONTACT_INFORMATION' => 'contact_information', // 联系方式键

    'CONTACT_INFORMATION_VALUE' => '我们公司的联系方式为xxxxxxxxxxxxx', // 联系方式值

    'UPLOAD_SIZE_KEY' => "UPLOAD_SIZE", // 最大上传图片大小

    "MARKET" => "market",

    'PAY_COMPLITE' => 1, // 支付完成
    'NOT_PAY'       => 0, // 未支付
    'UNDER_LINE_PAY_STATUS' => 2, // 货到付款
    'LOST_PAY'      => 3,  // 订单失效

    'RANDOM_LENGTH' => 6,               // 生成验证码的长度

    'CODE_TYPE' => 1,                   // 1代表发送邮箱注册验证码

    'ANNOUNCEMENT_DATA_TYPE_FRONTEND' => "FRONT",
    'ANNOUNCEMENT_DATA_TYPE_BACKEND'  => "BACK",

    'PERMISSION_ALL'    => 'all',

    'TIME_OUT'  => 10,
    'PLAYER' => 'player',

    'DEFAULT_PASSWORD' => 123456,

    'WECHAT_REDIRECT' => "http://814d1029.ngrok.io/enet/enet/public/index.php/getCode",
    'REDIRECT_REGISTER' => config('app.url') .  "/front/index.html#/login",
    'HOME_PAGE' => config('app.url') . "/front/index.html#/",

];
