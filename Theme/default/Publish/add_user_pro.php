<?php mc_template_part('header'); ?>
<link rel="stylesheet"
	href="<?php echo mc_site_url(); ?>/Kindeditor/themes/default/default.css" />
<form id="add_user_pro_form" role="form" method="post"
	action="<?php echo U('home/perform/publish_user_pro'); ?>">
	<div id="single-top">
		<div class="container pl-0">
			<ol class="breadcrumb hidden-xs mb-20 mt-20"
				id="baobei-term-breadcrumb">
				<li><a href="<?php echo U('home/index/index'); ?>"> 首页 </a></li>
				<li><a href="<?php echo U('pro/index/index'); ?>"> 项目 </a></li>
				<li class="active">用户发布项目</li>
				<div class="pull-right">
					<?php if(mc_is_admin()) : ?>
					<a href="<?php echo U('publish/index/index'); ?>" class="active">管理员发布项目</a>
					<?php endif; ?>
				</div>
			</ol>
			<div class="row">
				<div class="col-sm-12" id="pro-index-tl">
					<div id="pro-index-tlin">
						<div id="carousel-example-generic" class="carousel slide"
							data-ride="carousel">
							<ol class="carousel-indicators" id="publish-carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0"
									class="active"></li>
							</ol>
							<div class="carousel-inner" id="pub-imgadd">
								<div class="item active">
									<div class="imgshow ">
										<img src="<?php echo mc_theme_url(); ?>/img/upload.jpg"
											class="absolute-center">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container pt-0" id="pro-single">
		<div class="col-sm-8" id="single">
			<div id="entry">
				<div class="form-group">
					<textarea name="content" class="form-control" rows="3"
						placeholder="在这里添加项目的详细描述" required="required">在这里添加项目的详细描述</textarea>
				</div>
			</div>
			<div class="form-group">
				<input name="keywords" type="text" class="form-control"
					placeholder="关键词（Keywords），多个关键词以英文半角逗号隔开（选填）">
			</div>
			<div class="form-group">
				<textarea name="description" class="form-control" rows="3"
					placeholder="摘要（Description），会被搜索引擎抓取为网页描述（选填）"></textarea>
			</div>
			<div style="text-align: center;" class="form-group">
				<input type="text" id="tp_verify" name="tp_verify"
					class="form-control input-lg pull-left" style="width: 50%;"
					placeholder="验证码(必填)"> <img class="tp_verify" title=”点击刷新验证码”
					src="<?php echo mc_site_url().'/'.U('Home/Index/verify');?>" />
			</div>
			<button type="submit" class="btn btn-warning btn-block">
				<i class="glyphicon glyphicon-ok"></i> 提交
			</button>
		</div>
		<div class="col-sm-4" id="pro-index-tr">
			<div id="pro-index-trin">
				<div class="form-group">
					<label> 封面图片 </label>
					<div id="pub-imgcover">
						<img class="default-img"
							src="<?php echo mc_theme_url(); ?>/img/upload.jpg"> <input
							type="hidden" name="fmimgcover" value="">
					</div>
				</div>
				<h1>
					<textarea name="title" class="form-control"
						placeholder="请填写项目标题（必填项）"></textarea>
				</h1>
				<h3>
					<div class="row">
						<div class="col-sm-6">
							<select class="form-control" id="province" tabindex="4"
								runat="server" onchange="selectprovince(this);"
								name="pro_province" datatype="*" errormsg="必须选择项目所在的地区"></select>
						</div>
						<div class="col-sm-6">
							<select class="form-control" id="city" tabindex="4"
								disabled="disabled" runat="server" name="pro_city"></select>
						</div>
					</div>
					<script src="<?php echo mc_theme_url(); ?>/js/address.js"></script>
				</h3>
				<h3>
					<textarea name="brief" class="form-control"
						placeholder="请填写项目简要说明（必填项）"></textarea>
				</h3>
				<h3>
					<div class="row">
						<div class="input-group">

							<input name="tol_price" type="text" class="form-control"
								placeholder="请填写项目资金需求（必填项）"> <span class="input-group-addon"> 元
							</span>
						</div>
					</div>
				</h3>
				<h3>
					<div class="row">
						<div class="input-group">
							<input name="kucun" type="text" class="form-control"
								placeholder="请填写项目资金需求分为几份（必填项）"><span class="input-group-addon">
								份 </span>
						</div>
					</div>
				</h3>
				<h3>
					<div class="row">
						<div class="input-group">
							<input name="partners" type="text" class="form-control"
								placeholder="请填写期望合伙人数（必填项）"><span class="input-group-addon"> 人
							</span>
						</div>
					</div>
				</h3>
				<h3>
					<div class="row">
						<div class="input-group">
							<input name="days" type="text" class="form-control"
								placeholder="请填写项目上线天数（必填项）"><span class="input-group-addon"> 天</span>
						</div>
					</div>
				</h3>
				<input name="min_share" type="hidden" class="form-control" value="1"
					placeholder="请填写最小合伙份数"> <input name="xiaoliang" type="hidden"
					class="form-control" value="0" placeholder="请填写已合伙份数"> <input
					name="num_people" type="hidden" value="0" class="form-control"
					placeholder="请填写已合伙人数">
					<?php $parameter = M('option')->where("meta_key='parameter' AND type='pro'")->select(); if($parameter) : foreach($parameter as $par) : ?>
					<div class="form-group pro-parameter"
					id="pro-parameter-<?php echo $par['id']; ?>">
					<label><?php echo $par['meta_value']; ?></label>
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
				</div>
				<a id="pro-parameter-btn-<?php echo $par['id']; ?>" href="#"
					class="btn btn-block btn-default mb-10">+</a>
				<script>
						num = 2;
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
					<div class="form-group">
					<label> 请选择分类 </label> <select class="form-control" name="term">
							<?php $terms = M('page')->where('type="term_pro"')->order('id desc')->select(); ?>
							<?php foreach($terms as $val) : ?>
							<option value="<?php echo $val['id']; ?>">
								<?php echo $val['title']; ?>
							</option>
							<?php endforeach; ?>
						</select>
				</div>
			</div>
		</div>
	</div>
</form>
<style type="text/css">
#add_user_pro_form label.error {
	padding-left: 16px;
	margin-left: 2px;
	font-size: 14px;
	color: red;
}
</style>
<script src="<?php echo mc_theme_url(); ?>/js/jquery.validate.js"></script>
<script src="<?php echo mc_theme_url(); ?>/js/validate.pope.js"></script>
<script charset="utf-8"
	src="<?php echo mc_site_url(); ?>/Kindeditor/kindeditor-min.js"></script>
<script charset="utf-8"
	src="<?php echo mc_site_url(); ?>/Kindeditor/lang/zh_CN.js"></script>
<script>
var editor;
KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
		resizeType : 1,
		allowPreviewEmoticons : false,
		allowImageUpload : true,
		height : 1050,
		uploadJson : '<?php echo U('Publish/index/upload'); ?>',
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
					$('<li data-target="#carousel-example-generic" data-slide-to="'+index+'" class="active"></li>').appendTo('.carousel-indicators');
					editor.hideDialog();
				}
			});
		});
	});
});
</script>
<?php mc_template_part('footer'); ?>