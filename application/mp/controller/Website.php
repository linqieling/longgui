<?php

namespace app\mp\controller;

use think\Db;
use think\facade\Request;
use think\Model;

class Website extends Base
{

    public function initialize()
    {
        parent::initialize();
    }

    public function categorylist(){
        $CategoryAll = Db::name('website_category')->where(['mpid' => $this->mid])->order(['sort ASC', 'id ASC'])->select();
        $CategoryList = \Tree::makeTree($CategoryAll);
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
          $CategoryAll = Db::name('website_category')->select();
          $CategoryList = \Tree::makeTree($CategoryAll);
          $this->assign('category_list', $CategoryList);

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

    public function articleList()
    {
      $size = input('size', 10);
      $article_list = Db::name('website_article')
          ->alias('a')
          ->join('website_category c','a.cid = c.id')
          ->field("a.*,c.name")
          ->order('a.id','desc')->paginate($size);
      $this->assign('articleList',$article_list);
      return view('article_list');
    }

    //上传图片
    public function uploadPicture()
    {
        if ($_FILES['file']['error'] > 0) {
            if($_FILES['file']['error'] == 1 || $_FILES['file']['error'] == 2){
                ajaxMsg(0,'上传遇到错误，上传文件的大小过大');
            }elseif ($_FILES['file']['error'] == 3){
                ajaxMsg(0,'上传遇到错误，文件只有部分被上传');
            }elseif ($_FILES['file']['error'] == 4){
                ajaxMsg(0,'上传遇到错误，没有文件被上传');
            }else{
                ajaxMsg(0,'上传遇到错误，上传文件大小为0');
            }
        }else{
            // 设置文件的保存路径
            //如果文件是中文文件名，则需要使用 iconv() 函数将文件名转换为 gbk 编码，否则将会出现乱码
            $image_name = iconv('UTF-8','gbk',basename($_FILES['file']['name']));
            $dir = 'public/static/images/'.$image_name;
            // 将用户上传的文件保存到 upload 目录中
            if (move_uploaded_file($_FILES['file']['tmp_name'],$dir)){
                $data['code'] = 0;
                $data['msg'] = '上传成功';
                $data['data']['src'] = '/'.$dir;
                $data['data']['title'] = $image_name;
                return $data;
            }
            else{
                ajaxMsg(0,'文件上传错误');
            }
        }

    }

    public function articleAdd()
    {
        if(Request::isPost()){
            $data = input('post.');
            $res['cid'] = $data['cid'];
            $res['keywords'] = $data['keywords'];
            $res['content'] = $data['content'];
            $res['dateline'] = date('Y-m-d H:i:s',time());
            if(Db::name('website_article')->insert($res)) {
                ajaxMsg(1, '增加成功');
            }else{
                ajaxMsg(0, '增加失败');
            }
        }else{
            $articleAll = Db::name('website_article')->column('id');
            $categoryAll = Db::name('website_category')
                ->where('id','NOT IN',$articleAll)
                ->select();
            $categoryList = \Tree::makeTree($categoryAll);
            $this->assign('category_list',$categoryList);
            return view('article_add');
        }

    }

    public function articleUpdate($id)
    {
        if(Request::isPost()){
            $data = input('post.');
            $res['cid'] = $data['cid'];
            $res['keywords'] = $data['keywords'];
            $res['content'] = $data['content'];
            if(Db::name('website_article')->where(['id' => $id])->update($res)) {
                ajaxMsg(1, '修改成功');
            }else{
                ajaxMsg(0, '修改失败');
            }
        }else{
            $article = Db::name('website_article')->where('id',$id)->find();
            $articleAll = Db::name('website_article')->where('id','not in',$id)->column('id');
            $categoryAll = Db::name('website_category')
                ->where('id','NOT IN',$articleAll)
                ->select();
            $categoryList = \Tree::makeTree($categoryAll);
            $this->assign('category_list',$categoryList);
            $article['content'] = html_entity_decode($article['content']);
            $this->assign('article',$article);
            return view('article_update');
        }
    }

    public function articleDel($id)
    {
        if (Request::isAjax()) {
           Db::name('website_article')->where(['id' => $id])->delete();
           ajaxMsg('1', '成功删除');
        }
    }

}