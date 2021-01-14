<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------


namespace app\service\controller;


use think\Controller;
use think\facade\Request;
use think\facade\Url;

class Payment extends Controller
{
    private $paymentModel;

    public function initialize()
    {
        $this->paymentModel = new \app\common\model\Payment();
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * @param string $payment_id 定单 ID
     * @return \think\response\View
     */
    public function wxPay()
    {
        $payment_id = input('payment_id');
        if (!$payment = $this->paymentModel->getPaymentByFind(['payment_id' => $payment_id])) {
            ajaxMsg(0, '订单信息不存在');
        }
        if (Request::isPost()) {
            if ($payment['money'] < 0.09) {
                ajaxMsg(0, '金额最小为0.1元');
            } else {
                $result = wxPayByJsApi($payment_id);
                if ($result['errCode'] == 'ok') {
                    ajaxReturn(['jsApiParameters' => json_decode($result['data'], true)], 1);
                } else {
                    ajaxMsg(0, 'errMsg:' . $result['errMsg']);
                }
            }
        } else {
            $this->assign('payment', $payment);
            $this->assign('title', '微信支付');
            if(!empty($view=input('view'))){
                return view($view);
            }else{
                return view('wxpay');
            }

        }
    }

    /**
     * 退款示例
     * @param $mid
     * @param $order_number
     */
    public function refund($mid, $order_number)
    {
        if ($member = getMember()) {
            if (!$member['id'] || !$mid || !$order_number) {
                ajaxMsg(0, '参数不完整');
            }
            $where = ['member_id' => $member['id'], 'order_number' => $order_number, 'mpid' => $mid];
            if ($payment = $this->paymentModel->getPaymentByFind($where)) {
                if ($payment['refund'] == 1) {
                    ajaxMsg(0, '已申请退款');
                } elseif ($payment['refund'] == 2) {
                    ajaxMsg(0, '已经退款');
                } elseif ($payment['refund'] == 0) {
                    if ($this->paymentModel->refund($where)) {
                        ajaxMsg(1, '申请成功');
                    } else {
                        ajaxMsg(0, '操作失败');
                    }
                }
            } else {
                ajaxMsg(0, '订单不存在');
            }
        }
        ajaxMsg(0, '参数不完整');

    }

    /**
     * 订单查询示例
     * @param string $ordernumber
     *
     */
    public function queryOrderByWxpay($ordernumber = '')
    {
        $result = queryOrder($ordernumber);
        if ($result['errCode'] == 'ok') {
            ajaxMsg(1, $result['errMsg']);
        } else {
            ajaxMsg(0, $result['errMsg']);
        }
    }
}