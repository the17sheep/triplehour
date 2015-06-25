<?php mc_template_part('header'); ?>
<link rel="stylesheet"
	href="<?php echo mc_site_url(); ?>/Kindeditor/themes/default/default.css" />
<form role="form" method="post"
	action="<?php echo U('Home/perform/edit'); ?>">
	<div id="single-top">
		<div class="container pl-0">
			<ol class="breadcrumb hidden-xs mb-20 mt-20"
				id="baobei-term-breadcrumb">
				<li><a href="<?php echo U('home/index/index'); ?>"> 首页 </a></li>
				<li><a href="<?php echo U('pro/index/index'); ?>"> 项目 </a></li>
				<li class="active">管理员编辑项目</li>
				<div class="pull-right">
					<?php if(mc_is_admin()) : ?>
					<a href="<?php echo U('publish/index/index'); ?>" class="publish">发布项目</a>
					<?php endif; ?>
				</div>
			</ol>
			<div class="row">
				<div class="col-sm-12" id="pro-index-tl">
					<div id="pro-index-tlin">
						<div id="carousel-example-generic" class="carousel slide"
							data-ride="carousel">
							<ol class="carousel-indicators" id="publish-carousel-indicators"><?php $fmimg = mc_get_meta($_GET['id'],'fmimg',false); $fmimg = array_reverse($fmimg); foreach($fmimg as $val) : $num0++; ?><li
									data-target="#carousel-example-generic"
									data-slide-to="<?php echo $num0-1; ?>"
									class="<?php if($num0==1) echo 'active'; ?>"></li><?php endforeach; ?><li
									data-target="#carousel-example-generic"
									data-slide-to="<?php echo $num0; ?>"></li>
							</ol>
							<div class="carousel-inner" id="pub-imgadd">
							<?php if($fmimg) : ?>
							<?php foreach($fmimg as $val) : ?>
							<?php $num++; ?>
							<div class="item <?php if($num==1) echo 'active'; ?>">
									<div class="imgshow">
										<img src="<?php echo $val; ?>"><input type="hidden"
											name="fmimg[]" value="<?php echo $val; ?>">
									</div>
									<i class="glyphicon glyphicon-remove-circle"></i>
								</div>
							<?php endforeach; ?>
							<div class="item">
									<div class="imgshow">
										<img src="<?php echo mc_theme_url(); ?>/img/upload.jpg"
											class="absolute-center">
									</div>
								</div>
							<?php else : ?>
							<div class="item active">
									<div class="imgshow">
										<img src="<?php echo mc_theme_url(); ?>/img/upload.jpg"
											class="absolute-center">
									</div>
								</div>
							<?php endif; ?>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container" id="pro-single">
		<div class="col-sm-8" id="single">
			<div id="entry">
				<div class="form-group">
					<textarea name="content" class="form-control" rows="3"
						required="required"><?php echo mc_magic_out(mc_get_page_field($_GET['id'],'content')); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<input name="keywords" type="text" class="form-control"
					placeholder="关键词（Keywords），多个关键词以英文半角逗号隔开（选填）"
					value="<?php echo mc_get_meta($_GET['id'],'keywords'); ?>">
			</div>
			<div class="form-group">
				<textarea name="description" class="form-control" rows="3"
					placeholder="摘要（Description），会被搜索引擎抓取为网页描述（选填）"><?php echo mc_get_meta($_GET['id'],'description'); ?></textarea>
			</div>
			<button type="submit" class="btn btn-warning btn-block">
				<i class="glyphicon glyphicon-ok"></i> 提交
			</button>
		</div>
		<div class="col-sm-4" id="pro-index-tr">
			<div id="pro-index-trin">
			<?php $fmimgcover = mc_get_meta($_GET['id'],'fmimgcover');?>
				<div class="form-group pt-0">
					<label> 封面图片 </label>
					<div id="pub-imgcover">
						<img class="default-img"
							src="<?php if($fmimgcover) echo $fmimgcover; else echo mc_theme_url()."/img/upload.jpg"; ?>">
						<input type="hidden" name="fmimgcover"
							value="<?php echo $fmimgcover;?>">
					</div>
				</div>
				<div class="form-group">
					<label> 请填写项目标题 </label>
					<textarea name="title" class="form-control" placeholder="请填写项目标题"
						required="required"><?php echo mc_get_page_field($_GET['id'],'title'); ?></textarea>
				</div>
				<div class="form-group">
					<label> 请填写项目所在的地</label>
					<div class="row">
						<div class="col-sm-6">
							<select class="form-control" id="province" tabindex="4"
								runat="server" onchange="selectprovince(this);"
								name="pro_province" datatype="*" errormsg="必须选择项目所在的地区"
								required="required"></select>
						</div>
						<div class="col-sm-6">
							<select class="form-control" id="city" tabindex="4"
								disabled="disabled" runat="server" name="pro_city"></select>
						</div>
						<input type="hidden" name="old_province"
							value="<?php echo mc_get_meta($_GET['id'],'pro_province'); ?>" />
						<input type="hidden" name="old_city"
							value="<?php echo mc_get_meta($_GET['id'],'pro_city'); ?>" />
					</div>
					<script src="<?php echo mc_theme_url(); ?>/js/address.js"></script>
				</div>
				<div class="form-group">
					<label> 请填写项目简要说明</label>
					<textarea name="brief" class="form-control" placeholder="请填写项目简要说明"
						required="required"><?php echo mc_get_meta($_GET['id'],'brief'); ?></textarea>
				</div>
				<div class="form-group">
					<label> 请填写项目视频地址</label> <input name="vedio" type="text"
						class="form-control" placeholder="请填写项目视频地址"
						value="<?php echo mc_get_meta($_GET['id'],'vedio'); ?>">
				</div>
				<div class="form-group">
					<label> 项目资金需求</label>
					<div class="input-group">
						<input name="tol_price" type="number" class="form-control"
							placeholder="请填写项目资金需求"
							value="<?php echo mc_get_meta($_GET['id'],'tol_price'); ?>"
							required="required"> <span class="input-group-addon"> 元 </span>
					</div>
				</div>
				<div class="form-group">
					<label> 项目资金需求分为多少份</label>
					<div class="input-group">
						<input name="kucun" type="number" class="form-control"
							placeholder="请填写项目资金需求分为多少份"
							value="<?php echo mc_get_meta($_GET['id'],'kucun'); ?>"
							required="required"><span class="input-group-addon"> 份 </span>
					</div>
				</div>
				<div class="form-group">
					<label> 期望合伙人数</label>
					<div class="input-group">
						<input name="partners" type="number" class="form-control"
							placeholder="请填写期望合伙人数"
							value="<?php echo mc_get_meta($_GET['id'],'partners'); ?>"
							required="required"><span class="input-group-addon"> 人 </span>
					</div>
				</div>
				<div class="form-group">
					<label> 项目上线天数</label>
					<div class="input-group">
						<input name="days" type="number" class="form-control"
							placeholder="请填写项目上线天数"
							value="<?php echo mc_get_meta($_GET['id'],'days'); ?>"
							required="required"><span class="input-group-addon"> 天</span>
					</div>
				</div>
				<div class="form-group">
					<label> 选择分类 </label> <select class="form-control" name="term">
							<?php $terms = M('page')->where('type="term_pro"')->order('id desc')->select(); ?>
							<?php foreach($terms as $val) : ?>
							<option value="<?php echo $val['id']; ?>"
							<?php if(mc_get_meta($_GET['id'],'term')==$val['id']) echo 'selected'; ?>>
								<?php echo $val['title']; ?>
							</option>
							<?php endforeach; ?>
						</select>
				</div>
				<hr>
				<div class="form-group">
					<label> 最小合伙份数</label>
					<div class="input-group">
						<input name="min_share" type="number" class="form-control"
							placeholder="请填写最小合伙份数"
							value="<?php echo mc_get_meta($_GET['id'],'min_share'); ?>"
							required="required"> <span class="input-group-addon"> 份 </span>
					</div>
				</div>
				<div class="form-group">
					<label> 已合伙份数</label>
					<div class="input-group">
						<input name="xiaoliang" type="number" class="form-control"
							placeholder="请填写已合伙份数"
							value="<?php echo mc_get_meta($_GET['id'],'xiaoliang'); ?>"
							required="required"><span class="input-group-addon"> 份 </span>
					</div>
				</div>
				<div class="form-group">
					<label> 已合伙人数</label>
					<div class="input-group">
						<input name="num_people" type="number" class="form-control"
							placeholder="请填写已合伙人数"
							value="<?php echo mc_get_meta($_GET['id'],'num_people'); ?>"
							required="required"><span class="input-group-addon"> 人</span>
					</div>
				</div>
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : foreach($parameter as $par) : ?>
					<div class="form-group pro-parameter"
					id="pro-parameter-<?php echo $par['id']; ?>">
					<label><?php echo $par['meta_value']; ?></label>
						<?php $pro_parameter = mc_get_meta($_GET['id'],$par['id'],false,'parameter'); if($pro_parameter) : ?>
						<?php foreach($pro_parameter as $pro_par) : $num++; ?>
						<div class="row">
						<div class="col-sm-7">
							<div class="input-group">
								<input
									name="pro-parameter[<?php echo $par['id']; ?>][<?php echo $num; ?>][name]"
									type="text" class="form-control"
									value="<?php echo $pro_par; ?>" placeholder="参数"><span
									class="input-group-addon"><i class="icon-remove"></i></span>
							</div>
						</div>
						<div class="col-sm-5">
							<input
								name="pro-parameter[<?php echo $par['id']; ?>][<?php echo $num; ?>][price]"
								type="text" class="form-control mt-10"
								value="<?php echo M('meta')->where("page_id='".$_GET['id']."' AND meta_key='$pro_par' AND type ='price'")->getField('meta_value'); ?>"
								placeholder="加价">
						</div>
					</div>
						<?php endforeach; else : ?>
						<div class="row">
						<div class="col-sm-7">
							<input name="pro-parameter[<?php echo $par['id']; ?>][1][name]"
								type="text" class="form-control" placeholder="参数">
						</div>
						<div class="col-sm-5">
							<input name="pro-parameter[<?php echo $par['id']; ?>][1][price]"
								type="text" class="form-control" placeholder="加价">
						</div>
					</div>
						<?php endif; ?>
					</div>
				<a id="pro-parameter-btn-<?php echo $par['id']; ?>" href="#"
					class="btn btn-block btn-default mb-10">+</a>
				<script>
						num = <?php echo $num+1; ?>;
						$('#pro-parameter-btn-<?php echo $par['id']; ?>').click(function(){
							$('<div class="row row-par"><div class="col-sm-7"><div class="input-group"><input name="pro-parameter[<?php echo $par['id']; ?>]['+num+'][name]" type="text" class="form-control" placeholder="参数"><span class="input-group-addon"><i class="icon-remove"></i></span></div></div><div class="col-sm-5"><input name="pro-parameter[<?php echo $par['id']; ?>]['+num+'][price]" type="text" class="form-control mt-10" placeholder="加价"></div></div>').appendTo('#pro-parameter-<?php echo $par['id']; ?>');
							$('#pro-parameter-<?php echo $par['id']; ?> .input-group .input-group-addon').click(function(){
								$(this).parents('.row-par').remove();
							});
							num++;
							return false;
						});
						$('#pro-parameter-<?php echo $par['id']; ?> .input-group .input-group-addon').click(function(){
							$(this).parent('.input-group').parent('.col-sm-7').parent('.row').remove();
						});
					</script>
					<?php endforeach; endif; ?>
			</div>
		</div>
	</div>
	<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
