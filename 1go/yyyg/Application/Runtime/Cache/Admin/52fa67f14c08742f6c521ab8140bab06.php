<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="<?php echo C('WEB_SITE_KEYWORD');?>" name="keywords">
	<meta name="description" content="<?php echo C('WEB_SITE_DESCRIPTION');?>">
	<link rel="shortcut icon" href="/Public/Admin/images/favicon.png">
	<title><?php echo C('WEB_SITE_TITLE');?>--用户中</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/js/bootstrap/dist/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/fonts/font-awesome-4/css/font-awesome.min.css" />
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv-printshiv.js"></script>
		<![endif]-->
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/js/jquery.nanoscroller/nanoscroller.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/js/jquery.select2/select2.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/js/bootstrap.slider/css/slider.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/pygments.css" />
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" />
	
	<link rel="stylesheet" type="text/css" href="/Public/Admin/js/jquery.icheck/skins/square/blue.css" />

</head>
<body>
<!-- Fixed navbar -->
<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="fa fa-gear"></span> </button>
			<a class="navbar-brand" href="#"><span>综合管理后台</span></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right user-nav">
				<li class="dropdown profile_menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user fa-2x"></i> <span><?php echo session('user_auth.username');?></span> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo U('Member/password');?>">修改密码</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo U('public/logout');?>">退出</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<div id="cl-wrapper" class="fixed-menu">
	<div class="cl-sidebar">
		<div class="cl-toggle"><i class="fa fa-bars"></i></div>
		<div class="cl-navblock">
			<div class="menu-space">
				<div class="content">
					<!-- 子导航 -->
					
						<ul class="cl-vnavigation">
						<?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i; if(!empty($sub_menu)): if((count($sub_menu)) > "1"): ?><li><a href="#"><i class="<?php echo ($sub_menu[0]['icon']); ?>"></i><span><?php echo ($key); ?></span></a>
										<ul class="sub-menu"><?php endif; ?>
								<?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li><a href="<?php echo (u($menu["url"])); ?>"><?php if((count($sub_menu)) == "1"): ?><i class="<?php echo ($menu["icon"]); ?>"></i><span><?php endif; echo ($menu["title"]); if((count($sub_menu)) == "1"): ?></span><?php endif; ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
								<?php if((count($sub_menu)) > "1"): ?></ul>
									</li><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					
					<!-- /子导航 -->
				</div>
			</div>
			<div class="text-right collapse-button" style="padding:7px 9px;">
				<button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-left"></i></button>
			</div>
		</div>
	</div>
	
<div>
<div class="page-head">
	<h2>商城</h2>
