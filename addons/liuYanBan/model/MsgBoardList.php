<?php
/**
 * User: Lance lance@huidin.com
 * Date: 2021/01/06
 * Time: 14:52 中国·广州
 */

namespace addons\liuYanBan\model;


use think\Model;

class MsgBoardList extends Model
{

    public function getMsgBoardList($where=[],$order='mb_id DESC',$row=10){
       return $this->where($where)
            ->order($order)
            ->paginate($row);
    }
}