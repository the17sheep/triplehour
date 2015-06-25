<?php

namespace User\Controller;

use Think\Controller;

class RegisterController extends Controller
{
	// 我们的
	public function index()
	{
		if(mc_user_id())
		{
			$this->success('您已经登陆', U('user/index/edit?id=' . mc_user_id()));
		}
		else
		{
			$this->theme(mc_option('theme'))->display('User/register');
		}
	}

	public function submit()
	{
		$ip_false = M('option')->where("meta_key='ip_false' AND type='user'")->getField('meta_value', true);
		if($ip_false && in_array(mc_user_ip(), $ip_false))
		{
			$this->error('您的IP被永久禁止登陆！');
		}
		else
		{
			if(!check_verify($_POST['tp_verify']))
			{
				$this->error("验证码输入错误！");
			}
			else
			{
				if(empty($_POST['user_name']))
				{
					$this->error('账号必须填写！');
				}
				else
				{
					if(validate_string_len($_POST['user_name'], 1, 16))
					{
						$user_login = M('meta')->where("meta_key='user_name' AND type ='user'")->getField('meta_value', true);
						if(in_array(strip_tags($_POST['user_name']), $user_login))
						{
							$this->error('账号已存在！');
						}
					}
					else
					{
						$this->error('用户名长度不合法(1-16)！');
					}
				}
				;
				if(empty($_POST['user_email']))
				{
					$this->error('邮箱必须填写！');
				}
				else
				{
					if(validate_email($_POST['user_email']))
					{
						$user_email = M('meta')->where("meta_key='user_email' AND type ='user'")->getField('meta_value', true);
						if(in_array(strip_tags($_POST['user_email']), $user_email))
						{
							$this->error('邮箱已存在！');
						}
					}
					else
					{
						$this->error("您输入的电子邮件地址不合法!");
					}
				}
				;
				if(empty($_POST['user_pass']))
				{
					$this->error('密码必须填写！');
				}
				else
				{
					if(!validate_string_len($_POST['user_pass'], 4, 16))
					{
						$this->error("密码长度为4-16!");
					}
				}
				;
				if(!validate_string_len($_POST['user_pass2'], 4, 16))
				{
					$this->error("密码长度为4－16!");
				}
				else
				{
					if($_POST['user_pass'] != $_POST['user_pass2'])
					{
						$this->error('两次密码必须一致！');
					}
				}
				;
				$user['title'] = I('param.user_name');
				$user['content'] = '';
				$user['type'] = 'user';
				$user['date'] = strtotime("now");
				$result = M("page")->data($user)->add();
				if($result)
				{
					mc_add_meta($result, 'user_name', I('param.user_name'), 'user');
					$user_pass = md5(I('param.user_pass') . mc_option('site_key'));
					mc_add_meta($result, 'user_pass', $user_pass, 'user');
					mc_add_meta($result, 'user_email', I('param.user_email'), 'user');
					mc_add_meta($result, 'user_level', '1', 'user');
					session('user_name', I('param.user_name'));
					session('user_pass', $user_pass);
					$ip_array = M('action')->where("page_id='" . mc_user_id() . "' AND action_key='ip'")->getField('action_value', true);
					if($ip_array && in_array(mc_user_ip(), $ip_array))
					{
					}
					else
					{
						if(!mc_is_admin())
						{
							mc_add_action(mc_user_id(), 'ip', mc_user_ip());
						}
						;
					}
					;
					if($_POST['comefrom'])
					{
						$this->success('注册成功', $_POST['comefrom']);
					}
					else
					{
						$this->success('注册成功', U('user/index/edit?id=' . mc_user_id()));
					}
				}
				else
				{
					$this->error('注册失败');
				}
			}
		}
	}
}