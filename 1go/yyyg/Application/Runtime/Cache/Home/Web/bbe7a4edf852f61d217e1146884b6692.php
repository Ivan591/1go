<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title><?php echo ($info['title']); ?> - <?php echo ($web_title); ?></title>
    <link href="<?php echo ($web_tplpath); ?>css/oenpay.css" rel="stylesheet">
    <link href="<?php echo ($web_tplpath); ?>activity/css/active.css" rel="stylesheet">
    <!--[if lt IE 8]>
	<style type="text/css">
		.searchs {float:left;width:620px}
		.searchs>form {float:left;width:608px;height:35px;display:block}
		.searchs>.hot-search {float:left;display:block;width:608px}
	</style>
	<![endif]-->
  </head>
  <body>
    
  	<!--[if lt IE 9]>
  	<div class="chrome">您的浏览器版本太低啦~请升级您的浏览器。本站推荐<a href="http://liulanqi.baidu.com/" class="a1" target="_blank">百度浏览器</a> <a href="http://liulanqi.baidu.com/" class="a1" target="_blank">点击下载</a></div>
<![endif]-->
<div class="top-line">
	<div class="g-wrap">
		<div class="tl-left">欢迎来到<?php echo ($web_title); ?>！</div>
		<div class="tl-right">
			<?php if(isset($_SESSION['hx_users']['user_auth'])): ?><a href="<?php echo U('user/index');?>"><?php echo ($username); ?></a> 
			<a href="<?php echo U('user/index');?>">我的夺宝</a>
			<a href="<?php echo U('public/logout');?>">[ 退出 ]</a>
			<?php else: ?>
			<a href="<?php echo U('public/login');?>">请登录</a> 
			<a href="<?php echo U('public/reg');?>">免费注册</a><?php endif; ?>
		</div>
	</div>
</div>
<div class="top-back">
	<!-- LOGO 开始 -->
  	<div class="container">
		<div class="logos">
			<div class="logo"><img src="<?php echo ($web_logo); ?>" /></div>
			<div class="top-people"></div>
		</div>
  	</div>
	<!-- LOGO 结束 -->
	<!-- 导航开始 -->
	<div class="navbar category">
		<div class="container sNav">
			<div class="navbar-all-class class-hidden">
  				<a href="#">全部商品分类</a>
  				<div class="left-class left-cl-hidden">
	  				<a href="<?php echo U('list/index/');?>"><span class="icon icon-star-empty"></span>全部商品</a>
	  				<?php $_result=R('list/type');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('list/index/?id='.$vo['id']);?>"><span class="<?php echo ($vo['icon']); ?>"></span><?php echo ($vo['title']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
  			</div>
			<div class="navbar-class"><a href="<?php echo U('index/index');?>">首页</a></div>
			<div class="navbar-class"><a href="<?php echo U('user/announced');?>">最新揭晓</a></div>
			<?php $_result=R('ten/ten');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="navbar-class"><a href="<?php echo U('ten/index',array('ten'=>$vo['id']));?>"><?php echo ($vo['title']); ?></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="navbar-class"><a href="<?php echo U('user/displays');?>">晒单分享</a></div>
			<div class="navbar-class navbar-message"><a href="<?php echo U('activity/index');?>">发现</a></div>
			<div class="navbar-class"><a href="<?php echo U('user/guide');?>">新手引导</a></div>
			<?php if(isset($_GET['wid'])): if(!empty($menu_url)): ?><div class="navbar-class"><a href="<?php echo ($menu_url); ?>"><?php echo ($menu_name); ?></a></div><?php endif; endif; ?>
		</div>
	</div>
