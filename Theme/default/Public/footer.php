<footer>
	<P>
	<?php $site_url = mc_site_url();?>
		<A href="<?php echo $site_url;?>" target=_blank>关于我们</A> | <A
			href="<?php echo $site_url;?>" target=_blank>广告投放</A> | <A
			href="<?php echo $site_url;?>" target=_blank>版权声明</A> | <A
			href="<?php echo $site_url;?>" target=_blank>免责声明</A> | <A
			href="<?php echo $site_url;?>" target=_blank>网站地图</A> | <A
			href="tencent://message/?uin=1942118250&Site=sj33.cn&Menu=yes"
			target=blank>QQ在线交谈</A>
	</P>
	<P class=tj>
		版权所有 2015 <a href="http://www.triplehour.com">成都三方时刻商务信息咨询有限公司(www.triplehour.com)</a> <a href="http://www.miitbeian.gov.cn" target="_blank">蜀ICP备15013146</a><br>Copyright © 2015
		www.triplehour.com All rights reserved.
	</P>
</footer>
<a id="backtotop" class="goto" href="#site-top"><i
	class="glyphicon glyphicon-upload"></i></a>
<?php mc_template('Public/control'); ?>
</body>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo mc_theme_url(); ?>/js/bootstrap.min.js"></script>
<?php if(mc_option('homehdys')==2 && MODULE_NAME=='Home') : ?>
<?php else : ?>
<script src="<?php echo mc_theme_url(); ?>/js/headroom.min.js"></script>
<!-- 导航栏自动隐藏--pope -->
<!--  
<script>
(function() {
    var header = new Headroom(document.querySelector("#topnav"), {
        tolerance: 5,
        offset : 205,
        classes: {
          initial: "animated",
          pinned: "slideDown",
          unpinned: "slideUp"
        }
    });
    header.init();
}());
</script>
-->
<?php endif; ?>
<script src="<?php echo mc_theme_url(); ?>/js/placeholder.js"></script>
<script type="text/javascript">
	$(function() {
		$('input, textarea').placeholder();
	});
</script>
<script src="<?php echo mc_theme_url(); ?>/js/cat.js"></script>
<?php echo mc_xihuan_js(); ?>
<?php echo mc_shoucang_js(); ?>
<?php echo mc_guanzhu_js(); ?>
</html>