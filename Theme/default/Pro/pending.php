<?php mc_template_part('header'); ?>
<div class="container">
	<ol class="breadcrumb mb-20 mt-20" id="baobei-term-breadcrumb">
		<li class="hidden-xs"><a href="<?php echo mc_site_url(); ?>"> 首页 </a>
		</li>
			<?php if(MODULE_NAME=='Home') : ?>
			<li class="hidden-xs">待审核项目</li>
		<li class="active hidden-xs">
				搜索 - <?php echo $_GET['keyword']; ?>
			</li>
			<?php else : ?>
			<li class="active hidden-xs">项目</li>
			<?php endif; ?>
			<div class="pull-right">
				<?php if(mc_is_admin() || mc_is_bianji()) : ?>
				<a href="javascript:;" class="publish">等待审核项目(<?php echo $count; ?>)</a>
				<a href="#" data-toggle="modal" data-target="#parameterModal">项目参数</a>
			    <a href="#" data-toggle="modal" data-target="#addtermModal">添加分类</a>
			    <a href="<?php echo U('publish/index/index'); ?>" class="publish">管理员发布项目</a>
				<?php endif; ?>
			</div>
		<div class="clearfix"></div>
	</ol>
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
					<?php if($terms_pro) : ?>
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
<div class="modal fade" id="parameterModal" tabindex="-1" role="dialog"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
				<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : ?>
				<form role="form" method="post"
				action="<?php echo U('home/perform/pro_parameter_edit'); ?>">
				<div class="modal-body">
					<div class="form-group">
						<label> 参数列表 </label>
						<?php foreach($parameter as $par) : ?>
						<div class="input-group">
							<input type="text" class="form-control"
								value="<?php echo $par['meta_value']; ?>"
								name="parameter[<?php echo $par['id']; ?>]"> <span
								class="input-group-addon" data-dismiss="modal"
								data-toggle="modal" data-target="#delparameterModal"
								data-par-id="<?php echo $par['id']; ?>"> <i class="icon-remove"></i>
							</span>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning btn-block">
						<i class="glyphicon glyphicon-ok"></i> 保存
					</button>
				</div>
			</form>
				<?php endif; ?>
				<form role="form" method="post"
				action="<?php echo U('home/perform/pro_parameter'); ?>">
				<div class="modal-body">
					<div class="form-group">
						<label> 参数名称 </label> <input name="parameter" type="text"
							class="form-control" placeholder="">
					</div>
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
<div class="modal fade" id="delparameterModal" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">删除操作无法撤销，请务必谨慎！</div>
			<div class="modal-footer">
				<form method="post"
					action="<?php echo U('home/perform/pro_parameter_del'); ?>">
					<button type="submit" class="btn btn-warning btn-block">
						<i class="glyphicon glyphicon-ok"></i> 确认删除
					</button>
					<input type="hidden" name="id" value="">
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script>
		$('#parameterModal').on('show.bs.modal', function (e) {
			$('#parameterModal .input-group-addon').click(function(){
				var id = $(this).attr('data-par-id');
				$('#delparameterModal input').val(id);
			});
		})
	</script>
<?php endif; ?>
<?php mc_template_part('footer'); ?>