</div>
	<div class="top-images1 top-images6">
		<img src="<?php echo ($web_tplpath); ?>activity/images/active-02.jpg">
		
	</div>
	<div class="act-nav1 act-nav6">
		<div class="container">
			<div class="col50">
				<ul class="redme">
					<li class="text">您可以使用以下方式邀请好友，成功率更高哦！</li>
					<li class="bdsharebuttonbox">
						<a href="#" class="bds_qzone" data-cmd="sqq" title="分享到QQ空间"></a>
						<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
						<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
						<a href="#" class="bds_renren" data-cmd="qzone" title="分享到QQ空间"></a>
						<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
					</li>
				</ul>
			</div>
			<div class="col50">
				<ul class="redme">
					<li class="text text-center">您也可以复制专属邀请链接发送给好友！</li>
					<div class="invitetextarea">1元就能买iPhone 6S，一种很有意思的购物方式，快来看看吧！<?php echo ($web_url); ?>?id=<?php echo (UID); ?></div>
					<a href="#" onclick="copyText(document.all.invite_title)" class="invite-textarea-btn">复制</a>
				</ul>
			</div>
			<h1 class="h66">活动说明</h1>
			<ul class="redme h66">
				<li>一、 本活动时间为<span class="red"><?php echo time_format($info['end_time'],"Y-m-d");?>截止</span>。</li>
				<li>二、 每成功邀请一位好友注册并参与后，可获得<?php echo C('USER_INVITEL');?>%现金提成。在 邀请记录 可随时查看佣金明细及邀请记录。</li>
				<li>三、 佣金永久有效，满1元即可充值到伙购账户，满100元即可申请提现。</li>
				<li>四、将您专属邀请链接分享至微博、微信朋友圈、QQ空间等社交平台，也可直接复制邀请链接发送给您的好友。</li>
				<li>五、 严禁利用非法手段恶意获取佣金，一经查实，将立即冻结账号，扣除所有佣金。</li>
				<li>六、 活动最终解释权归<span class="red"><?php echo ($web_title); ?></span>所有。</li>
			</ul>
		</div>
	</div>
  	<div class="clear"></div>
  	<div class="bottom">
	<div class="container">
		<div class="bot-left">
			<h3>
				<span class="icon icon-leanpub"></span>
				新手指南
			</h3>
			<ul>
				<li><a href="<?php echo U('news/more/id/1');?>">了解<?php echo ($web_title); ?>平台</a></li>
				<li><a href="<?php echo U('news/more/id/2');?>">服务协议</a></li>
				<li><a href="<?php echo U('news/more/id/3');?>">常见问题</a></li>
				<li><a href="<?php echo U('news/more/id/4');?>">推广赚钱</a></li>
			</ul>
		</div>
		<div class="bot-left">
			<h3>
				<span class="icon icon-dunpai"></span>
				欢乐保障
			</h3>
			<ul>
				<li><a href="<?php echo U('news/more/id/5');?>">公平保障</a>
				</li>
				<li><a href="<?php echo U('news/more/id/6');?>">公正保障</a></li>
				<li><a href="<?php echo U('news/more/id/7');?>">公开保障</a></li>
				<li><a href="<?php echo U('news/more/id/8');?>">安全支付</a></li>
			</ul>
		</div>
		<div class="bot-left">
			<h3>
				<span class="icon icon-truck"></span>
				商品配送
			</h3>
			<ul>
				<li><a href="<?php echo U('news/more/id/9');?>">配送费用</a></li>
				<li><a href="<?php echo U('news/more/id/10');?>">商品验收与签收</a></li>
				<li><a href="<?php echo U('news/more/id/11');?>">发货未收到商品</a></li>
				<li><a href="<?php echo U('news/more/id/12');?>">商品配送</a></li>
			</ul>
		</div>
		<div class="bot-left">
			<h3>
				<span class="icon icon-github"></span>
				关于我们
			</h3>
			<ul>
				<li><a href="<?php echo U('news/more/id/13');?>">关于我们</a></li>
				<?php if(empty($_GET['wid'])): ?><li><a href="<?php echo U('news/more/id/14');?>">公司证件</a></li><?php endif; ?>
			</ul>
		</div>
		<div class="bot-right">
			<div class="bot-gongping">
				<span class="icon icon-zhngpin"></span> <i>100%正品保证</i>
			</div>
			<div class="bot-gongping">
				<span class="icon icon-gongpin"></span> <i>100%公平公正公开</i>
			</div>
			<div class="bot-gongping">
				<span class="icon icon-gongzheng"></span>
				<i>100%权益保障</i>
			</div>
		</div>

		<div class="copyright">
			Copyright &copy; 2015 <?php echo ($web_title); ?> <?php echo ($web_url); ?> 版权所有 <?php echo ($web_icp); ?>
		</div>
	</div>
</div>
	<script src="<?php echo ($web_tplpath); ?>js/jquery.min.js"></script>
	<script src="<?php echo ($web_tplpath); ?>js/copyToClipboard.js"></script>
	<script type="text/javascript">
		var uid="<?php echo (UID); ?>",
			text="1元就买了个腰子6，不信你就往前走，别回头。只要1元，进来了就不后悔，进来了就不上当。大到家用电器，小到针头线脑一律只要1元。1元就能实现梦想，走向人生巅峰迎娶百富美。";
		window._bd_share_config={"common":{"bdText":text,"bdDesc":text,"bdUrl":"{$web_url}/activity/content/id/57/uid/"+uid,"bdPic":"<?php echo ($web_url); ?>/wx-logo.png","bdSnsKey":{},"bdMini":"1","bdMiniList":false,"bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
	</script>
	<!--[if lt IE 9]>
	<script src="<?php echo ($web_tplpath); ?>js/jquery.pseudo.js"></script>
	<![endif]-->
  </body>
</html>