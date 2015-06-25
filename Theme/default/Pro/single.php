<?php mc_template_part('header'); ?>
<div id="pro-index-tlin">
					<?php $fmimg_args = mc_get_meta($page[0]['id'],'fmimg',false); $fmimg_args = array_reverse($fmimg_args); ?>
					<div id="carousel-example-generic" class="carousel slide"
		data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
							<?php foreach($fmimg_args as $fmimg) : ?>
							<?php $fmimg_num++; ?>
							<li data-target="#carousel-example-generic"
				data-slide-to="<?php echo $fmimg_num-1; ?>"
				class="<?php if($fmimg_num==1) echo 'active'; ?>"></li>
							<?php endforeach; ?>
						</ol>
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
							<?php $fmimg_num=0; ?>
							<?php foreach($fmimg_args as $fmimg) : ?>
							<?php $fmimg_num++; ?>
							<div class="item <?php if($fmimg_num==1) echo 'active'; ?>">
				<div class="imgshow">
					<a class="img-div" href="<?php echo mc_get_url($page[0]['id']); ?>"><img
						src="<?php echo $fmimg; ?>" alt="<?php echo $val['title']; ?>"></a>
				</div>
			</div>
							<?php endforeach; ?>
						</div>
	</div>
</div>
<?php foreach($page as $val) : ?>
<div class="container mt-10">
	<div class="row">
		<ol class="breadcrumb mt-0" id="baobei-breadcrumb">
			<li><a href="<?php echo mc_site_url(); ?>"> 首页 </a></li>
			<li><a href="<?php echo U('pro/index/index'); ?>"> 项目 </a></li>
			<?php $term_id = mc_get_meta($val['id'],'term'); $parent = mc_get_meta($term_id,'parent',true,'term'); if($parent) : ?>
			<li class="hidden-xs"><a
				href="<?php echo U('pro/index/term?id='.$parent); ?>">
					<?php echo mc_get_page_field($parent,'title'); ?>
				</a></li>
			<?php endif; ?>
			<li><a href="<?php echo U('pro/index/term?id='.$term_id); ?>">
					<?php echo mc_get_page_field($term_id,'title'); ?>
				</a></li>
			<li class="active hidden-xs">
				<?php echo $val['title']; ?>
			</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-8 col-lg-8  mb-20 mt-10">
			<div id="pro-single" class="row mb-20 bc-1-s-g">
				<div class="col-sm-12" id="single">
					<div id="entry">
					<?php echo mc_magic_out($val['content']); ?>
				</div>
					<hr>
					<div class="text-center">
					<?php if(!mc_is_admin() && !mc_is_bianji()) : ?>
					<?php echo mc_xihuan_btn($val['id']); ?>
					<?php echo mc_shoucang_btn($val['id']); ?>
					<?php else : ?>
					<a href="<?php echo U('publish/index/edit?id='.$val['id']); ?>"
							class="btn btn-info"> <i class="glyphicon glyphicon-edit"></i> 编辑
						</a>
						<button class="btn btn-default" data-toggle="modal"
							data-target="#myModal">
							<i class="glyphicon glyphicon-trash"></i> 删除
						</button>
					<?php endif; ?>
				</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-lg-4 mb-20 mt-10 pr-0">
			<div id="single-top pt-0">
				<div class="row">
					<div class="col-sm-12" id="pro-index-tr">
						<div id="pro-index-trin">
							<h2><?php echo $val['title']; ?></h2>
							<div class="thumbnail">
								<?php $fmimg_args = mc_get_meta($val['id'],'fmimgcover',false); $fmimg_args = array_reverse($fmimg_args); ?>
								<a class="img-div" href="<?php echo mc_get_url($val['id']); ?>"><img
									src="<?php echo $fmimg_args[0]; ?>"
									alt="<?php echo mc_get_page_field($val['id'],'title'); ?>"></a>
								<div class="caption">
									<div class="price pull-left mt-0">
										<small>预计投资:</small><span><?php echo sprintf("%.2f",mc_get_meta($val['id'], 'tol_price')/10000); ?></span>
										<small>万</small>
									</div>
									<button type="button" class="btn btn-warning btn-xs pull-right">
									<?php echo mc_get_meta($val['id'], 'pro_province');?>
								</button>
									<div class="clearfix"></div>
									<div class="pull-left mt-0 mb-0">
										<small class="">浏览:<?php echo mc_views_count($val['id']);?>次</small>
									</div>
									<div class="pull-right mt-0 mb-0">
										<small class="">喜欢:<?php echo mc_xihuan_count($val['id']);?>人</small>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="row pl-15 pr-15 mb-20">
								<table class="datalist-pro">
									<caption>项目信息</caption>
									<tr>
										<th>预计项目总资经</th>
										<td><?php echo mc_get_meta($val['id'],'tol_price'); ?></td>
										<td>元</td>
									</tr>
									<tr class="altrow">
										<th>资金分为多少份</th>
										<td><?php echo mc_get_meta($val['id'],'kucun'); ?></td>
										<td>份</td>
									</tr>
									<tr>
										<th>期望合伙人数</th>
										<td><?php echo mc_get_meta($val['id'],'partners'); ?></td>
										<td>人</td>
									</tr>
									<tr class="altrow">
										<th>项目上线天数</th>
										<td><?php echo mc_get_meta($val['id'],'days'); ?></td>
										<td>天</td>
									</tr>
									<tr>
										<th>最小合伙份数</th>
										<td><?php echo mc_get_meta($val['id'],'min_share'); ?></td>
										<td>份</td>
									</tr>
									<tr class="altrow">
										<th>已合伙份数</th>
										<td><?php echo mc_get_meta($val['id'],'xiaoliang'); ?></td>
										<td>份</td>
									</tr>
									<tr>
										<th>已合伙人数</th>
										<td><?php echo mc_get_meta($val['id'],'num_people'); ?></td>
										<td>人</td>
									</tr>
									<tr class="altrow">
										<th>剩余合伙人数</th>
										<td><?php echo mc_get_meta($val['id'],'partners')-mc_get_meta($val['id'],'num_people'); ?></td>
										<td>人</td>
									</tr>
									<tr>
										<th>剩余上线天数</th>
										<td><?php echo mc_get_meta($val['id'],'days') - ceil((time()-$val['date'])/(60*60*24)); ?></td>
										<td>天</td>
									</tr>
									<tr class="altrow">
										<th>每份额合伙金额</th>
										<td><?php echo ceil(mc_price_now($val['id'])); ?></td>
										<td>元</td>
									</tr>
									<tr>
										<th>已合伙总金额</th>
										<td><?php echo ceil(mc_get_meta($val['id'],'xiaoliang')*mc_get_meta($val['id'],'price')); ?></td>
										<td>元</td>
									</tr>
									<tr class="altrow">
										<th>还需合伙金额</th>
										<td><?php echo ceil(mc_get_meta($val['id'],'tol_price')-mc_get_meta($val['id'],'xiaoliang')*mc_get_meta($val['id'],'price')); ?></td>
										<td>元</td>
									</tr>
									<tr class="altrow">
										<th>项目发起人</th>
										<td colspan="2"><a
											href="<?php echo mc_get_url(mc_author_id($val['id']));?>"><?php echo mc_user_display_name(mc_author_id($val['id'])); ?></a></td>
									</tr>
								</table>
							</div>
							<div class="form-group">
						<?php if(mc_get_meta($val['id'],'kucun')<=0) : ?>
						<button type="button" class="btn btn-default">
									<i class="icon-umbrella"></i> 合伙成功已无份额
								</button>
						<?php else : ?>
						<?php $minshare=mc_get_meta($val['id'],'min_share'); ?>
						<div class="btn-group" style="TEXT-ALIGN: center; width: 100%;">
									<button type="button" class="dropdown-toggle"
										data-toggle="dropdown">
										合伙份额：<span id="buy-num"><?php echo $minshare;?></span> <span
											class="caret"> </span>
									</button>
									<ul class="dropdown-menu" role="menu">
									<?php $i=$minshare;  while ($i < mc_get_meta($val['id'],'kucun')){ $i++; ?>
									<li><a href="javascript:;">
											<?php echo $i; ?>
										</a></li>
									<?php }; ?>
								</ul>
								</div>
								<div class="btn-group mt-20" style="TEXT-ALIGN: center; width: 100%;">
									<form method="post"
										action="<?php echo U('home/perform/add_cart'); ?>"
										id="pro-single-form">
										<div class="form-group" style="TEXT-ALIGN: center;">
											<button type="submit" class="btn btn-warning wish1">
												<i class="icon-heart"></i> 我想要做这个项目
											</button>
										</div>
										<script>
						$('.add-cart').hover(function(){
							$('#pro-single-form').attr('action','<?php echo U('home/perform/add_cart'); ?>');
						});
						$('.wish1').hover(function(){
							$('#pro-single-form').attr('action','<?php echo U('publish/index/add_post?group='.$val['id'].'&wish=1'); ?>');
						});
					</script>

										<input id="buy-num-input" type="hidden" name="number"
											value="<?php echo $minshare;?>"> <input type="hidden"
											value="<?php echo $val['id']; ?>" name="id">
									</form>
								</div>
						<?php endif; ?>
					</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row pl-15 pr-15 mt-20">
				<div class="home-main">
					<div class="row mb-20">
						<div class="col-sm-12" id="post-list-default">
							<h4 class="title mb-10">
								<i class="icon-globe"></i>想做这个项目的合伙人<a class="pull-right"
									href="<?php echo U('post/group/single?id='.$val['id']); ?>"> <i
									class="icon-angle-right"></i>
								</a>
							</h4>
				<?php
    $condition['type'] = 'publish';
    $args_id = M('meta')->where(
            "meta_key='group' AND meta_value='" . $val['id'] . "'")->getField(
            'page_id', true);
    $condition['id'] = array(
            'in',
            $args_id
    );
    $page_group = M('page')->where($condition)
        ->order('date desc')
        ->limit(0, 5)
        ->select();
    if ($page_group)
    :
        ?>
				<ul class="list-group mb-0">
				<?php foreach($page_group as $val_group) : ?>
				<li class="list-group-item"
									id="mc-page-<?php echo $val_group['id']; ?>">
									<div class="row">
										<div class="col-sm-6 col-md-7 col-lg-8">
											<div class="media">
								<?php $author_group = mc_get_meta($val_group['id'],'author',true); ?>
								<a class="pull-left img-div"
													href="<?php echo mc_get_url($author_group); ?>"> <img
													width="40" class="media-object"
													src="<?php echo mc_user_avatar($author_group); ?>"
													alt="<?php echo mc_user_display_name($author_group); ?>">
												</a>
												<div class="media-body">
													<h4 class="media-heading">
														<a href="<?php echo mc_get_url($val_group['id']); ?>"><?php echo $val_group['title']; ?></a>
													</h4>
													<p class="post-info">
														<i class="glyphicon glyphicon-user"></i><a
															href="<?php echo mc_get_url($author_group); ?>"><?php echo mc_user_display_name($author_group); ?></a>
														<i class="glyphicon glyphicon-time"></i><?php echo date('Y-m-d H:i:s',$val_group['date']); ?>
									</p>
												</div>
											</div>
										</div>
										<div class="col-sm-6 col-md-5 col-lg-4 text-right">
											<ul class="list-inline">
							<?php if(mc_last_comment_user($val_group['id'])) : ?>
							<li>最后：<?php echo mc_user_display_name(mc_last_comment_user($val_group['id'])); ?></li>
							<?php endif; ?>
							<li>点击：<?php echo mc_views_count($val_group['id']); ?></li>
											</ul>
										</div>
									</div>
								</li>
				<?php endforeach; ?>
				</ul>
				<?php else : ?>
				<div id="nothing" class="mb-0">
								没有任何相关话题！<a rel="nofollow"
									href="<?php echo U('post/group/single?id='.$val['id']); ?>">发表新话题</a>
							</div>
				<?php endif; ?>
			</div>
					</div>
					<h4 class="title mb-0">
						<i class="icon-comments"></i> 项目评论
					</h4>
				</div>
				<div id="pro-single">
					<div class="col-sm-12 pt-0" id="single">
				<?php if(mc_user_id()) : ?>
				<form role="form" method="post"
							action="<?php echo U('home/perform/comment'); ?>">
							<div class="form-group">
								<textarea id="comment-textarea" name="content"
									class="form-control" rows="3" placeholder="请输入评论内容"></textarea>
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn-block btn-warning">
									<i class="glyphicon glyphicon-ok"></i> 提交
								</button>
							</div>
							<input type="hidden" name="id" value="<?php echo $val['id']; ?>">
						</form>
				<?php else : ?>
				<form role="form">
							<div class="form-group">
								<textarea id="comment-textarea" name="content"
									class="form-control" rows="3" placeholder="请输入评论内容" disabled></textarea>
								<p class="help-block">
									您必须在<a href="<?php echo U('user/login/index'); ?>">登陆</a>或<a
										href="<?php echo U('user/register/index'); ?>">注册</a>后，才可以发表评论！
								</p>
							</div>
						</form>
				<?php endif; ?>
				<?php if(mc_comment_count($val['id'])) : ?>
				<hr>
						<h3>全部评论（<?php echo mc_comment_count($val['id']); ?>）</h3>
						<hr>
				<?php echo W("Comment/index",array($val['id'])); ?>
				<?php endif; ?>
			</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php if(mc_is_admin() || mc_is_bianji() ): ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body text-center">确认要删除这个项目吗？</div>
			<div class="modal-footer" style="text-align: center;">
				<form method="post" action="<?php echo U('home/perform/delete'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
					<input type="hidden" name="id" value="<?php echo $val['id']; ?>">
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php endif; ?>
<?php endforeach; ?>
<!-- /.container  -->
<?php mc_template_part('footer'); ?>