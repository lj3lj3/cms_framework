<?php
require 'BaseModel.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/29
 * Time: 16:44
 */
class WxpayResult extends BaseModel
{
    const TABLE_NAME = 't_wxpay_result';

    // columns of this table
    const C_OUT_TRADE_NO = 'out_trade_no';
    const C_RETURN_CODE = 'return_code';
    const C_RETURN_MSG = 'return_msg';
    const C_DEVICE_INFO = 'device_info';
    const C_RESULT_CODE = 'result_code';
    const C_ERR_CODE = 'err_code';
    const C_OPENID = 'openid';
    const C_TOTAL_FEE = 'total_fee';
    const C_TRANSACTION_ID = 'transaction_id';
    const C_TIME_END = 'time_end';

//    protected $keyAndValue = array();

    public static function newInstance()
    {
        return new self();
    }

    public function __construct()
    {
        // 服务器返回的参数列表较多，这里只存放需要的数据
        $this->keyAndValue = array(
            self::C_OUT_TRADE_NO => '',
            self::C_RETURN_CODE => '',
            self::C_RETURN_MSG => '',
            self::C_DEVICE_INFO => '',
            self::C_RESULT_CODE => '',
            self::C_ERR_CODE => '',
            self::C_OPENID => '',
            self::C_TOTAL_FEE => '',
            self::C_TRANSACTION_ID => '',
            self::C_TIME_END => '',
        );

        $this->tableName = self::TABLE_NAME;
        parent::__construct();
    }

    public function insert($data)
    {
        foreach ($this->keyAndValue as $key => $value) {
            if (array_key_exists($key, $data)) {
                $this->keyAndValue[$key] = $data[$key];
            }
        }

        // Just for time
        // 默认取当前服务器时间 如果返回结果中存在时间参数 则时间返回结果中的时间
        $timestamp = time();
        if (array_key_exists(self::C_TIME_END, $data)) {
//            $timeBeforeFormat = $data[self::C_TIME_END];
            $timestamp = strtotime($data[self::C_TIME_END]);
//            $this->keyAndValue[self::C_TIME_END] = date("Y-m-d H:i:s", strtotime(data[self::C_TIME_END]));
        }
        $this->keyAndValue[self::C_TIME_END] = date("Y-m-d H:i:s", $timestamp);

        /*$this->keyAndValue = array(
            self::C_OUT_TRADE_NO => $data[self::C_OUT_TRADE_NO],
            self::C_RETURN_CODE => $data[self::C_RETURN_CODE],
            self::C_RETURN_MSG => $data[self::C_RETURN_MSG],
            self::C_DEVICE_INFO => $data[self::C_DEVICE_INFO],
            self::C_RESULT_CODE => $data[self::C_RESULT_CODE],
            self::C_ERR_CODE => $data[self::C_ERR_CODE],
            self::C_OPENID => $data[self::C_OPENID],
            self::C_TOTAL_FEE => $data[self::C_TOTAL_FEE],
            self::C_TRANSACTION_ID => $data[self::C_TRANSACTION_ID],
            self::C_TIME_END => $data[self::C_TIME_END],
        );*/

        return $this->doInsert();
    }

}