<?php

namespace Home\Controller;

use Think\Controller;

class PerformController extends Controller
{

	public function xihuan($add_xihuan)
	{
		// $add_xihuan =
		// mc_magic_in($_GET['add_xihuan']);//mc_magic_in()有点问题--pope
		$add_xihuan = $_GET['add_xihuan'];
		$user_xihuan = M('action')->where("page_id='$add_xihuan' AND user_id ='" . mc_user_id() . "' AND action_key='perform' AND action_value ='xihuan'")->getField('id');
		if(empty($user_xihuan))
		{
			mc_add_action($add_xihuan, 'perform', 'xihuan');
			$user_id = mc_author_id($add_xihuan);
			do_go('add_xihuan_end', $user_id);
		}
		;
		$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		// $date = strtotime("+8HOUR"); echo date('Y-m-d H:i:s',$date);
	}

	public function add_shoucang($add_shoucang)
	{
		// $add_shoucang = mc_magic_in($_GET['add_shoucang']);//过滤有问题--pope
		$add_shoucang = $_GET['add_shoucang'];
		$user_shoucang = M('action')->where("page_id='$add_shoucang' AND user_id ='" . mc_user_id() . "' AND action_key='perform' AND action_value ='shoucang'")->getField('id');
		if(empty($user_shoucang))
		{
			mc_add_action($add_shoucang, 'perform', 'shoucang');
			$user_id = mc_author_id($add_shoucang);
			do_go('add_shoucang_end', $user_id);
		}
		;
		$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
	}

	public function remove_shoucang($remove_shoucang)
	{
		// $remove_shoucang = mc_magic_in($_GET['remove_shoucang']);--pope
		$remove_shoucang = $_GET['remove_shoucang'];
		M('action')->where("page_id='$remove_shoucang' AND user_id='" . mc_user_id() . "' AND action_key='perform' AND action_value = 'shoucang'")->delete();
		$user_id = mc_author_id($remove_shoucang);
		do_go('remove_shoucang_end', $user_id);
		$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
	}

	public function add_guanzhu($add_guanzhu)
	{
		// $add_guanzhu = mc_magic_in($_GET['add_guanzhu']);--pope
		$add_guanzhu = $_GET['add_guanzhu'];
		$user_guanzhu = M('action')->where("page_id='$add_guanzhu' AND user_id ='" . mc_user_id() . "' AND action_key='perform' AND action_value ='guanzhu'")->getField('id');
		if(empty($user_guanzhu))
		{
			mc_add_action($add_guanzhu, 'perform', 'guanzhu');
			do_go('add_guanzhu_end', $add_guanzhu);
		}
		;
		$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
	}

	public function remove_guanzhu($remove_guanzhu)
	{
		// $remove_guanzhu = mc_magic_in($_GET['remove_guanzhu']);--pope
		M('action')->where("page_id='$remove_guanzhu' AND user_id='" . mc_user_id() . "' AND action_key='perform' AND action_value = 'guanzhu'")->delete();
		do_go('remove_guanzhu_end', $remove_guanzhu);
		$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
	}

	public function comment($id, $content)
	{
		// 评论提交--pope
		if(mc_user_id())
		{
			$id = mc_magic_in($_POST['id']);
			$content = mysql_real_escape_string(strip_tags($_POST['content']));
			if($content)
			{
				$content_array = explode(' ', $content);
				foreach($content_array as $val)
				{
					$content_s = strstr($val, '@');
					$to_user = substr($content_s, 1);
					if($to_user)
					{
						// 回复处理@号--pope
						$idx = M('page')->where("title='$to_user'")->getField('id');
						$content_s2 .= '<a href="' . U('user/index/index?id=' . $idx) . '">' . $content_s . '</a> ';
					}
					else
					{
						$content_s2 .= $val . ' ';
					}
				}
				;
				$result = mc_add_action($id, 'comment', $content_s2);
				foreach($content_array as $val)
				{
					$content_s = strstr($val, '@');
					$to_user = substr($content_s, 1);
					if($to_user)
					{
						$idx = M('page')->where("title='$to_user'")->getField('id');
						mc_add_action($idx, 'at', $result);
						do_go('publish_at_end', $idx);
					}
					;
				}
				;
				$user_id = mc_author_id($id);
				do_go('publish_comment_end', $user_id);
				$type = mc_get_page_field($id, 'type');
				if($type == 'publish')
				{
					if(mc_option('paixu') == 2)
					{
						mc_update_page($id, strtotime("now"), 'date');
					}
					;
					$this->success('评论成功！', U('post/index/single?id=' . $id . '#comment-' . $result));
				}
				elseif($type == 'pending')
				{
					if(mc_option('paixu') == 2)
					{
						mc_update_page($id, strtotime("now"), 'date');
					}
					;
					$this->success('评论成功！', U('post/index/single?id=' . $id . '#comment-' . $result));
				}
				elseif($type == 'article')
				{
					$this->success('评论成功！', U('article/index/single?id=' . $id . '#comment-' . $result));
				}
				elseif($type == 'pro_pending')
				{
					$this->success('评论成功！', U('pro/index/single_user?id=' . $id . '#comment-' . $result));
				}
				else
				{
					$this->success('评论成功！', U('pro/index/single?id=' . $id . '#comment-' . $result));
				}
			}
			else
			{
				$this->error('请填写评论内容！');
			}
		}
		else
		{
			$this->success('请先登陆', U('user/login/index'));
		}
	}

