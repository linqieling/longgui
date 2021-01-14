<?php

namespace app\mp\controller;

use think\Db;
use think\facade\Request;

class Website extends Base
{

  public function initialize()
  {
    parent::initialize();
  }

  public function categorylist(){
    $CategoryList = Db::name('website_category')->where(['mpid' => $this->mid])->order(['sort ASC', 'id ASC'])->select();
    $this->assign('categoryList', $CategoryList);
    return view('category_list');
  }

  public function categoryadd()
  {
      if (Request::isPost()) {
          $_data = input('post.');
          unset($_data['image']);
          $_data['mpid'] = $this->mid;
          if (Db::name('website_category')->insert($_data)) {
              ajaxMsg(1, '增加成功');
          } else {
              ajaxMsg(0, '增加失败');
          }
      } else {
          return view('category_add');
      }
  }

  public function delCategory($id)
  {
      if (Request::isAjax()) {
          Db::name('website_category')->where(['id' => $id])->delete();
          ajaxMsg('1', '成功删除');
      }
  }

  public function categoryupdate($id)
  {
      if (Request::isAjax()) {
          $_data = input('post.');
          unset($_data['image']);
          Db::name('website_category')->where(['id' => $id])->update($_data);
          ajaxMsg(1, '更新成功');
      } else {
          $meu = Db::name('website_category')
              ->where(['id' => $id])->find();
          $this->assign('category', $meu);
          return view('category_update');
      }
  }

  public function updateSort()
  {
      if (Request::isAjax()) {
          $_data = input();
          foreach ($_data as $key => $val) {
              if (!empty($_V = explode('_', $key))) {
                  Db::name('website_category')->where(['id' => $_V[0]])->update(['sort' => $val]);
              }
          }
          ajaxMsg('1', '更新成功');
      }
  }

}