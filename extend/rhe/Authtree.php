<?php

namespace rhe;

use think\facade\Config;

/**
 * 通用的树型类
 * @author XiaoYao <476552238li@gmail.com>
 */
class Authtree
{

    protected static $instance;
    //默认配置
    protected $config = [];
    public $options = [];

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    public $arr = [];

    /**
     * 生成树型结构所需修饰符号，可以换成图片
     * @var array
     */
    public $icon = array('│', '├', '└');
    public $nbsp = "&nbsp;";
    public $pidname = 'pid';

    public function __construct($options = [])
    {

    }

    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return Tree
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance))
        {
            self::$instance = new static($options);
        }

        return self::$instance;
    }

    /**

     * 初始化方法

     * @param array 2维数组，例如：
     * array(
     *      1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
     *      2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
     *      3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目一'),
     *      4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目二'),
     *      5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目三'),
     *      6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目一'),
     *      7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目二')
     *      )
     */
    public function init($arr = [], $pidname = NULL, $nbsp = NULL)
    {
        $this->arr = $arr;
        if (!is_null($pidname))
            $this->pidname = $pidname;
        if (!is_null($nbsp))
            $this->nbsp = $nbsp;
        return $this;
    }



    /**

     * 读取指定节点的所有孩子节点
     * @param int $myid 节点ID
     * @param boolean $withself 是否包含自身
     * @return array
     */
    public function getChildren($myid, $edids,$withself = FALSE)
    {
        $newarr = [];
        foreach ($this->arr as $value)
        {
            if (!isset($value['id']))
                continue;
            if ($value[$this->pidname] == $myid)
            {
                $_newarr =array('name'=>$value['name'],'value'=>$value['id']) ;
                if($this->is_checked($value["id"],$edids,$withself)){
                    $_newarr['checked'] =true;
                }

                if($value['id'] == 21 || $value['id'] == 22 || $value['id'] == 24 || $value['id'] == 62 || $value['id'] == 90){
                    $_newarr['disabled'] = true;
                    $_newarr['name'] .= '(系统默认)';
                }

                $___newarr = $this->getChildren($value['id'],$edids,$withself);
                if(is_array($___newarr) && count($___newarr)>0){
                    $_newarr['list'] =$___newarr;
                }
                $newarr[] = $_newarr;
               // var_dump($_newarr);
            }
            else if ($withself && $value['id'] == $myid)
            {
                $newarr[] = array('name'=>$value['name'],'value'=>$value['id']) ;;
            }
        }
        //var_dump($newarr);
        return $newarr;
    }

    /**

     * 读取指定节点的所有孩子节点ID
     * @param int $myid 节点ID
     * @param boolean $withself 是否包含自身
     * @return array
     */
    public function getChildrens($myid, $edids,$withself = FALSE)
    {
        $childrenlist = $this->getChildren($myid, $edids,$withself);

        return $childrenlist;
    }

    /**
     *
     * 获取树状数组
     * @param string $myid 要查询的ID
     * @param string $nametpl 名称条目模板
     * @param string $itemprefix 前缀
     * @return string
     */
    public function getTreeArray($data_arr, $edids=array())
    {
        $data =array();
        if(is_array($data_arr) && count($data_arr)>0){
            foreach ($data_arr as $key => $value){
                if($value[$this->pidname] == 0){
                    $arr =array("name"=> $value["name"], "value"=> $value["id"]);
                    if($this->is_checked($value["id"],$edids)){
                        $arr['checked'] = true;
                    }
                    if($arr['value'] == 2){
                        $arr['disabled'] = true;
                        $arr['name'] .= '(系统默认)';
                    }
                    $arr['list'] =$this->getChildrens($value['id'],$edids);
                    $data[] =$arr;
                }
            }
        }
        return $data;
    }

    public function is_checked($id,$edids){
        if(in_array($id,$edids)){
            return true;
        }else{
            return false;
        }
    }
}