</div>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12">
			<div class="block-flat">
			<form class="shop-form" method="post" action="<?php echo U('auto');?>">
				<div class="header">
					<h3 class="hthin"><?php echo ($meta_title); ?></h3>
				</div>
				<div class="content">
					<div class="col-sm-12">
						<div class="col-sm-2 no-padding">
						<input id="check-all" type="checkbox" name="checkall" style="position: absolute;">
						<a class="btn btn-success ajax-post" href="#" target-form="shop-form"><i class="fa fa-check-square"></i> 自动投注</a>
						</div>
						<label class="pull-left control-label">产品名称</label>
						<div class="col-sm-3">
							<input type="text" name="keyword" class="form-control">
						</div>
						<div class="col-sm-2">
							<button type="button" id="search" url="<?php echo U('index?category='.$_GET['category']);?>" class="btn btn-success">搜素</button>
						</div>
						<div class="pull-right">
							<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								选择专区 <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo U('index');?>">所有专区</a></li>
								<?php if(is_array($ten)): $i = 0; $__LIST__ = $ten;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('index?ten='.$vo['id']);?>"><?php echo ($vo["html"]); echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
							  </ul>
							</div>
							<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								选择分类 <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo U('index');?>">所有分类</a></li>
								<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('index?category='.$vo['id']);?>"><?php echo ($vo["html"]); echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
							  </ul>
							</div>
							<a class="btn btn-success" href="<?php echo U('add');?>" ><i class="fa fa-plus-square"></i> 添加内容</a>
						</div>
					</div>
					<table class="no-border blue">
						<thead class="no-border">
						<tr>
							<th style="width:5%;">选择</th>
							<th style="width:55%;">标题</th>
							<th style="width:10%;">分类</th>
							<th style="width:10%;">更新时间</th>
							<th style="width:10%;">自动投注</th>
							<th class="text-right">操作</th>
						</tr>
						</thead>
						<?php if(!empty($shoplist)): ?><tbody class="no-border-y">
						<?php if(is_array($shoplist)): $i = 0; $__LIST__ = $shoplist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td style="width:5%;"><input name="id[]" type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
							<td style="width:55%;"><a href="#" class="opiframe" url="<?php echo U('shop/period?id='.$vo['id'].'&price='.$vo['price']);?>"><?php echo ($vo['name']); ?></a><gt name="vo['ten']" value="0"><span class="color-danger" style="margin-left: 15px"><?php echo get_ten_name($vo['ten']);?></span><gt></td>
							<td style="width:10%;"><?php echo get_category_name($vo['category']);?></td>
							<td style="width:10%;"><?php echo (time_format($vo["update_time"],"Y-m-d")); ?></td>
							<td style="width:10%;"><?php if(($vo['auto']) == "1"): ?><i class="fa fa-check-square-o color-success"></i><?php else: ?><i class="fa fa-square-o"></i><?php endif; ?></td>
							<td class="text-right">
                           	 	<a data-placement="left" data-toggle="tooltip" data-original-title="下架" class="label <?php if(($vo["status"]) == "0"): ?>label-default<?php else: ?>label-warning<?php endif; ?> confirm no-refresh ajax-get status" callback="status(<?php echo ($i); ?>)" href="<?php echo U('status?id='.$vo['id']);?>"><i class="fa fa-ban"></i></a>
								<a data-placement="left" data-toggle="tooltip" data-original-title="修改" class="label label-primary" href="<?php echo U('edit?id='.$vo['id']);?>"><i class="fa fa-pencil"></i></a>
                				<!-- <a data-placement="left" data-toggle="tooltip" data-original-title="删除" class="label label-danger ajax-get" href="<?php echo U('del?id='.$vo['id']);?>"><i class="fa fa-times"></i></a> -->
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
						<?php else: ?>
						<td colspan="3"> aOh! 暂时还没有内容! </td><?php endif; ?>
					</table>
					<div class="content col-lg-12 pull-left">
                        <div class="panel-foot text-center">
                            <div class="page"><?php echo ($_page); ?></div>
                        </div>
					</div>
					<div class="clearfix"></div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
</div>

</div>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="/Public/Admin/js/bootstrap.switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.select2/select2.min.js"></script>
<script type="text/javascript" src="/Public/Static/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/js/behaviour/web.js"></script>
<script type="text/javascript" src="/Public/Admin/js/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="/Public/Admin/js/jquery.icheck/icheck.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			highlight_subnav('<?php echo U('Shop/index');?>');
		});
		//搜索功能
		$("#search").click(function(){
			var url = $(this).attr('url');
			var query = $(this).parents().prev().children('input').serialize();
	        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
	        query = query.replace(/^&/g,'');
	        if( url.indexOf('?')>0 ){
	            url += '&' + query;
	        }else{
	            url += '?' + query;
	        }
			window.location.href = url;
		});
		function status(i){
			$('.status:eq('+(i-1)+')').toggleClass('label-default').toggleClass('label-warning');
		}
		$('.opiframe').click(function(){
			layer.open({
				type: 2,
				title: $(this).attr('data-name'),
				shadeClose: true,
				maxmin: false, //开启最大化最小化按钮
				area: ['850px', '610px'],
				content: [$(this).attr('url'), 'no']
			});
		});
		$('input').iCheck({
            checkboxClass: 'icheckbox_square-blue checkbox',
            radioClass: 'icheckbox_square-blue'
        });
      
        $("#check-all").on('ifChanged',function(){
            var checkboxes = $("tr td").find(':checkbox');
            if($(this).is(':checked')) {
                checkboxes.iCheck('check');
            } else {
                checkboxes.iCheck('uncheck');
            }
        });
	</script>

</body>
</html>