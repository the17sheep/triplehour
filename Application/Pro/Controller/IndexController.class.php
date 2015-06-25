<?php
namespace Pro\Controller;
use Think\Controller;

class IndexController extends Controller
{

    public function index($page = 1, $province = '')
    { // 项目条件增加一个城市条件$province--pope
        if (! is_numeric($page))
        {
            $this->error('参数错误');
        }
        if ($_GET['keyword'])
        {
            $where['content'] = array(
                    'like',
                    "%{$_GET['keyword']}%"
            );
            $where['title'] = array(
                    'like',
                    "%{$_GET['keyword']}%"
            );
            $where['_logic'] = 'or';
            $condition['_complex'] = $where;
            $condition['type'] = 'pro';
            $this->page = M('page')->where($condition)
                ->order('id desc')
                ->page($page, mc_option('page_size'))
                ->select();
            $count = M('page')->where($condition)->count();
            $this->assign('count', $count);
            $this->assign('page_now', $page);
            $this->display('Pro/index');
        }
        elseif ($province)
        {//按省份显示项目--pope
            $condition['meta_key'] = 'pro_province';
            $condition['meta_value'] = $province;
            $condition['type'] = 'basic';
            $province_page_id = M('meta')->where($condition)->getField('page_id',true);
            
            $condition_p['id'] = array(
                    'in',
                    $province_page_id
            );
            $condition_p['type'] = 'pro';
            $this->page = M('page')->where($condition_p)
            ->order('id desc')
            ->page($page, mc_option('page_size'))
            ->select();
            $count = M('page')->where($condition_p)->count();
            $this->assign('count', $count);
            $this->assign('page_now', $page);
            $this->display('Pro/index');
        }
        else
        {
            $condition['type'] = 'pro';
            $this->page = M('page')->where($condition)
                ->order('id desc')
                ->page($page, mc_option('page_size'))
                ->select();
            $count = M('page')->where($condition)->count();
            $this->assign('count', $count);
            $this->assign('page_now', $page);
            $this->theme(mc_option('theme'))->display('Pro/index');
        }
        ;
    }
    // 处理用户发起项目审核
    public function pending($page = 1)
    {
        if (mc_is_admin() || mc_is_bianji())
        {
            $condition['type'] = 'pro_pending';
            $this->page = M('page')->where($condition)
                ->order('id desc')
                ->page($page, mc_option('page_size'))
                ->select();
            $count = M('page')->where($condition)->count();
            $this->assign('count', $count);
            $this->assign('page_now', $page);
            $this->theme(mc_option('theme'))->display('Pro/pending');
        }
        else
        {
            $this->error('你没有权限查看此页面！');
        }
    }

    public function term($id, $page = 1)
    {
        if (is_numeric($id) && is_numeric($page))
        {
            // 检索子分类
            $args_id_t = M('meta')->where(
                    "meta_key='parent' AND meta_value='$id' AND type='term'")->getField(
                    'page_id', true);
            $condition_t['id'] = array(
                    'in',
                    $args_id_t
            );
            $condition_t['type'] = 'term_pro';
            $terms_pro_t = M('page')->where($condition_t)->getField('id', true);
            if ($terms_pro_t)
            {
                // 如果有子分类，获取子分类下项目
                $condition_child['meta_key'] = 'term';
                $condition_child['meta_value'] = array(
                        'in',
                        $terms_pro_t
                );
                $condition_child['type'] = 'basic';
                $args_id_child = M('meta')->where($condition_child)->getField(
                        'page_id', true);
                // 获取当前分类下项目
                $args_id_this = M('meta')->where(
                        "meta_key='term' AND meta_value='$id' AND type='basic'")->getField(
                        'page_id', true);
                if ($args_id_child && $args_id_this)
                {
                    $args_id = array_merge($args_id_child, $args_id_this);
                }
                elseif ($args_id_this)
                {
                    $args_id = $args_id_this;
                }
                elseif ($args_id_child)
                {
                    $args_id = $args_id_child;
                }
            }
            else
            {
                // 如果没有子分类，直接获取当前分类下项目
                $args_id = M('meta')->where(
                        "meta_key='term' AND meta_value='$id' AND type='basic'")->getField(
                        'page_id', true);
            }
            $condition['id'] = array(
                    'in',
                    $args_id
            );
            $condition['type'] = 'pro';
            $this->page = M('page')->where($condition)
                ->order('date desc')
                ->page($page, mc_option('page_size'))
                ->select();
            $count = M('page')->where($condition)->count();
            $this->assign('id', $id);
            $this->assign('count', $count);
            $this->assign('page_now', $page);
            $this->theme(mc_option('theme'))->display('Pro/term');
        }
        else
        {
            $this->error('参数错误！');
        }
    }

    public function single($id = 1)
    {
        if (is_numeric($id))
        {
            $type = mc_get_page_field($id, 'type');
            if ($type == 'pro')
            {
                mc_set_views($id);
                $this->page = M('page')->field('id,title,content,type,date')
                    ->where("id='$id'")
                    ->select();
                $this->theme(mc_option('theme'))->display('Pro/single');
            }
            else
            {
                $this->error('你没有权限查看此页！');
            }
        }
        else
        {
            $this->error('参数错误');
        }
    }
    // 显示用户发布的项目详情--pope
    public function single_user($id = 1)
    {
        if (is_numeric($id))
        {
            $single_user_id = mc_get_meta($id, 'author'); // 得到项目发布者的ID--pope
            if ($single_user_id == mc_user_id() || mc_is_admin() ||
                     mc_is_bianji())
            {
                mc_set_views($id);
                $this->page = M('page')->field('id,title,content,type,date')
                    ->where("id='$id'")
                    ->select();
                $this->theme(mc_option('theme'))->display('Pro/single_user');
            }
            else
            {
                $this->error('你没有权限查看此页！');
            }
        }
        else
        {
            $this->error('参数错误');
        }
    }
}