</form>
<script charset="utf-8"
	src="<?php echo mc_site_url(); ?>/Kindeditor/kindeditor-min.js"></script>
<script charset="utf-8"
	src="<?php echo mc_site_url(); ?>/Kindeditor/lang/zh_CN.js"></script>
<script>
		function mc_fmimg_delete() {
			$('.item i').click(function(){
				var index = $(this).parent(".item").index()*1+1;
				$('#pub-imgadd .item:eq('+index +')').addClass('active');
				$(this).parent(".item").remove();
				$('.carousel-indicators li').last().remove();
			});
		};
		var editor;
		KindEditor.ready(function(K) {
			editor = K.create('textarea[name="content"]', {
				resizeType : 1,
				allowPreviewEmoticons : false,
				allowImageUpload : true,
				height : 670,
				uploadJson : '<?php echo mc_site_url(); ?>/upload.php',
				items : ["source", "|", "undo", "redo", "|", "preview", "print", "template", "code", "cut", "copy", "paste", "plainpaste", "wordpaste",
				         "|", "justifyleft", "justifycenter", "justifyright", "justifyfull", "insertorderedlist", "insertunorderedlist", "indent", "outdent", "subscript", "superscript", "clearhtml", "quickformat", "selectall", "|", "fullscreen", "/", "formatblock", "fontname", "fontsize", "|", "forecolor", "hilitecolor", "bold", "italic", "underline", "strikethrough", "lineheight", "removeformat", "|", "image", "multiimage", "flash", "media", "insertfile", "table", "hr", "emoticons", "baidumap", "pagebreak", "anchor", "link", "unlink", "|", "about"],
				afterChange : function() {
					K(this).html(this.count('text'));
				}
			});
		});
		KindEditor.ready(function(K) {
		    	var editor = K.editor({
					uploadJson : '<?php echo U('Publish/index/upload'); ?>',
					allowFileManager : true
				});
				K('#pub-imgcover').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							clickFn : function(url, title, width, height, border, align) {
								$('.default-img').attr('src',url);
								$('#pub-imgcover input').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});
					KindEditor.ready(function(K) {
				    	var editor = K.editor({
							uploadJson : '<?php echo U('Publish/index/upload'); ?>',
							allowFileManager : true
						});
						K('.imgshow').click(function() {
							editor.loadPlugin('image', function() {
								editor.plugin.imageDialog({
									showRemote : false,
									clickFn : function(url, title, width, height, border, align) {
										$('.item').removeClass('active');
										$('<div class="item active"><div class="imgshow"><img src="'+url+'"></div><input type="hidden" name="fmimg[]" value="'+url+'"></div>').prependTo('#pub-imgadd');
										var index = $('.carousel-indicators li').last().index()*1+1;
										$('<li data-target="#carousel-example-generic" data-slide-to="'+index+'"></li>').appendTo('.carousel-indicators');
										mc_fmimg_delete();
										editor.hideDialog();
									}
								});
							});
						});
					});
		$(document).ready(function(){
			mc_fmimg_delete();
		});
		</script>
<?php mc_template_part('footer'); ?>