<?php
namespace Post\Controller;
use Think\Controller;

class IndexController extends Controller
{

    public function single($id = 1)
    {
        if (is_numeric($id))
        {
            $type = mc_get_page_field($id, 'type');
            if ($type == 'publish')
            {
                mc_set_views($id);
                if (mc_option('paixu') != 2)
                {
                    mc_update_page($id, strtotime("now"), 'date');
                }
                ;
                $this->page = M('page')->field('id,title,content,type,date')
                    ->where("id='$id'")
                    ->select();
                $this->theme(mc_option('theme'))->display('Post/index');
            }
            elseif ($type == 'pending')
            {
                $single_user_id = mc_get_meta($id, 'author'); // 得到项目发布者的ID--pope
                if ($single_user_id == mc_user_id() || mc_is_admin() ||
                         mc_is_bianji())
                {
                    mc_set_views($id);
                    if (mc_option('paixu') != 2)
                    {
                        mc_update_page($id, strtotime("now"), 'date');
                    }
                    ;
                    $this->page = M('page')->field('id,title,content,type,date')
                        ->where("id='$id'")
                        ->select();
                    $this->theme(mc_option('theme'))->display('Post/index');
                }
                else
                {
                    $this->error('你没有权限查看此页！');
                }
            }
            else
            {
                $this->error('你没有权限查看本页面！');
            }
        }
        else
        {
            $this->error('参数错误！');
        }
    }

    public function checkout($id, $price)
    {
        if (mc_user_id())
        {
            if (is_numeric($price))
            {
                $this->theme(mc_option('theme'))->display('Post/checkout');
            }
            else
            {
                $this->error('价格必须为数字！');
            }
        }
        else
        {
            $this->success('请先登陆！', U('User/login/index'));
        }
    }
}