	public function publish()
	{
		if(mc_user_id())
		{
			if($_POST['title'] && $_POST['content'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				$page['content'] = mc_magic_in(mc_remove_html($_POST['content']));
				if(mc_option('shenhe_comment') == 2)
				{
					// 判断是否需要审核--pope
					if(mc_is_admin())
					{
						$page['type'] = 'publish';
					}
					else
					{
						$page['type'] = 'pending';
					}
				}
				else
				{
					$page['type'] = 'publish';
				}
				;
				$page['date'] = strtotime("now");
				$result = M('page')->data($page)->add();
				if($result)
				{
					mc_add_meta($result, 'author', mc_user_id());
					if(is_numeric($_POST['group']))
					{
						mc_add_meta($result, 'group', $_POST['group']);
						mc_update_page(mc_magic_in($_POST['group']), strtotime("now"), 'date');
						mc_add_meta($result, 'time', strtotime("now"));
						if(is_numeric($_POST['number']))
						{
							mc_add_meta($result, 'number', $_POST['number']);
							mc_add_meta($result, 'buyer_phone', $_POST['buyer_phone']);
							mc_add_meta($result, 'buyer_address', $_POST['buyer_address']);
							mc_add_meta($result, 'buyer_city', $_POST['buyer_city']);
							mc_add_meta($result, 'buyer_province', $_POST['buyer_province']);
							mc_add_meta($result, 'buyer_name', $_POST['buyer_name']);
							mc_add_meta($result, 'wish', 0);
							$parameter = $_POST['parameter'];
							if($parameter)
							{
								foreach($parameter as $key => $valp)
								{
									mc_add_meta($result, 'parameter', $key . '|' . $valp);
								}
								;
							}
							;
						}
					}
					do_go('publish_post_end', $result);
					$this->success('发布成功，请耐心等待审核', U('post/index/single?id=' . $result));
				}
				else
				{
					$this->error('发布失败！');
				}
			}
			else
			{
				$this->error('请填写标题和内容');
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	/**
	 * 管理员 项目发布页提交--pope
	 */
	public function publish_pro()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			// print '<pre>';
			// print_r($_POST);
			// print '</pre>';
			// exit();
			if($_POST['title'] && $_POST['content'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				$page['content'] = mc_magic_in($_POST['content']);
				$page['type'] = 'pro';
				$page['date'] = strtotime("now");
				$result = M('page')->data($page)->add();
				if($result)
				{
					mc_add_meta($result, 'author', mc_user_id());
					if($_POST['fmimg'])
					{
						foreach($_POST['fmimg'] as $val)
						{
							mc_add_meta($result, 'fmimg', $val);
						}
					}
					else
					{
						$this->error('请选择选择上传项目宣传图（顶部）！');
					}
					;
					if($_POST['fmimgcover'])
					{
						// 项目封面图片 --pope
						mc_add_meta($result, 'fmimgcover', $_POST['fmimgcover']);
					}
					else
					{
						$this->error('请选择选择上传项目封面图（首页）！');
					}
					;
					if(!$_POST['pro_city'])
					{
						$this->error('请选择省份和城市');
					}
					else
					{
						mc_add_meta($result, 'pro_province', mc_magic_in($_POST[pro_province]));
						mc_add_meta($result, 'pro_city', mc_magic_in($_POST['pro_city']));
					}
					;
					if($_POST['brief'])
					{
						mc_add_meta($result, 'brief', $_POST['brief']);
					}
					else
					{
						$this->error('请填写项目期望简要说明！');
					}
					;
					if(is_numeric($_POST['tol_price']))
					{
						mc_add_meta($result, 'tol_price', mc_magic_in($_POST['tol_price']));
					}
					else
					{
						$this->error('请填写项目预计总资经需求！');
					}
					;
					if(is_numeric($_POST['kucun']))
					{
						mc_add_meta($result, 'kucun', mc_magic_in($_POST['kucun']));
					}
					else
					{
						$this->error('请填写项目资金需求分为多少份！');
					}
					;
					if(is_numeric($_POST['partners']))
					{
						mc_add_meta($result, 'partners', mc_magic_in($_POST['partners']));
					}
					else
					{
						$this->error('请填写项目期望合伙人数！');
					}
					;
					if(is_numeric($_POST['days']))
					{
						mc_add_meta($result, 'days', mc_magic_in($_POST['days']));
					}
					else
					{
						$this->error('请填写项目期上线天数！');
					}
					;
					mc_add_meta($result, 'term', mc_magic_in($_POST['term']));
					if(is_numeric($_POST['min_share']))
					{
						mc_add_meta($result, 'min_share', mc_magic_in($_POST['min_share']));
					}
					else
					{
						$this->error('请填写项目最小合伙份数！');
					}
					;
					if(is_numeric($_POST['xiaoliang']))
					{
						mc_add_meta($result, 'xiaoliang', mc_magic_in($_POST['xiaoliang']));
					}
					else
					{
						$this->error('请填写项目已合伙份数！');
					}
					;
					if(is_numeric($_POST['tol_price']) && is_numeric($_POST['xiaoliang']) && is_numeric($_POST['kucun']))
					{
						// 每份合伙资金--pope
						
						mc_add_meta($result, 'price', mc_magic_in($_POST['tol_price']) / ($_POST['xiaoliang'] + $_POST['kucun']));
					}
					;
					if(is_numeric($_POST['num_people']))
					{
						mc_add_meta($result, 'num_people', mc_magic_in($_POST['num_people']));
					}
					else
					{
						$this->error('请填写项目已合伙人数！');
					}
					;
					if($_POST['pro-parameter'])
					{
						$parameter = I('param.pro-parameter');
						foreach($parameter as $key => $val)
						{
							foreach($val as $vals)
							{
								if($vals['name'] != '')
								{
									mc_add_meta($result, $key, $vals['name'], 'parameter');
									if($vals['price'] > 0)
									{
										mc_add_meta($result, $vals['name'], $vals['price'], 'price');
									}
									else
									{
										mc_add_meta($result, $vals['name'], 0, 'price');
									}
								}
							}
						}
					}
					;
					if($_POST['vedio'])
					{
						mc_add_meta($result, 'vedio', $_POST['vedio']);
					}
					;
					if($_POST['keywords'])
					{
						mc_add_meta($result, 'keywords', $_POST['keywords']);
					}
					;
					if($_POST['description'])
					{
						mc_add_meta($result, 'description', $_POST['description']);
					}
					;
					// do_go完成记录用户行为(action)的工作--pope
					do_go('publish_pro_end', $result);
					$this->success('发布成功，请耐心等待审核', U('pro/index/single_user?id=' . $result));
				}
				else
				{
					$this->error('出错，发布失败！');
				}
			}
			else
			{
				$this->error('请填写项目信息（标题，内容，宣传图，封面图，选择城市，简要说明，预计资金需求，资金分数，期望合伙人数，上线天数）！');
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	/**
	 * 普通用户 项目发布页提交--pope
	 */
	public function publish_user_pro()
	{
		if(mc_user_id())
		{
			// print '<pre>';
			// print_r($_POST);
			// print '</pre>';
			// exit();
			if(!check_verify($_POST['tp_verify']))
			{
				$this->error("验证码不正确!");
			}
			else
			{
				if(validate_string_len($_POST['title'], 1, 256) && $_POST['content'])
				{
					$page['title'] = mc_magic_in($_POST['title']);
					$page['content'] = mc_magic_in($_POST['content']);
					$page['type'] = 'pro_pending';
					// 待审核项目--pope
					$page['date'] = strtotime("now");
					$result = M('page')->data($page)->add();
					if($result)
					{
						mc_add_meta($result, 'author', mc_user_id());
						if($_POST['fmimg'])
						{
							foreach($_POST['fmimg'] as $val)
							{
								mc_add_meta($result, 'fmimg', $val);
							}
						}
						// else
						// {
						// $this->error('请选择选择上传项目宣传图（顶部）！');
						// }
						;
						if($_POST['fmimgcover'])
						{
							// 项目封面图片 --pope
							mc_add_meta($result, 'fmimgcover', $_POST['fmimgcover']);
						}
						// else
						// {
						// $this->error('请选择选择上传项目封面图（首页）！');
						// }
						;
						if(!validate_string_len($_POST['pro_city'], 1, 32))
						{
							$this->error('省份和城市不合法!');
						}
						else
						{
							mc_add_meta($result, 'pro_province', mc_magic_in($_POST[pro_province]));
							mc_add_meta($result, 'pro_city', mc_magic_in($_POST['pro_city']));
						}
						;
						if(validate_string_len($_POST['brief'], 1, 512))
						{
							mc_add_meta($result, 'brief', $_POST['brief']);
						}
						else
						{
							$this->error('项目期望简要说明不合法！');
						}
						;
						if(validate_number($_POST['tol_price'], 1, 10000000))
						{
							mc_add_meta($result, 'tol_price', mc_magic_in($_POST['tol_price']));
						}
						else
						{
							$this->error('项目预计总资经需求不合法！');
						}
						;
						if(validate_number($_POST['kucun'], 1, 100))
						{
							mc_add_meta($result, 'kucun', mc_magic_in($_POST['kucun']));
						}
						else
						{
							$this->error('项目资金需求分为多少份不合法！');
						}
						;
						if(validate_number($_POST['partners'], 1, 100))
						{
							mc_add_meta($result, 'partners', mc_magic_in($_POST['partners']));
						}
						else
						{
							$this->error('项目期望合伙人数不合法！');
						}
						;
						if(validate_number($_POST['days'], 1, 10000))
						{
							mc_add_meta($result, 'days', mc_magic_in($_POST['days']));
						}
						else
						{
							$this->error('项目期上线天数不合法！');
						}
						;
						if(validate_string_len($_POST['vedio'], 0, 512))
						{
							mc_add_meta($result, 'vedio', $_POST['vedio']);
						}
						else
						{
							$this->error("视频地址不合法!");
						}
						;
						mc_add_meta($result, 'term', mc_magic_in($_POST['term']));
						if(validate_number($_POST['min_share'], 1, validate_number($_POST['kucun'], 1, 100)))
						{
							mc_add_meta($result, 'min_share', mc_magic_in($_POST['min_share']));
						}
						else
						{
							mc_add_meta($result, 'min_share', 1);
						}
						;
						if(validate_number($_POST['xiaoliang'], 0, 100))
						{
							mc_add_meta($result, 'xiaoliang', mc_magic_in($_POST['xiaoliang']));
						}
						else
						{
							mc_add_meta($result, 'xiaoliang', 0);
						}
						;
						if(validate_number($_POST['tol_price'], 1, 10000000) && validate_number($_POST['kucun'], 1, 100) && is_numeric($_POST['xiaoliang']) && $_POST['xiaoliang'] <= 100 && $_POST['xiaoliang'] >= 0)
						
						{
							// 每份合伙资金--pope
							mc_add_meta($result, 'price', mc_magic_in($_POST['tol_price']) / ($_POST['xiaoliang'] + $_POST['kucun']));
						}
						;
						if(validate_number($_POST['num_people'], 0, validate_number($_POST['partners'], 1, 100)))
						{
							mc_add_meta($result, 'num_people', mc_magic_in($_POST['num_people']));
						}
						else
						{
							mc_add_meta($result, 'num_people', 0);
						}
						;
						if($_POST['pro-parameter'])
						{
							$parameter = I('param.pro-parameter');
							foreach($parameter as $key => $val)
							{
								foreach($val as $vals)
								{
									if($vals['name'] != '')
									{
										mc_add_meta($result, $key, $vals['name'], 'parameter');
										if($vals['price'] > 0)
										{
											mc_add_meta($result, $vals['name'], $vals['price'], 'price');
										}
										else
										{
											mc_add_meta($result, $vals['name'], 0, 'price');
										}
									}
								}
							}
						}
						;
						if(validate_string_len($_POST['keywords'], 1, 128))
						{
							mc_add_meta($result, 'keywords', $_POST['keywords']);
						}
						;
						if(validate_string_len($_POST['description'], 1, 512))
						{
							mc_add_meta($result, 'description', $_POST['description']);
						}
						;
						// do_go完成记录用户行为(action)的工作--pope
						do_go('publish_user_pro_end', $result);
						$this->success('发布成功，请耐心等待审核', U('pro/index/single_user?id=' . $result));
					}
					else
					{
						$this->error('出错，发布失败！');
					}
				}
				else
				
				{
					$this->error('标题或内容不合法！');
				}
				;
			}
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	public function publish_group()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			if($_POST['title'] && $_POST['content'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				$page['content'] = mc_magic_in($_POST['content']);
				$page['type'] = 'group';
				$page['date'] = strtotime("now");
				$result = M('page')->data($page)->add();
				if($result)
				{
					if($_POST['fmimg'])
					{
						mc_add_meta($result, 'fmimg', mc_magic_in($_POST['fmimg']));
					}
					;
					mc_add_meta($result, 'author', mc_user_id());
					mc_add_meta(mc_user_id(), 'group_admin', $result, 'user');
					do_go('publish_group_end', $result);
					$this->success('新建群组成功！', U('post/group/index?id=' . $result));
				}
				else
				{
					$this->error('发布失败！');
				}
			}
			else
			{
				$this->error('请填写群组名称和介绍');
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	public function publish_article()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			if($_POST['title'] && $_POST['content'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				$page['content'] = mc_magic_in($_POST['content']);
				$page['type'] = 'article';
				$page['date'] = strtotime("now");
				$result = M('page')->data($page)->add();
				if($result)
				{
					if($_POST['fmimg'])
					{
						mc_add_meta($result, 'fmimg', mc_magic_in($_POST['fmimg']));
					}
					;
					if(I('param.tags'))
					{
						$tags = explode(' ', I('param.tags'));
						foreach($tags as $tag)
						{
							if($tag)
							{
								mc_add_meta($result, 'tag', $tag);
							}
							;
						}
						;
					}
					;
					mc_add_meta($result, 'term', mc_magic_in($_POST['term']));
					mc_add_meta($result, 'author', mc_user_id());
					do_go('publish_article_end', $result);
					$this->success('发布成功！', U('article/index/single?id=' . $result));
				}
				else
				{
					$this->error('发布失败！');
				}
			}
			else
			{
				$this->error('请填写标题和内容');
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	public function publish_user_article()
	{ // 处理用户发布文章--pope
		if(mc_user_id())
		{
			if($_POST['title'] && $_POST['content'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				$page['content'] = mc_magic_in($_POST['content']);
				$page['type'] = 'article_pending';
				$page['date'] = strtotime("now");
				$result = M('page')->data($page)->add();
				if($result)
				{
					if($_POST['fmimg'])
					{
						mc_add_meta($result, 'fmimg', mc_magic_in($_POST['fmimg']));
					}
					;
					if(I('param.tags'))
					{
						$tags = explode(' ', I('param.tags'));
						foreach($tags as $tag)
						{
							if($tag)
							{
								mc_add_meta($result, 'tag', $tag);
							}
							;
						}
						;
					}
					;
					mc_add_meta($result, 'term', mc_magic_in($_POST['term']));
					mc_add_meta($result, 'author', mc_user_id());
					do_go('publish_user_article_end', $result);
					$this->success('发布成功！', U('article/index/single_user?id=' . $result));
				}
				else
				{
					$this->error('发布失败！');
				}
			}
			else
			{
				$this->error('请填写标题和内容');
			}
			;
		}
		else
		{
			$this->error('请先登录!', U('home/index/index'));
		}
		;
	}

	/**
	 * 各种编辑页提交
	 */
	public function edit()
	{
		if(mc_is_admin() || mc_is_bianji() || mc_author_id($_POST['id']) == mc_user_id())
		{
			
			if(validate_string_len($_POST['title'], 1, 256) && $_POST['content'] && is_numeric($_POST['id']))
			{
				if(mc_is_admin() || mc_is_bianji())
				{
					// 只有管理员和网站编辑可以修改已审核通过的项目信息--pope
					if(mc_get_page_field($_POST['id'], 'type') == 'pro')
					{
						// 编辑项目的提交--pope
						mc_update_page($_POST['id'], $_POST['title'], 'title');
						mc_update_page($_POST['id'], $_POST['content'], 'content');
						if($_POST['fmimg'])
						{
							mc_delete_meta($_POST['id'], 'fmimg');
							foreach($_POST['fmimg'] as $val)
							{
								mc_add_meta($_POST['id'], 'fmimg', $val);
							}
						}
						// else
						// {
						// $this->error('请设置项目宣传图片（顶部）！');
						// }
						;
						if($_POST['fmimgcover'])
						{
							// 更新封面
							mc_update_meta($_POST['id'], 'fmimgcover', mc_magic_in($_POST['fmimgcover']));
						}
						// else
						// {
						// $this->error('请设置项目封面图片！');
						// }
						;
						if(!$_POST['pro_city'])
						{
							$this->error('请选择省份和城市');
						}
						else
						{
							mc_update_meta($_POST['id'], 'pro_province', mc_magic_in($_POST[pro_province]));
							mc_update_meta($_POST['id'], 'pro_city', mc_magic_in($_POST['pro_city']));
						}
						;
						if($_POST['brief'])
						{
							mc_update_meta($_POST['id'], 'brief', mc_magic_in($_POST['brief']));
						}
						else
						{
							$this->error('请填写项目简介！');
						}
						;
						if(is_numeric($_POST['tol_price']))
						{
							mc_update_meta($_POST['id'], 'tol_price', mc_magic_in($_POST['tol_price']));
						}
						else
						{
							$this->error('请填写项目预计总资经！');
						}
						;
						if(is_numeric($_POST['kucun']))
						{
							mc_update_meta($_POST['id'], 'kucun', $_POST['kucun']);
						}
						else
						{
							$this->error('请填写项目预计总资经分为几份！');
						}
						;
						if(is_numeric($_POST['partners']))
						{
							mc_update_meta($_POST['id'], 'partners', mc_magic_in($_POST['partners']));
						}
						else
						{
							$this->error('请填写项目期望合伙人数！');
						}
						;
						if(is_numeric($_POST['days']))
						{
							mc_update_meta($_POST['id'], 'days', mc_magic_in($_POST['days']));
						}
						else
						{
							$this->error('请填写项目上线天数！');
						}
						;
						if($_POST['term'])
						{
							mc_update_meta($_POST['id'], 'term', mc_magic_in($_POST['term']));
						}
						else
						{
							$this->error('请设置分类！');
						}
						;
						if($_POST['vedio'])
						{
							mc_update_meta($_POST['id'], 'vedio', mc_magic_in($_POST['vedio']));
						}
						;
						if(is_numeric($_POST['min_share']))
						{
							mc_update_meta($_POST['id'], 'min_share', mc_magic_in($_POST['min_share']));
						}
						;
						if(is_numeric($_POST['num_people']))
						{
							mc_update_meta($_POST['id'], 'num_people', mc_magic_in($_POST['num_people']));
						}
						;
						if(is_numeric($_POST['xiaoliang']))
						{
							mc_update_meta($_POST['id'], 'xiaoliang', $_POST['xiaoliang']);
						}
						;
						if(is_numeric($_POST['tol_price']) && is_numeric($_POST['xiaoliang']) && is_numeric($_POST['kucun']))
						{
							// 每份合伙资金--pope
							
							mc_update_meta($_POST['id'], 'price', mc_magic_in($_POST['tol_price']) / ($_POST['xiaoliang'] + $_POST['kucun']));
						}
						;
						M('meta')->where("page_id='" . $_POST['id'] . "' AND type = 'parameter'")->delete();
						M('meta')->where("page_id='" . $_POST['id'] . "' AND type = 'price'")->delete();
						if($_POST['pro-parameter'])
						{
							$parameter = $_POST['pro-parameter'];
							foreach($parameter as $key => $val)
							{
								$val = array_reverse($val);
								foreach($val as $vals)
								{
									if($vals['name'] != '')
									{
										mc_add_meta($_POST['id'], $key, $vals['name'], 'parameter');
										if($vals['price'] > 0)
										{
											mc_add_meta($_POST['id'], $vals['name'], $vals['price'], 'price');
										}
										else
										{
											mc_add_meta($_POST['id'], $vals['name'], 0, 'price');
										}
									}
								}
							}
						}
						;
						if($_POST['keywords'])
						{
							mc_update_meta($_POST['id'], 'keywords', $_POST['keywords']);
						}
						;
						if($_POST['description'])
						{
							mc_update_meta($_POST['id'], 'description', $_POST['description']);
						}
						;
					}
					;
				}
				
				if(mc_get_page_field($_POST['id'], 'type') == 'pro_pending')
				{
					if(!check_verify($_POST['tp_verify']))
					{
						$this->error("验证码不正确!");
					}
					else
					{
						// 编辑 未审核 项目的提交--pope
						mc_update_page($_POST['id'], $_POST['title'], 'title');
						mc_update_page($_POST['id'], $_POST['content'], 'content');
						if($_POST['fmimg'])
						{
							mc_delete_meta($_POST['id'], 'fmimg');
							foreach($_POST['fmimg'] as $val)
							{
								mc_add_meta($_POST['id'], 'fmimg', $val);
							}
						}
						// else
						// {
						// $this->error('请设置项目宣传图片（顶部）！');
						// }
						;
						if($_POST['fmimgcover'])
						{
							// 更新封面
							mc_update_meta($_POST['id'], 'fmimgcover', mc_magic_in($_POST['fmimgcover']));
						}
						// else
						// {
						// $this->error('请设置项目封面图片！');
						// }
						;
						if(!validate_string_len($_POST['pro_city'], 1, 32))
						{
							$this->error('省份和城市不合法!');
						}
						else
						{
							mc_update_meta($_POST['id'], 'pro_province', mc_magic_in($_POST[pro_province]));
							mc_update_meta($_POST['id'], 'pro_city', mc_magic_in($_POST['pro_city']));
						}
						;
						if(validate_string_len($_POST['brief'], 1, 512))
						{
							mc_update_meta($_POST['id'], 'brief', mc_magic_in($_POST['brief']));
						}
						else
						{
							$this->error('项目期望简要说明不合法！');
						}
						;
						if(validate_number($_POST['tol_price'], 1, 10000000))
						{
							mc_update_meta($_POST['id'], 'tol_price', mc_magic_in($_POST['tol_price']));
						}
						else
						{
							$this->error('项目预计总资经需求不合法！');
						}
						;
						if(validate_number($_POST['kucun'], 1, 100))
						{
							mc_update_meta($_POST['id'], 'kucun', $_POST['kucun']);
						}
						else
						{
							$this->error('项目资金需求分为多少份不合法！');
						}
						;
						if(validate_number($_POST['partners'], 1, 100))
						{
							mc_update_meta($_POST['id'], 'partners', mc_magic_in($_POST['partners']));
						}
						else
						{
							$this->error('项目期望合伙人数不合法！');
						}
						;
						if(validate_number($_POST['days'], 1, 10000))
						{
							mc_update_meta($_POST['id'], 'days', mc_magic_in($_POST['days']));
						}
						else
						{
							$this->error('项目期上线天数不合法！');
						}
						;
						if($_POST['term'])
						{
							mc_update_meta($_POST['id'], 'term', mc_magic_in($_POST['term']));
						}
						else
						{
							$this->error('请设置分类！');
						}
						;
						if(validate_string_len($_POST['vedio'], 0, 512))
						{
							mc_update_meta($_POST['id'], 'vedio', mc_magic_in($_POST['vedio']));
						}
						else
						{
							$this->error("视频地址不合法!");
						}
						;
						if(validate_number($_POST['min_share'], 1, validate_number($_POST['kucun'], 1, 100)))
						{
							mc_update_meta($_POST['id'], 'min_share', mc_magic_in($_POST['min_share']));
						}
						;
						if(validate_number($_POST['num_people'], 0, validate_number($_POST['partners'], 1, 100)))
						{
							mc_update_meta($_POST['id'], 'num_people', mc_magic_in($_POST['num_people']));
						}
						;
						if(validate_number($_POST['xiaoliang'], 0, 100))
						{
							mc_update_meta($_POST['id'], 'xiaoliang', $_POST['xiaoliang']);
						}
						;
						if(validate_number($_POST['tol_price'], 1, 10000000) && validate_number($_POST['kucun'], 1, 100) && is_numeric($_POST['xiaoliang']) && $_POST['xiaoliang'] <= 100 && $_POST['xiaoliang'] >= 0)
						{
							// 每份合伙资金--pope
							
							mc_update_meta($_POST['id'], 'price', mc_magic_in($_POST['tol_price']) / ($_POST['xiaoliang'] + $_POST['kucun']));
						}
						;
						M('meta')->where("page_id='" . $_POST['id'] . "' AND type = 'parameter'")->delete();
						M('meta')->where("page_id='" . $_POST['id'] . "' AND type = 'price'")->delete();
						if($_POST['pro-parameter'])
						{
							$parameter = $_POST['pro-parameter'];
							foreach($parameter as $key => $val)
							{
								$val = array_reverse($val);
								foreach($val as $vals)
								{
									if($vals['name'] != '')
									{
										mc_add_meta($_POST['id'], $key, $vals['name'], 'parameter');
										if($vals['price'] > 0)
										{
											mc_add_meta($_POST['id'], $vals['name'], $vals['price'], 'price');
										}
										else
										{
											mc_add_meta($_POST['id'], $vals['name'], 0, 'price');
										}
									}
								}
							}
						}
						;
						if(validate_string_len($_POST['keywords'], 1, 128))
						{
							mc_update_meta($_POST['id'], 'keywords', $_POST['keywords']);
						}
						;
						if(validate_string_len($_POST['description'], 1, 512))
						{
							mc_update_meta($_POST['id'], 'description', $_POST['description']);
						}
						;
					}
				}
				;
				if(mc_get_page_field($_POST['id'], 'type') == 'group')
				{
					mc_update_page($_POST['id'], $_POST['title'], 'title');
					mc_update_page($_POST['id'], $_POST['content'], 'content');
					mc_update_meta($_POST['id'], 'fmimg', mc_magic_in($_POST['fmimg']));
				}
				;
				if(mc_get_page_field($_POST['id'], 'type') == 'publish')
				{
					mc_update_page($_POST['id'], $_POST['title'], 'title');
					mc_update_page($_POST['id'], $_POST['content'], 'content');
					mc_update_meta($_POST['id'], 'group', mc_magic_in($_POST['group']));
				}
				;
				if(mc_get_page_field($_POST['id'], 'type') == 'pending')
				{
					// 未审核时群组变换--pope
					mc_update_page($_POST['id'], $_POST['title'], 'title');
					mc_update_page($_POST['id'], $_POST['content'], 'content');
					mc_update_meta($_POST['id'], 'group', mc_magic_in($_POST['group']));
				}
				;
				if(mc_get_page_field($_POST['id'], 'type') == 'article' || mc_get_page_field($_POST['id'], 'type') == 'article_pending')
				{
					mc_update_page($_POST['id'], $_POST['title'], 'title');
					mc_update_page($_POST['id'], $_POST['content'], 'content');
					mc_update_meta($_POST['id'], 'fmimg', mc_magic_in($_POST['fmimg']));
					if(I('param.tags'))
					{
						mc_delete_meta($_POST['id'], 'tag');
						$tags = explode(' ', I('param.tags'));
						foreach($tags as $tag)
						{
							if($tag)
							{
								mc_add_meta($_POST['id'], 'tag', $tag);
							}
							;
						}
						;
					}
					;
					if($_POST['term'])
					{
						mc_update_meta($_POST['id'], 'term', mc_magic_in($_POST['term']));
					}
					else
					{
						$this->error('请设置分类！');
					}
					;
				}
				;
				if(mc_get_page_field($_POST['id'], 'type') == 'pro')
				{
					$this->success('编辑成功', U('pro/index/single?id=' . $_POST['id']));
				}
				elseif(mc_get_page_field($_POST['id'], 'type') == 'pro_pending')
				{
					// 成功后显示未审核页面内容--pope
					$this->success('编辑成功', U('pro/index/single_user?id=' . $_POST['id']));
				}
				elseif(mc_get_page_field($_POST['id'], 'type') == 'publish' || mc_get_page_field($_POST['id'], 'type') == 'pending')
				{
					$this->success('编辑成功', U('post/index/single?id=' . $_POST['id']));
				}
				elseif(mc_get_page_field($_POST['id'], 'type') == 'group')
				{
					$this->success('编辑成功', U('post/group/index?id=' . $_POST['id']));
				}
				elseif(mc_get_page_field($_POST['id'], 'type') == 'article' || mc_get_page_field($_POST['id'], 'type') == 'article_pending')
				{
					$this->success('编辑成功', U('article/index/single?id=' . $_POST['id']));
				}
				else
				{
					$this->error('未知的Page类型', U('home/index/index'));
				}
			}
			else
			{
				$this->error('请完整填写信息！');
			}
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	public function add_cart($id, $number)
	{
		// 添加到购物车--pope
		if(is_numeric($id) && is_numeric($number) && $number > 0)
		{
			if(mc_user_id())
			{
				if(mc_get_meta($id, 'kucun') <= 0)
				{
					$this->error('项目份额不足！');
				}
				else
				{
					if($_POST['parameter'])
					{
						$parameter = $_POST['parameter'];
						$cart = M('action')->where("page_id='$id' AND user_id='" . mc_user_id() . "' AND action_key='cart'")->getField('id', true);
						if($cart)
						{
							$par_false = 0;
							foreach($cart as $cart_id)
							{
								$par_old = M('action')->where("page_id='$cart_id' AND user_id='" . mc_user_id() . "'")->getField('id', true);
								if($par_old)
								{
									$par_count = 0;
									foreach($parameter as $key => $val)
									{
										$par_name = M('option')->where("id='$key'")->getField('meta_value');
										$par_id = M('action')->where("page_id='$cart_id' AND action_key='parameter' AND user_id='" . mc_user_id() . "' AND action_value='$par_name|$val'")->getField('id');
										if($par_id)
										{
											$par_count++;
										}
									}
									$par_old_count = count($par_old);
									if($par_count == $par_old_count)
									{
										// 项目参数完全匹配
										$number2 = M('action')->where("id='$cart_id' AND page_id='$id' AND user_id='" . mc_user_id() . "' AND action_key='cart'")->getField('action_value');
										$action['action_value'] = $number2 + $number;
										M('action')->where("id='$cart_id' AND page_id='$id' AND action_key='cart' AND user_id='" . mc_user_id() . "'")->save($action);
									}
									else
									{
										$par_false++;
									}
								}
								else
								{
									// 当前购物车内的项目参数为空
									$result = mc_add_action($id, 'cart', $number);
									if($result)
									{
										if($_POST['parameter'])
										{
											$parameter = $_POST['parameter'];
											foreach($parameter as $key => $val)
											{
												$par_name = M('option')->where("id='$key' AND type='pro'")->getField('meta_value');
												mc_add_action($result, 'parameter', $par_name . '|' . $val);
											}
										}
									}
								}
							}
							$cart_count = count($cart);
							if($par_false == $cart_count)
							{
								// 所有项目参数均不匹配
								$result = mc_add_action($id, 'cart', $number);
								if($result)
								{
									if($_POST['parameter'])
									{
										$parameter = $_POST['parameter'];
										foreach($parameter as $key => $val)
										{
											$par_name = M('option')->where("id='$key' AND type='pro'")->getField('meta_value');
											mc_add_action($result, 'parameter', $par_name . '|' . $val);
										}
									}
								}
							}
						}
						else
						{
							// 购物车中不存在本项目
							$result = mc_add_action($id, 'cart', $number);
							if($result)
							{
								if($_POST['parameter'])
								{
									$parameter = $_POST['parameter'];
									foreach($parameter as $key => $val)
									{
										$par_name = M('option')->where("id='$key'")->getField('meta_value');
										mc_add_action($result, 'parameter', $par_name . '|' . $val);
									}
								}
							}
						}
					}
					else
					{
						// 本项目不存在多种型号
						$cart = M('action')->where("page_id='$id' AND user_id='" . mc_user_id() . "' AND action_key='cart'")->getField('id', true);
						if($cart)
						{
							foreach($cart as $cart_id)
							{
								$par_old = M('action')->where("page_id='$cart_id' AND user_id='" . mc_user_id() . "'")->getField('id', true);
								if($par_old)
								{
									// 购物车内项目存在参数
								}
								else
								{
									$number2 = M('action')->where("id='$cart_id' AND page_id='$id' AND user_id='" . mc_user_id() . "' AND action_key='cart'")->getField('action_value');
									$action['action_value'] = $number2 + $number;
									M('action')->where("id='$cart_id' AND page_id='$id' AND action_key='cart' AND user_id='" . mc_user_id() . "'")->save($action);
								}
							}
						}
						else
						{
							// 购物车内不存在相同项目
							$result = mc_add_action($id, 'cart', $number);
						}
					}
					$this->success('加入合伙项目成功', U('pro/cart/index'));
				}
			}
			else
			{
				$this->success('请先登陆', U('user/login/index'));
			}
		}
		else
		{
			$this->error('参数错误！');
		}
	}

	public function cart_delete($id)
	{
		if(is_numeric($id))
		{
			M('action')->where("id='$id' AND user_id='" . mc_user_id() . "'")->delete();
			M('action')->where("page_id='$id' AND user_id='" . mc_user_id() . "' AND action_key='parameter'")->delete();
			$this->success('删除成功', U('pro/cart/index'));
		}
		else
		{
			$this->error('参数错误！');
		}
	}

	public function pro_parameter()
	{
		if(mc_is_admin())
		{
			$parameter = mc_magic_in($_POST['parameter']);
			if($parameter)
			{
				mc_add_option('parameter', $parameter, $type = 'pro');
				$this->success('新增参数成功');
			}
			else
			{
				$this->error('参数错误！');
			}
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}

	public function pro_parameter_edit()
	{
		if(mc_is_admin())
		{
			$parameter = mc_magic_in($_POST['parameter']);
			if($parameter)
			{
				foreach($parameter as $key => $val)
				{
					$option['meta_value'] = $val;
					M('option')->where("id='$key' AND meta_key='parameter' AND type = 'pro'")->save($option);
				}
				$this->success('修改参数成功');
			}
			else
			{
				$this->error('参数错误！');
			}
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}

	public function pro_parameter_del($id)
	{
		if(mc_is_admin())
		{
			if(is_numeric($id))
			{
				M('option')->where("id='$id' AND meta_key='parameter' AND type='pro'")->delete();
				$this->success('删除参数成功');
			}
			else
			{
				$this->error('参数错误！');
			}
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}

	public function nav_del($id)
	{
		if(mc_is_admin())
		{
			if(is_numeric($id))
			{
				M('option')->where("id='$id' AND type='nav'")->delete();
				$this->success('删除导航成功');
			}
			else
			{
				$this->error('参数错误！');
			}
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}

	public function comment_delete($id)
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			if(is_numeric($id))
			{
				M('action')->where("id='$id' AND action_key='comment'")->delete();
				M('action')->where("action_value='$id' AND action_key='at'")->delete();
				$this->success('删除成功');
			}
			else
			{
				$this->error('参数错误！');
			}
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}

	public function publish_term()
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			if($_POST['title'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				$page['type'] = 'term_' . mc_magic_in($_POST['type']);
				$page['date'] = strtotime("now");
				$result = M('page')->data($page)->add();
				if($result)
				{
					if(is_numeric($_POST['parent']))
					{
						mc_add_meta($result, 'parent', $_POST['parent'], 'term');
					}
					;
					$this->success('新建分类成功！', U(mc_magic_in($_POST['type']) . '/index/term?id=' . $result));
				}
				else
				{
					$this->error('发布失败！');
				}
			}
			else
			{
				$this->error('请填写分类名称');
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	public function edit_term($id)
	{
		if((mc_is_admin() || mc_is_bianji()) && is_numeric($id))
		{
			if($_POST['title'])
			{
				$page['title'] = mc_magic_in($_POST['title']);
				M('page')->where("id='$id'")->save($page);
				$type = mc_get_page_field($id, 'type');
				if($type == 'term_pro')
				{
					if(is_numeric($_POST['parent']))
					{
						if($_POST['parent'] == $id)
						{
							$this->error('父分类不能为自己！');
						}
						else
						{
							if(mc_get_meta($id, 'parent', true, 'term'))
							{
								mc_update_meta($id, 'parent', $_POST['parent'], 'term');
							}
							else
							{
								mc_add_meta($id, 'parent', $_POST['parent'], 'term');
							}
						}
					}
					else
					{
						mc_delete_meta($id, 'parent', 'term');
					}
					;
					$type_name = 'pro';
				}
				elseif($type == 'term_baobei')
				{
					$type_name = 'baobei';
				}
				;
				$this->success('编辑分类成功！', U($type_name . '/index/term?id=' . $id));
			}
			else
			{
				$this->error('请填写分类名称');
			}
			;
		}
		else
		{
			$this->error('哥们，你放弃治疗了吗?', U('home/index/index'));
		}
		;
	}

	public function qiandao()
	{
		if(mc_is_qiandao())
		{
			$this->error('您已签到过了哦～');
		}
		else
		{
			if(mc_user_id())
			{
				$coins = 3;
				mc_update_coins(mc_user_id(), $coins);
				mc_add_action(mc_user_id(), 'coins', $coins);
				$this->success('签到成功！', U('home/index/index'));
			}
			else
			{
				$this->success('请先登陆', U('user/login/index'));
			}
		}
	}

	public function review($id)
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			$type = mc_get_page_field($id, 'type');
			if($type == 'pending')
			{
				mc_update_page($id, 'publish', 'type');
				$this->success('审核成功！', U('post/index/single?id=' . $id));
			}
			else
			{
				$this->error('未知页面类型');
			}
		}
		else
		{
			$this->error('管理员和网站编辑才有权审核！');
		}
	}
	
	// 用户发布项目审核通过--pope
	public function review_pro($id)
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			$type = mc_get_page_field($id, 'type');
			if($type == 'pro_pending')
			{
				mc_update_page($id, 'pro', 'type');
				$this->success('项目审核成功！', U('pro/index/single?id=' . $id));
			}
			else
			{
				$this->error('未知页面类型');
			}
		}
		else
		{
			$this->error('管理员和网站编辑才有权审核！');
		}
	}

	public function review_article($id)
	{
		if(mc_is_admin() || mc_is_bianji())
		{
			$type = mc_get_page_field($id, 'type');
			if($type == 'article_pending')
			{
				mc_update_page($id, 'article', 'type');
				$this->success('项目审核成功！', U('article/index/single?id=' . $id));
			}
			else
			{
				$this->error('未知页面类型');
			}
		}
		else
		{
			$this->error('管理员和网站编辑才有权审核！');
		}
	}

	public function delete($id)
	{
		if(is_numeric($id))
		{
			// 作者本人和管理员(编辑)可以删除--pope
			if(mc_is_admin() || mc_is_bianji() || (mc_user_id() == mc_author_id($id)))
			{
				if(mc_get_meta($id, 'user_level', true, 'user') != 10)
				{
					mc_delete_page($id);
					$this->success('删除成功', U('Home/index/index'));
				}
				else
				{
					$this->error('请不要伤害管理员');
				}
				;
			}
			else
			{
				$this->error('作者本人和管理员可以删除！', U('Home/index/index'));
			}
		}
		else
		{
			$this->error('参数错误！');
		}
	}

	public function delete_img($id)
	{
		if(is_numeric($id))
		{
			if(mc_is_admin())
			{
				if(mc_get_meta($id, 'user_level', true, 'user') != 10)
				{
					$src = M('attached')->where("id='$id'")->getField('src');
					M('attached')->where("id='$id'")->delete();
					unlink($src);
					$this->success('删除成功');
				}
				;
			}
			else
			{
				$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
			}
		}
		else
		{
			$this->error('参数错误！');
		}
	}
	
	// 删除所有未使用的图片(查询数据库的方式)--pope
	public function delete_img_nouser()
	{
		if(mc_is_admin())
		{
			$all_attacheds = M('attached')->select();
			foreach($all_attacheds as $val)
			{
				$condition_page['content'] = array(
						'like',
						"%{$val['src']}%"
				);
				$page_images = M('page')->where($condition_page)->getField('id');
				$condition_meta['meta_value'] = array(
						'like',
						"%{$val['src']}%"
				);
				$meta_images = M('meta')->where($condition_meta)->getField('id');
				$condition_option['meta_value'] = array(
						'like',
						"%{$val['src']}%"
				);
				$option_images = M('option')->where($condition_option)->getField('id');
				$image_used = $page_images + $meta_images + $option_images;
				if($image_used <= 0)
				{ // 图片未使用删除--pope
					$id = $val['id'];
					M('attached')->where("id='$id'")->delete();
					unlink($val['src']);
					print '<pre>';
					print_r('删除' . $val['src']);
					print '</pre>';
				}
			}
			$this->success('删除所有未使用图片成功！');
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}
	
	// 删除所有未使用的图片(遍历文件夹public的方式,慎用！)--pope
	public function delete_img_nouser_files()
	{
		if(mc_is_admin())
		{
			$all_attacheds = array();
			list_dir('Public', $all_attacheds);
			foreach($all_attacheds as $val)
			{
				$condition_attached['src'] = array(
						'like',
						"%{$val}"
				);
				$attached_images = M('attached')->where($condition_attached)->getField('id');
				$condition_page['content'] = array(
						'like',
						"%{$val}%"
				);
				$page_images = M('page')->where($condition_page)->getField('id');
				$condition_meta['meta_value'] = array(
						'like',
						"%{$val}%"
				);
				$meta_images = M('meta')->where($condition_meta)->getField('id');
				$condition_option['meta_value'] = array(
						'like',
						"%{$val}%"
				);
				$option_images = M('option')->where($condition_option)->getField('id');
				$image_used = $attached_images + $page_images + $meta_images + $option_images;
				if($image_used <= 0)
				{ // 图片未使用且不在attached表中的 删除--pope
					unlink($val);
					print '<pre>';
					print_r('删除' . $val);
					print '</pre>';
				}
			}
			$this->success('删除所有未使用图片成功！');
		}
		else
		{
			$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
		}
	}

	public function ip_false($id)
	{
		if(is_numeric($id))
		{
			if(mc_is_admin())
			{
				if(mc_get_meta($id, 'user_level', true, 'user') != 10)
				{
					$ip_array = M('action')->where("page_id='$id' AND action_key='ip'")->getField('action_value', true);
					if($ip_array)
					{
						foreach($ip_array as $ip)
						{
							mc_add_option('ip_false', $ip, 'user');
						}
						;
					}
					;
					mc_delete_page($id);
					$this->success('操作成功', U('Home/index/index'));
				}
				else
				{
					$this->error('请不要伤害管理员');
				}
				;
			}
			else
			{
				$this->error('哥们，请不要放弃治疗！', U('Home/index/index'));
			}
		}
		else
		{
			$this->error('参数错误！');
		}
	}
}
