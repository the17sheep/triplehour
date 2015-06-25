<?php mc_template_part('header'); ?>
<div class="container">
	<ol class="breadcrumb mb-20 mt-20" id="baobei-term-breadcrumb">
		<li class="hidden-xs"><a href="<?php echo mc_site_url(); ?>"> 首页 </a>
		</li>
		<li class="hidden-xs"><a href="<?php echo U('pro/index/index'); ?>">
				项目 </a></li>
			<?php $parent = mc_get_meta($id,'parent',true,'term'); if($parent) : ?>
			<li class="hidden-xs"><a
			href="<?php echo U('pro/index/term?id='.$parent); ?>">
					<?php echo mc_get_page_field($parent,'title'); ?>
				</a></li>
			<?php endif; ?>
			<li class="active hidden-xs">
				<?php echo mc_get_page_field($id,'title'); ?>
			</li>
		<div class="pull-right">
				<?php if(mc_is_admin() || mc_is_bianji()) : ?>
				<a class="hidden-xs" href="#" data-toggle="modal"
				data-target="#addtermModal">添加分类</a> <a href="#" data-toggle="modal"
				data-target="#edittermModal">编辑分类</a> <a href="#"
				data-toggle="modal" data-target="#deltermModal">删除分类</a> <a
				class="hidden-xs" href="<?php echo U('publish/index/index'); ?>"
				class="publish">发布项目</a>
				<?php endif; ?>
			</div>
		<div class="clearfix"></div>
	</ol>
		<?php
if ($parent == '')
:
    $args_id_t = M('meta')->where(
            "meta_key='parent' AND meta_value='$id' AND type='term'")->getField(
            'page_id', true);
    $condition_t['id'] = array(
            'in',
            $args_id_t
    );
    $condition_t['type'] = 'term_pro';
    $terms_pro_t = M('page')->where($condition_t)
        ->order('id desc')
        ->select();
    if ($terms_pro_t)
    :
        ?>
		<ul class="nav nav-pills mb-10 term-list" role="tablist">
		<?php foreach($terms_pro_t as $val) : ?>
			<li role="presentation"><a
			href="<?php echo U('pro/index/term?id='.$val['id']); ?>">
					<?php echo $val['title']; ?>
				</a></li>
		<?php endforeach; ?>
		</ul>
		<?php endif; endif; ?>
		<div class="row" id="pro-list">
			<?php foreach($page as $val) : ?>
			<div class="col-sm-6 col-md-4 col-lg-3 col">
			<div class="thumbnail">
								<?php $fmimg_args = mc_get_meta($val['id'],'fmimgcover',false); $fmimg_args = array_reverse($fmimg_args); ?>
								<a class="img-div" href="<?php echo mc_get_url($val['id']); ?>"><img
					src="<?php echo $fmimg_args[0]; ?>"
					alt="<?php echo mc_get_page_field($val['id'],'title'); ?>"></a>
				<div class="caption">
					<h4 class="mt-0">
						<a href="<?php echo mc_get_url($val['id']); ?>"><?php echo mc_get_page_field($val['id'],'title'); ?></a>
					</h4>
					<div class="price pull-left">
						<small>预计投资:</small><span><?php echo sprintf("%.2f",mc_get_meta($val['id'], 'tol_price')/10000); ?></span>
						<small>万</small>
					</div>
					<a
						href="<?php echo U('pro/index/index?province='.mc_get_meta($val['id'], 'pro_province')); ?>">
						<button type="button" class="btn btn-warning btn-xs pull-right">
									<?php echo mc_get_meta($val['id'], 'pro_province');?>
								</button>
					</a>
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
		</div>
			<?php endforeach; ?>
		</div>
		<?php echo mc_pagenavi($count,$page_now); ?>
	</div>
<?php if(mc_is_admin() || mc_is_bianji()) : ?>
<!-- Modal -->
<div class="modal fade" id="addtermModal" tabindex="-1" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<form role="form" method="post"
				action="<?php echo U('home/perform/publish_term'); ?>">
				<div class="modal-body">
					<div class="form-group">
						<label> 分类名称 </label> <input name="title" type="text"
							class="form-control" placeholder="">
					</div>
					<?php
    $args_id = M('meta')->where(
            "meta_key='parent' AND meta_value>'0' AND type='term'")->getField(
            'page_id', true);
    if ($args_id)
    :
        $condition['id'] = array(
                'not in',
                $args_id
        );
    
    
    
					endif;
    $condition['type'] = 'term_pro';
    $terms_pro = M('page')->where($condition)
        ->order('id desc')
        ->select();
    if ($terms_pro)
    :
        ?>
					<div class="form-group">
						<label> 父级分类 </label> <select name="parent" class="form-control">
							<option>无父级分类...</option>
							<?php foreach($terms_pro as $val) : ?>
							<option value="<?php echo $val['id']; ?>">
								<?php echo $val['title']; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php endif; ?>
					<input type="hidden" name="type" value="pro">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-block">
						<i class="glyphicon glyphicon-ok"></i> 保存
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="edittermModal" tabindex="-1" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<form role="form" method="post"
				action="<?php echo U('home/perform/edit_term'); ?>">
				<div class="modal-body">
					<div class="form-group">
						<label> 分类名称 </label> <input name="title" type="text"
							class="form-control"
							value="<?php echo mc_get_page_field($id,'title'); ?>"
							placeholder="">
					</div>
					<?php if(!$terms_pro_t) : if($terms_pro) : ?>
					<div class="form-group">
						<label> 父级分类 </label> <select name="parent" class="form-control">
							<option>无父级分类...</option>
							<?php foreach($terms_pro as $val) : ?>
							<?php if($id!=$val['id']) : ?>
							<option value="<?php echo $val['id']; ?>"
								<?php if($parent==$val['id']) echo 'selected'; ?>>
								<?php echo $val['title']; ?>
							</option>
							<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>
					<?php endif; else : ?>
					<p>此分类已为父级分类</p>
					<?php endif; ?>
					<input type="hidden" name="id" value="<?php echo $id; ?>">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-block">
						<i class="glyphicon glyphicon-ok"></i> 保存
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="deltermModal" tabindex="-1" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body text-center">
				<p>确认要删除这个分类吗？</p>
				注意：当前分类下的所有项目都会被删除！
			</div>
			<div class="modal-footer" style="text-align: center;">
				<form method="post" action="<?php echo U('home/perform/delete'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
					<input type="hidden" name="id" value="<?php echo $id; ?>">
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php endif; ?>
<?php mc_template_part('footer'); ?>