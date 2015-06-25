<?php mc_template_part('header'); ?>
<div class="container">
		<?php mc_template_part('head-control-nav'); ?>
		<div class="home-main" id="images">
		<div class="row">
			<button class="btn btn-default pull-right mt-20 mr-20"
				style="background-color: red;" data-toggle="modal"
				data-target="#myModal">
				<i class="glyphicon glyphicon-trash"></i> 删除所有未使用的图片
			</button>
			<button class="btn btn-default pull-right mt-20 mr-20"
				style="background-color: red;" data-toggle="modal"
				data-target="#myModalByFile">
				<i class="glyphicon glyphicon-trash"></i> 删除不在attached表中未使用的图片(慎用)
			</button>
		</div>
		<div class="row">
				<?php foreach($content as $val) : ?>
				<div class="col-sm-6 col-md-4 col-lg-3 col mt-20">
				<div class="img-div">
					<img src="<?php echo $val['src']; ?>">
				</div>
					<?php
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
        ?>
					<?php if($image_used>0) : ?>
					<a class="btn btn-default btn-block btn-sm" href="javascript:;">图片使用中</a>
					<?php else : ?>
					<form method="post"
					action="<?php echo U('home/perform/delete_img'); ?>">
					<button type="submit" class="btn btn-warning btn-block btn-sm">
						未使用，删除！</button>
					<input type="hidden" name="id" value="<?php echo $val['id']; ?>">
				</form>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<?php echo mc_pagenavi($count,$page_now,20); ?>
		</div>
</div>
<?php if(mc_is_admin()): ?>
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
			<div class="modal-body text-center">确认要删除所有未使用的图片吗？</div>
			<div class="modal-footer" style="text-align: center;">
				<form method="post"
					action="<?php echo U('home/perform/delete_img_nouser'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="myModalByFile" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body text-center">确认要删除不在attached表中的图片吗？</div>
			<div class="modal-footer" style="text-align: center;">
				<form method="post"
					action="<?php echo U('home/perform/delete_img_nouser_files'); ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> 取消
					</button>
					<button type="submit" class="btn btn-danger">
						<i class="glyphicon glyphicon-ok"></i> 确定
					</button>
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