<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="/Public/Admin/images/favicon.png">
<title>开奖期</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="/Public/Admin/js/bootstrap/dist/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/fonts/font-awesome-4/css/font-awesome.min.css" />
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv-printshiv.js"></script>
    <![endif]-->
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="/Public/Admin/js/jquery.nanoscroller/nanoscroller.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/pygments.css" />
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" />
</head>
<body>
<div class="block-flat">
	<div class="col-md-12">
		<div class="nano nscroller" style="height:500px;">
			<div class="content">
				<table class="no-border blue">
					<thead class="no-border">
					<tr>
						<th style="width:20%;">期号</th>
						<th style="width:20%;">状态</th>
						<th style="width:20%;">发布时间</th>
						<th>完成度</th>
					</tr>
					</thead>
					<?php if(!empty($periodlist)): ?><tbody class="no-border-y">
					<?php if(is_array($periodlist)): $i = 0; $__LIST__ = $periodlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td style="width:20%;"><?php echo ($vo['no']); ?></td>
						<td style="width:20%;"><?php echo (get_state($vo['state'])); ?></td>
						<td style="width:20%;"><?php echo (time_format($vo["create_time"],"Y-m-d H:i:s")); ?></td>
						<td>
							<?php switch($vo["state"]): case "0": ?><div class="progress">
									  <div class="progress-bar progress-bar-success" style="width: <?php echo ($vo['number']/$price*100); ?>%"><?php echo floor($vo['number']/$price*100);?>%</div>
									</div><?php break;?>
								<?php case "1": ?>开奖时间：<?php echo (time_format($vo["kaijang_time"],"Y-m-d H:i:s")); break;?>
								<?php default: ?>
									开奖号码：<?php echo ($vo["kaijang_num"]); ?> 中奖用户：<?php echo (get_user_name($vo['uid'])); endswitch;?>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<?php else: ?>
					<td colspan="4"> aOh! 暂时还没有内容! </td><?php endif; ?>
				</table>
			</div>
		</div>
		<div class="text-center spacer">
			<div class="page"><?php echo ($_page); ?></div>
    	</div>
	</div>	
</div>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="/Public/Static/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/js/behaviour/web.js"></script>
<script type="text/javascript" src="/Public/Admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".nscroller").nanoScroller();
});
</script>
</html>