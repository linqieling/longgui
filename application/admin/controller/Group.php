<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\model\Menu;
use app\common\model\Seller;
use app\common\model\SellerGroup;
use app\common\model\SellerMenu;
use app\common\model\Addons;
use app\common\model\Area;
use app\common\model\AskCategory;
use rhe\Authtree;
use think\Db;
use think\facade\Request;
use think\Validate;
use app\common\model\MpFriends;
use think\Loader;

class Group extends Base
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }
    
    public function init()
    {
        $this->redirect('admin/group/index');
    }

    /**
     *  会员组列表
     * @param string $type
     * @return \think\response\View
     */
    public function index($type = '')
    {
        $group_model =new \app\common\model\Group();
        $group_list = $group_model->order('id DESC')->paginate(20,false,
            ['query'=>array()

            ]);
        if(is_object($group_list) ){
            foreach ($group_list as $key=>$val){
                if($val['status'] ==1){
                    $group_list[$key]['status_name'] ='<span style="color: seagreen;font-size: 18px;"><strong>√</strong></span>';
                }else{
                    $group_list[$key]['status_name'] ='<span style="color: darkslategray;font-size: 18px;"><strong>×</strong></span>';
                }
            }
        }
        $this->assign('group_list', $group_list);
        $this->assign('menu_title','管理员分组列表');
        return view();
    }

    /**
     * 单条数据删除
     */
    public function del(){
        $id =!empty($_REQUEST['id'])?intval($_REQUEST['id']):0;
        $group_model =new \app\common\model\Group();
        $op_info =$group_model->where(['id'=>$id])->find();
        if(!$op_info){
            ajaxMsg(0,'没有找到数据，操作失败');
        }
        if($op_info['is_sys'] ==1){
            ajaxMsg(0,'系统分组不用删除');
        }
        $group_model->where(['id'=>$id])->delete();
        ajaxMsg(1,'操作成功');
    }

    /**
     * 添加用户组
     * @return \think\response\View
     */
    public function add(){
        $group_model =new \app\common\model\Group();
        if(Request::isAjax()){
            $table_data=array();
            $table_data['name'] =!empty($_REQUEST['name'])?trim($_REQUEST['name']):'';
            $table_data['mpnum'] =!empty($_REQUEST['mpnum'])?intval($_REQUEST['mpnum']):1;
            $table_data['xcxnum'] =!empty($_REQUEST['xcxnum'])?intval($_REQUEST['xcxnum']):1;
            $table_data['status'] =isset($_REQUEST['status'])?intval($_REQUEST['status']):0;
            $limits =!empty($_REQUEST['authids'])?$_REQUEST['authids']:'';
            $table_data['ico'] =!empty($_REQUEST['ico'])?$_REQUEST['ico']:'';
            if($table_data['name'] ==''){
                ajaxMsg(0,'用户组名不能为空');
            }
            if(isset($table_data['ico']) && $table_data['ico']!=''){
                $table_data['ico'] =str_replace("\\","/",$table_data['ico']);
            }

            //$table_data['limits'] = implode(",", $limits);
            $table_data['limits'] = $limits;
            $info =$group_model->insert($table_data);
            if($info){
                ajaxMsg(1,'操作成功');
            }else{
                ajaxMsg(0,'操作失败');
            }
        }else{
            return view();
        }
    }
    /**
     * 修改用户组
     * @return \think\response\View
     */
    public function update($id =0){
        $group_model =new \app\common\model\Group();
        $group_info =$group_model->where('id',$id)->find();
        if(Request::isAjax()){
            if(!$group_info){
                ajaxMsg(0,'数据有问题');
            }
            $table_data=array();
            $table_data['name'] =!empty($_REQUEST['name'])?trim($_REQUEST['name']):'';
            $table_data['mpnum'] =!empty($_REQUEST['mpnum'])?intval($_REQUEST['mpnum']):1;
            $table_data['xcxnum'] =!empty($_REQUEST['xcxnum'])?intval($_REQUEST['xcxnum']):1;
            $table_data['status'] =isset($_REQUEST['status'])?intval($_REQUEST['status']):0;
            $limits =!empty($_REQUEST['authids'])?$_REQUEST['authids']:'';
            $table_data['ico'] =!empty($_REQUEST['ico'])?$_REQUEST['ico']:'';
            $id =!empty($_REQUEST['id'])?intval($_REQUEST['id']):0;
            if($table_data['name'] ==''){
                ajaxMsg(0,'用户组名不能为空');
            }
            if(isset($table_data['ico']) && $table_data['ico']!=''){
                $table_data['ico'] =str_replace("\\","/",$table_data['ico']);
            }
            //$table_data['limits'] = implode(",", $limits);
            $table_data['limits'] =  $limits;

            $info =$group_model->where('id',$id)->update($table_data);
            if($info){
                ajaxMsg(1,'操作成功');
            }else{
                ajaxMsg(0,'操作失败');
            }

        }else{
            if(!$group_info){
                $this->redirect(url('admin/group/index'));
            }
            $this->assign('id', $id);
            $this->assign('group_info', $group_info);
            $this->assign('menu_title','修改管理组');
            return view();
        }

    }

    /**
     * 返回权限数据
     */
    public function auth_tree(){
        $id =!empty($_REQUEST['id'])?intval($_REQUEST['id']):0;
        $group_model =new \app\common\model\Group();
        $auth_ids ='';
        $auth_ids_arr =array();

        if($id>0){
            $auth_ids_info =$group_model->where('id',$id)->find();
            if($auth_ids_info){
                $auth_ids=$auth_ids_info['limits'];
                $auth_ids_arr =explode(',', $auth_ids);
            }
        }
        $group_menu = new Menu();
        $menu_list =$group_menu->field('id,pid,name')->order('sort ASC')->select()->toArray();
        $auth_tree = new Authtree();
        $auth_tree->init($menu_list);
        $tree_list =$auth_tree->getTreeArray($menu_list,$auth_ids_arr);
        $data['code']=0;
        $data['msg']="获取成功";
        $data['data']['trees'] =$tree_list;
        echo json_encode($data);
        exit;
    }

}
