<?php

namespace addons\liuYanBan\controller;

use app\common\controller\Addon;

class Common extends Addon
{
    public $onlyWexinOpen = true;
    public $isWexinLogin = true;
    public $scope = 'snsapi_userinfo';//snsapi_base||snsapi_userinfo
    public $info;
    public $openid;
    public $userInfo;
    public $mp_config;

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $member = getMember();
        if(!$member){
            $this->wexinLogin();
        }
        $openid = getOrSetOpenid();
        $this->openid = isset($member['openid'])?$member['openid']:$openid;
        $info = getAddonInfo();
        $this->info = $info;
        $this->userInfo = $member;
        $config = getAddonInfo();
        if(isset($config['mp_config'])){
            $this->mp_config = $config['mp_config'];
        }
        $this->assign('mpInfo',getMpInfo($this->mid));
        $this->assign('info', $info['mp_config']);
        $this->assign('userinfo', $member);
    }

}