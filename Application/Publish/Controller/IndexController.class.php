<?php

namespace Publish\Controller;

use Think\Controller;

class IndexController extends Controller
{

	public function index()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			$this->theme(mc_option('theme'))->display('Publish/index');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}
	// 普通用户提交发布项目--pope
	public function add_user_pro()
	{
		if(mc_user_id())
		{
			$this->theme(mc_option('theme'))->display('Publish/add_user_pro');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}

	public function add_group()
	{
		if(mc_user_id() || mc_is_bianji())
		{
			$this->theme(mc_option('theme'))->display('Publish/add_group');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}

	public function upload()
	{
		require_once './Kindeditor/php/upload_json.php';
	}

	public function edit($id)
	{
		if(is_numeric($id))
		{
			if(mc_is_admin() || mc_is_bianji() || mc_author_id($id) == mc_user_id())
			{
				$this->page = M('page')->where("id='$id'")->order('id desc')->select();
				if(mc_get_page_field($id, 'type') == 'pro')
				{
					$this->theme(mc_option('theme'))->display('Publish/edit_pro');
				}
				elseif(mc_get_page_field($id, 'type') == 'pro_pending')
				{ // 编辑待审核项目--pope
					$this->theme(mc_option('theme'))->display('Publish/edit_user_pro');
				}
				elseif(mc_get_page_field($id, 'type') == 'publish' || mc_get_page_field($id, 'type') == 'pending')
				{
					$this->theme(mc_option('theme'))->display('Publish/edit');
				}
				elseif(mc_get_page_field($id, 'type') == 'group')
				{
					$this->theme(mc_option('theme'))->display('Publish/edit_group');
				}
				elseif(mc_get_page_field($id, 'type') == 'article' || mc_get_page_field($id, 'type') == 'article_pending')
				{
					$this->theme(mc_option('theme'))->display('Publish/edit_article');
				}
				else
				{
					$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
				}
			}
			else
			{
				$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
	}

	public function add_post($id = false, $number = false)
	{ // 添加 我想要合伙这个 项目话题
		if(mc_user_id())
		{
			if($_GET['wish'] == 1)
			{
				if(is_numeric($id) && is_numeric($number) && $number > 0)
				{
					if(mc_get_meta($id, 'kucun') <= 0)
					{
						$this->error('合伙份额不足！');
					}
					else
					{
						if($_POST['parameter'])
						{
							$this->assign('parameter', $_POST['parameter']);
							$this->assign('cart', $number);
						}
						else
						{
							// 本项目不存在多种型号--pope
							$this->assign('cart', $number);
						}
					}
				}
				else
				{
					$this->error('参数错误！');
				}
			}
			$this->theme(mc_option('theme'))->display('Publish/add_post');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}

	public function add_term()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			$this->theme(mc_option('theme'))->display('Publish/add_term');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}

	public function add_article()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			$this->theme(mc_option('theme'))->display('Publish/add_article');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}

	public function add_user_article()
	{ // 用户发布文章 --pope
		if(mc_user_id())
		{
			$this->theme(mc_option('theme'))->display('Publish/add_user_article');
		}
		else
		{
			$this->success('请先登陆', U('User/login/index'));
		}
		;
	}
}