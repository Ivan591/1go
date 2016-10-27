<?php if (!defined('THINK_PATH')) exit();  ?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>香肠一元购，一元任性买 ！-<?php echo $website_name; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo htmlspecialchars($site_config['website_desc']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($site_config['website_keyword']); ?>">
    <link rel="stylesheet" type="text/css" href="__static__/css/common.css" />
<link rel="stylesheet" type="text/css" href="__yyg__/css/common.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/font-awesome/css/font-awesome.min.css" />

    
<!--QQ登录验证-->
<meta property="qc:admins" content="277334636011673016763757" />
<link rel="stylesheet" type="text/css" href="__static__/css/index.css" />

    <script type="text/javascript" src="__static__/js/jquery.min.js"></script>
</head>
<body>
<div class="g-header">
    <div class="m-toolbar" >
    <div class="g-wrap f-clear">
        <div class="m-toolbar-l">
            <span class="m-toolbar-welcome"><?php echo (isset($conf['WEBSITE_WELCOME']) && ($conf['WEBSITE_WELCOME'] !== '')?$conf['WEBSITE_WELCOME']:'欢迎!'); ?></span>
        </div>
        <ul class="m-toolbar-r">
            <li class="m-toolbar-login">
                <?php if(is_user_login()): ?>

                <div id="pro-view-6"><a class="m-toolbar-login-btn" href="<?php echo dwz_filter('ucenter/index'); ?>"><?php echo get_user_nick_name(); ?></a>
                    <a href="javascript:" class="login_out">退出登录</a></div>
                <?php else: ?>
                <div id=""><a class="m-toolbar-login-btn" href="<?php echo dwz_filter('user/login'); ?>">请登录</a>
                    <a href="<?php echo dwz_filter('user/reg'); ?>" >免费注册</a></div>
                <?php endif; ?>
            </li>
            <li class="m-toolbar-myDuobao">
                <a class="m-toolbar-myDuobao-btn" href="<?php echo dwz_filter('ucenter/index'); ?>">我的夺宝
                    <i class="ico ico-arrow-gray-s ico-arrow-gray-s-down"></i></a>
                <ul class="m-toolbar-myDuobao-menu">
                    <li><a href="<?php echo dwz_filter('ucenter/deposer'); ?>">夺宝记录</a></li>
                    <li class="m-toolbar-myDuobao-menu-win"><a href="<?php echo dwz_filter('ucenter/luck'); ?>">幸运记录</a></li>
                    <!--<li class="m-toolbar-myDuobao-menu-mall"><a href="<?php echo dwz_filter('ucenter/index'); ?>">购买记录</a></li>-->
                    <!--<li class="m-toolbar-myDuobao-menu-gems"><a href="#">我的宝石</a></li>-->
                    <li><a href="<?php echo dwz_filter('pay/recharge'); ?>">账户充值</a></li>
                </ul>
            </li>
            <!--<li class="m-toolbar-myBonus"><a href="#">我的红包</a><var>|</var></li>-->
            <li><a href="<?php echo $site_config['website_sina_weibo']; ?>" target="_blank">
                <img width="16" height="13" style="float:left;margin:8px 3px 0 0;" src="__static__/img/icon_weibo_s.png">官方微博</a>
                <var>|</var>
            </li>
            <!--<li><a href="http://1.xiangchang.com/groups.do">官方交流群</a></li>-->
        </ul>
    </div>
</div>
    <script>
    function no_img(img){
        img.attr('src',$("#no_img_url").val());
        img.onerror=null;
    }
</script>
<div class="m-header">
    <div class="g-wrap f-clear">
        <div class="m-header-logo">
            <h1><a class="m-header-logo-link" href="/" style="background: url('<?php echo (isset($conf['WEBSITE_LOGO']) && ($conf['WEBSITE_LOGO'] !== '')?$conf['WEBSITE_LOGO']:''); ?>')">香肠一元购</a></h1>
            <div class="m-header-slogan">
                <a class="m-header-slogan-link" href="" target="_blank" style="height: 70px;">
                    <img src="<?php echo (isset($conf['WEBSITE_LOGO_SUB']) && ($conf['WEBSITE_LOGO_SUB'] !== '')?$conf['WEBSITE_LOGO_SUB']:''); ?>" style="height: 70px;"></a>
            </div>
        </div>

        <div class="w-miniCart" id="cart_list_fade_in">
            <a class="w-miniCart-btn" href="javascript:void(0);" data-pro="btn"><i class="ico ico-miniCart"></i>清 单
                <b class="w-miniCart-count" >
                    <i class="ico ico-arrow-white-solid ico-arrow-white-solid-l"></i><p id="cart_num"><?php echo (isset($cart_num) && ($cart_num !== '')?$cart_num:'0'); ?></p></b>
            </a>
            <div class="w-layer w-miniCart-layer" style="display: none" id="cart_box_hidden">

                <div pro="title">
                    <p class="w-miniCart-layer-title" id="pro-view-28"><strong>最近加入的商品</strong></p>
                </div>

                <div id="cart_div_area">
                    <div class="w-miniCart-loading">
                        <b class="w-loading-ico"></b><span class="w-loading-txt">加载中……</span>
                    </div>
                   <!-- <ul pro="list" class="w-miniCart-list">
                        <li class="w-miniCart-item" id="pro-view-27">
                            <div class="w-miniCart-item-pic">
                                <img src="../../img/goods/b2.png" alt="佳能 EOS 5D Mark III 单反机身(无镜头)" width="74px" height="74px" />
                            </div>
                            <div class="w-miniCart-item-text">
                                <p><strong>佳能 EOS 5D Mark III 单反机身(无镜头)</strong></p>
                                <p><em>730夺宝币 &times; 1期</em><a class="w-miniCart-item-del" href="javascript:void(0);" pro="del">删除</a></p>
                            </div></li>
                    </ul>
                    <div pro="footer" class="w-miniCart-layer-footer" id="pro-view-29">
                        <p><strong>共有<b pro="count">1</b>件商品，金额总计：<em><span pro="amount">730</span>夺宝币</em></strong></p>
                        <p><button pro="go" class="w-button w-button-main">查看清单并结算</button></p>
                    </div>-->
                </div>
            </div>
        </div>

        <div class="w-search"  id="pro-view-2" >
            <form action="<?php echo dwz_filter('lists/search'); ?>" method="get" id="searchForm" class="w-search-form f-clear" target="_blank">
                <div class="w-input" id="pro-view-3"><input class="w-input-input" type="text" placeholder="请输入要搜索的商品" name="keyword"></div>
                <button type="submit" class="w-search-btn" ><i class="ico ico-search"></i></button>
            </form>
            <div class="w-search-recKeyWrap">
                <a class="w-search-recKey" href="javascript:void(0);">苹果</a>
                <a class="w-search-recKey" href="javascript:void(0);">手机</a>
            </div>
        </div>
    </div>
</div>
    <div class="m-nav" id="pro-view-1">
        <div class="g-wrap f-clear">
            <div class="m-catlog <?php echo strtolower(MODULE_NAME)=='yyg' && strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index'?' m-catlog-normal':' m-catlog-fold'; ?>">
                <div class="m-catlog-hd" style="padding-left:30px;cursor:pointer">
                    <h2>商品分类<i class="ico ico-arrow ico-arrow-white ico-arrow-white-down"></i></h2>
                </div>
                <div class="m-catlog-wrap"
                     style="<?php echo strtolower(MODULE_NAME)=='yyg' && strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index'?'':'height: 0; '; ?>">
                    <div class="m-catlog-bd">
                        <ul class="m-catlog-list">
                            <li><a class="catlog-0" href="<?php echo dwz_filter('lists/index',['category'=>0]); ?>">全部商品</a></li>
                            <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_category): $mod = ($i % 2 );++$i;?>
                            <li><a class="catlog-<?php echo $i; ?>" href="<?php echo dwz_filter('lists/index',['category'=>$each_category['id']]); ?>"><?php echo $each_category['name']; ?></a>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="m-catlog-ft"></div>
                </div>
            </div>
            <div class="m-menu">
                <ul class="m-menu-list">
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index'?' selected':' '; ?>"
                        data-name="index">

                        <a class="m-menu-list-item-link" href="/">首页</a>

                    </li>
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'lists' && strtolower(ACTION_NAME) == 'ten'?' selected':' '; ?>"
                        data-name="ten">
                        <var>|</var>
                        <a class="m-menu-list-item-link" href="<?php echo dwz_filter('lists/ten'); ?>">十元专区</a>

                    </li>
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'lists' && strtolower(ACTION_NAME) == 'results'?' selected':' '; ?>"
                        data-name="results">
                        <var>|</var>
                        <a class="m-menu-list-item-link" href="<?php echo dwz_filter('lists/results'); ?>">最新揭晓</a>

                    </li>
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'share' && strtolower(ACTION_NAME) == 'index'?' selected':' '; ?>"
                        data-name="share">
                        <var>|</var>
                        <a class="m-menu-list-item-link" href="<?php echo dwz_filter('Share/index'); ?>">晒单分享</a>

                    </li>
                    <!--<li class="m-menu-list-item dropdown" data-name="find">
                        <var>|</var>
                        <a class="m-menu-dropdown" href="javascript:void(0);">发现<i
                                class="ico ico-arrow ico-arrow-gray-s ico-arrow-gray-s-down"></i></a>

                    </li>-->
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="g-body">
    <div id="pro-view-7">
        <div class="m-index">
            <div class="g-wrap g-body-hd f-clear">
                <div class="g-main">
                    <div class="g-main-l">
                        <div class="m-index-news">
                           <ul class="m-index-nl">
                               <li>
                                   <span></span>
                                   <h4>香肠一元购上线试运营</h4>
                                   <p>香肠一元购上线试运营香肠一元购上线试运营...</p>
                               </li>
                               <li>
                                   <span></span>
                                   <h4>香肠一元购上线试运营</h4>
                                   <p>香肠一元购上线试运营香肠一元购上线试运营...</p>
                               </li>
                               <li>
                                   <span></span>
                                   <h4>香肠一元购上线试运营</h4>
                                   <p>香肠一元购上线试运营香肠一元购上线试运营...</p>
                               </li>
                           </ul>
                        </div>
                    </div>
                    <div class="g-main-m">
                        <div class="w-slide m-index-promot" id="pro-view-8">
                            <div class="w-slide-wrap">
                                <ul class="w-slide-wrap-list" pro="list" style="width: 4380px; left: -1460px;">
                                    <!--循环-->
                                    <?php if(is_array($home_promo_list)): $i = 0; $__LIST__ = $home_promo_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_home_promo): $mod = ($i % 2 );++$i;?>
                                    <li class="w-slide-wrap-list-item">
                                        <?php switch($each_home_promo['type']): case "1": ?>
                                        <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',array('gid'=>$each_home_promo['content'])); ?>" title="<?php echo htmlspecialchars($each_home_promo['title']); ?>" target="_blank"><img width="730" height="350" src="__image_path__<?php echo $each_home_promo['img_path']; ?>" onerror="no_img($(this));"></a>
                                        <?php break; case "2": ?>
                                        <a href="<?php echo $each_home_promo['content']; ?>" title="<?php echo htmlspecialchars($each_home_promo['title']); ?>" target="_blank">
                                            <img width="730" height="350" src="__image_path__<?php echo $each_home_promo['img_path']; ?>"></a>
                                        <?php break; case "3": ?>
                                        <a href="<?php echo dwz_filter('lists/search',['keyword'=>$each_home_promo['content']]); ?>" title="<?php echo htmlspecialchars($each_home_promo['title']); ?>" target="_blank"><img width="730" height="350" src="__image_path__<?php echo $each_home_promo['img_path']; ?>"></a>
                                        <?php break; endswitch; ?>
                                    </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                            <div class="w-slide-controller">
                                <div class="w-slide-controller-btn" pro="controllerBtn">
                                    <a class="prev" pro="prev" href="javascript:void(0)"><i
                                            class="ico ico-arrow-large ico-arrow-large-l"></i><span class="f-txtHide">首焦上一帧</span></a>
                                    <a class="next" pro="next" href="javascript:void(0)"><i
                                            class="ico ico-arrow-large ico-arrow-large-r"></i><span class="f-txtHide">首焦下一帧</span></a>

                                </div>
                                <div class="w-slide-controller-nav" pro="controllerNav"></div>
                            </div>
                        </div>
                        <div id="newestResult" class="w-slide m-index-newReveal">
                            <h4>最新揭晓</h4>
                            <div class="w-slide-wrap">
                                <ul class="w-slide-wrap-list" pro="list" style="width: 4380px;">
                                    <?php if(is_array($opening_list)): $i = 0; $__LIST__ = $opening_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_opening): $mod = ($i % 2 );++$i;?>
                                    <li pro="item" class="w-slide-wrap-list-item">
                                        <div class="w-goods-newReveal" data-status="<?php echo $each_opening['status']; ?>" data-gid="<?php echo $each_opening['goods_id']; ?>" data-nper="<?php echo $each_opening['nper_id']; ?>">
                                            <?php if($each_opening['status'] == '2'): ?>
                                            <i class="ico ico-label ico-label-revealing" title="正在揭晓"></i>
                                            <?php else: ?>
                                            <i class="ico ico-label ico-label-newReveal" title="最新揭晓"></i>
                                            <?php endif; ?>
                                            <p class="w-goods-title"><a
                                                    href="<?php echo dwz_filter('goods/detail',['id'=>$each_opening['goods_id'].'-'.$each_opening['nper_id']]); ?>" title="<?php echo htmlspecialchars($each_opening['goods_name']); ?>"
                                                    target="_blank"><?php echo htmlspecialchars($each_opening['goods_name']); ?></a></p>
                                            <div class="w-goods-pic">
                                                <a href="<?php echo dwz_filter('goods/detail',['id'=>$each_opening['goods_id'].'-'.$each_opening['nper_id']]); ?>" target="_blank">
                                                    <img width="120" height="120" src="__image_path__<?php echo $each_opening['goods_image']; ?>" onerror="no_img($(this));">
                                                </a>
                                            </div>
                                            <p class="w-goods-price">总需：<?php echo $each_opening['sum_times']; ?>人次</p>
                                            <p class="w-goods-period">期号：<?php echo num_base_mask($each_opening['nper_id']); ?></p>
                                            <div class="opening-result">
                                                <?php if($each_opening['status'] == '2'): ?>
                                                <div class="w-goods-counting">
                                                    <?php 

                                                        $tmp = floor($each_opening['open_time']);
                                                        $tmp = $tmp < 0 ? 0 :$tmp;
                                                     if((int)$tmp > 0): ?>
                                                    <div class="w-goods-countdown">揭晓倒计时:
                                                        <div class="w-countdown" time="<?php echo (isset($tmp) && ($tmp !== '')?$tmp:0); ?>">
                                                            <span class="w-countdown-nums"><b></b><b></b>:<b></b><b></b>:<b></b><b></b></span>

                                                        </div>
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="w-goods-countdown">请稍候:
                                                        <div class="w-countdown" time="<?php echo (isset($tmp) && ($tmp !== '')?$tmp:0); ?>">
                                                            <!--<span class="w-countdown-nums"><b></b><b></b>:<b></b><b></b>:<b></b><b></b></span>-->
                                                            <p class="w-countdown-ing txt-red" style="display:;">
                                                                开奖中…</p>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php else: ?>
                                                <div class="w-goods-record"><p class="w-goods-owner f-txtabb">获得者：<a href="<?php echo dwz_filter('ta/index',['uid'=>$each_opening['luck_uid']]); ?>" title="<?php echo htmlspecialchars($each_opening['luck_user']); ?>(ID:<?php echo $each_opening['luck_uid']; ?>)">
                                                    <b><?php echo htmlspecialchars($each_opening['luck_user']); ?></b></a></p><p>本期参与：<?php echo $each_opening['luck_o_num']; ?>人次</p><p>幸运号码：<?php echo num_base_mask($each_opening['luck_num']); ?></p></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                            <div class="w-slide-controller">
                                <div class="w-slide-controller-btn" pro="controllerBtn">
                                    <a class="prev" pro="prev" href="javascript:void(0)"><i
                                            class="ico ico-arrow-large ico-arrow-large-l"></i><span class="f-txtHide">最新揭晓上一帧</span></a>
                                    <a class="next" pro="next" href="javascript:void(0)"><i
                                            class="ico ico-arrow-large ico-arrow-large-r"></i><span class="f-txtHide">最新揭晓下一帧</span></a>
                                </div>
                                <div class="w-slide-controller-nav" pro="controllerNav"><a class="dot curr"
                                                                                           href="javascript:void(0)"></a><a
                                        class="dot" href="javascript:void(0)"></a><a class="dot"
                                                                                     href="javascript:void(0)"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-side">
                    <div class="m-index-recommend">
                        <?php if(!empty($top_promo_one)): ?>
                        <h4>推荐商品</h4>
                        <i class="ico ico-label ico-label-recommend" title="推荐夺宝"></i>
                        <div class="w-goods w-goods-ing w-goods-recommend w-goods-quickBuy-warp"  data-nper="<?php echo $top_promo_one['id']; ?>" data-last="<?php echo $top_promo_one['remain']; ?>" data-unit="<?php echo $top_promo_one['unit_price']; ?>" data-min="<?php echo $top_promo_one['min_times']; ?>">
                            <div class="w-goods-pic">
                                <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$top_promo_one['gid']]); ?>"
                                   title="<?php echo htmlspecialchars($top_promo_one['name']); ?>" target="_blank">
                                    <img width="180" height="180" alt="" src="__image_path__<?php echo $top_promo_one['img_path']; ?>" onerror="no_img($(this));"
                                         style="min-height: 40px; min-width: 40px;">
                                </a>
                            </div>
                            <p class="w-goods-title f-txtabb"><a title="" href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$top_promo_one['gid']]); ?>" target="_blank"><?php echo htmlspecialchars($top_promo_one['name']); ?></a></p>
                            <p class="w-goods-price">总需：<?php echo $top_promo_one['sum_times']; ?> 人次</p>
                            <div class="w-progressBar" title="<?php echo $top_promo_one['percent']; ?>%">
                                <p class="w-progressBar-wrap">
                                    <span class="w-progressBar-bar" style="width:<?php echo $top_promo_one['percent']; ?>%;"></span>
                                </p>
                                <p class="w-progressBar-txt">已完成<?php echo $top_promo_one['percent']; ?>%，剩余<strong><?php echo $top_promo_one['remain']; ?></strong></p>
                            </div>
                            <div class="w-goods-opr">
                                <a class="w-button w-button-main w-button-l w-goods-quickBuy" href="javascript:;" style="width:70px;">立即夺宝</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="w-slide m-index-newGoods" id="pro-view-9">
                        <i class="ico ico-label ico-label-newRecommend" title="新品推荐"><a
                                style="display:block;width:100%;height:100%" href="javascript:;"></a></i>
                        <div class="w-slide-wrap">
                            <ul class="w-slide-wrap-list" pro="list" style="width: 1150px;">
                                <!--循环-->
                                <?php if(is_array($top_promo_new_list)): $i = 0; $__LIST__ = $top_promo_new_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_promo_new): $mod = ($i % 2 );++$i;?>
                                <li pro="item" class="w-slide-wrap-list-item">
                                    <table class="wrap">
                                        <tbody>
                                        <tr>
                                            <td style="border-bottom:1px dotted #C9C9C9;padding-top:15px;height:130px;text-align:center;">
                                                <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_promo_new['id']]); ?>" target="_blank">
                                                    <img width="120" height="120"
                                                         onerror="no_img($(this));"
                                                         src="__image_path__<?php echo $each_promo_new['img_path']; ?>"
                                                         alt="<?php echo htmlspecialchars($each_promo_new['name']); ?>"
                                                         style="margin:auto">
                                                </a></td>
                                        </tr>
                                        <tr>
                                            <td style="height:63px;text-align:center">
                                                <dl>
                                                    <dt class="f-txtabb" style="width:100%"><a
                                                            style="color:#3C3C3C;font-size:14px;" href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_promo_new['id']]); ?>"
                                                            target="_blank" title="<?php echo htmlspecialchars($each_promo_new['name']); ?>"><?php echo htmlspecialchars($each_promo_new['name']); ?></a></dt>
                                                    <dd class="f-txtabb m-index-newGoods-desc" style="width:100%"
                                                        title="<?php echo htmlspecialchars($each_promo_new['sub_title']); ?>">
                                                        <?php echo htmlspecialchars($each_promo_new['sub_title']); ?>
                                                    </dd>
                                                </dl>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                        <div class="w-slide-controller">
                            <div class="w-slide-controller-btn" pro="controllerBtn">
                                <a class="prev" pro="prev" href="javascript:void(0)"><i
                                        class="ico ico-arrow-small ico-arrow-small-l"></i><span class="f-txtHide">新品推荐上一帧</span></a>
                                <a class="next" pro="next" href="javascript:void(0)"><i
                                        class="ico ico-arrow-small ico-arrow-small-r"></i><span class="f-txtHide">新品推荐下一帧</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="g-wrap g-body-bd f-clear">
                <div class="g-main">
                    <div class="m-index-mod m-index-goods-hotest">
                        <div class="w-hd">
                            <h3 class="w-hd-title">最热商品</h3>
                            <a class="w-hd-more" href="<?php echo dwz_filter('lists/index',['sort'=>0]); ?>">更多商品，点击查看&gt;&gt;</a>
                        </div>
                        <div class="m-index-mod-bd">
                            <ul class="w-goodsList f-clear">
                                <!--循环-->
                                <?php if(is_array($hot_goods)): $i = 0; $__LIST__ = $hot_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_goods): $mod = ($i % 2 );++$i;?>
                                <li class="w-goodsList-item" data-nper="<?php echo $each_goods['id']; ?>" data-last="<?php echo $each_goods['remain']; ?>" data-unit="<?php echo $each_goods['unit_price']; ?>" data-min="<?php echo $each_goods['min_times']; ?>">
                                    <div class="w-goods w-goods-ing">
                                        <div class="w-goods-pic">
                                            <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_goods['gid']]); ?>" title="<?php echo htmlspecialchars($each_goods['name']); ?>"
                                               target="_blank">
                                                <img width="200" height="200" alt=""
                                                     src="__image_path__<?php echo $each_goods['img_path']; ?>"
                                                     onerror="no_img($(this));"
                                                     style="min-height: 40px; min-width: 40px;">
                                            </a>
                                        </div>
                                        <p class="w-goods-title f-txtabb"><a title="<?php echo htmlspecialchars($each_goods['sub_title']); ?>" href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_goods['gid']]); ?>"
                                                                             target="_blank"><?php echo htmlspecialchars($each_goods['name']); ?></a></p>
                                        <p class="w-goods-price">总需：<?php echo $each_goods['sum_times']; ?> 人次</p>
                                        <div class="w-progressBar" title="<?php echo $each_goods['percent']; ?>%">
                                            <p class="w-progressBar-wrap">
                                                <span class="w-progressBar-bar" style="width:<?php echo $each_goods['percent']; ?>%;"></span>
                                            </p>
                                            <ul class="w-progressBar-txt f-clear">
                                                <li class="w-progressBar-txt-l"><p><b><?php echo $each_goods['participant_num']; ?></b></p>
                                                    <p>已参与人次</p></li>
                                                <li class="w-progressBar-txt-r"><p><b><?php echo $each_goods['remain']; ?></b></p>
                                                    <p>剩余人次</p></li>
                                            </ul>
                                        </div>
                                        <p class="w-goods-progressHint">
                                            <b class="txt-blue"><?php echo $each_goods['participant_num']; ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $each_goods['remain']; ?></b>人次
                                        </p>
                                        <div class="w-goods-opr">

                                            <a class="w-button w-button-main w-button-l w-goods-quickBuy"
                                               href="javascript:void(0)" style="width:70px;" title="立即夺宝">立即夺宝</a>
                                            <a class="w-button w-button-addToCart" href="javascript:void(0)"
                                               title="添加到购物车"></a>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="g-side">
                    <div class="m-index-mod m-index-recordRank ">
                        <div class="m-index-mod-hd">
                            <h3>一元传奇</h3>
                        </div>
                        <div class="m-index-mod-bd">
                            <ul id="one_rmb" class="w-intervalScroll" style="margin-top: 0px;">
                                <?php if(is_array($legendary_list)): $i = 0; $__LIST__ = $legendary_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_legendary): $mod = ($i % 2 );++$i;?>
                                <li pro="item" class="w-intervalScroll-item <?php echo ($mod==0)?'odd':'even'; ?>">
                                    <div class="w-record-avatar">
                                        <img width="40" height="40" src="__image_path__<?php echo $each_legendary['avatar']; ?>" onerror="no_img($(this));">
                                    </div>
                                    <div class="w-record-detail">
                                        <p class="w-record-intro">
                                            <a class="w-record-user f-txtabb" href="<?php echo dwz_filter('ta/index',['uid'=>$each_legendary['luck_uid']]); ?>" target="_blank"
                                               title="<?php echo $each_legendary['luck_user']; ?>(ID:<?php echo $each_legendary['luck_uid']; ?>)"><?php echo htmlspecialchars($each_legendary['nick_name']); ?></a>
                                            <span class="w-record-date"><?php echo microtime_format($each_legendary['luck_time'],'1','于m月d日'); ?></span>
                                        </p>
                                        <p class="w-record-title f-txtabb"><strong><?php echo $each_legendary['num']; ?>人次</strong>夺得<a title="<?php echo htmlspecialchars($each_legendary['goods_name']); ?>"
                                                                                                                        href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_legendary['gid']]); ?>"
                                                                                                                        target="_blank"><?php echo $each_legendary['goods_name']; ?></a>
                                        </p>
                                        <p class="w-record-price">总需：<?php echo $each_legendary['sum_times']; ?> 人次</p>
                                    </div>
                                </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                        <div class="m-index-mod-ft">看看谁的狗屎运最好！</div>
                    </div>
                </div>
            </div>
            <div class="g-wrap g-body-ft f-clear">
                <!--商品展示-->
                <!--大分类循环-->
                <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_category): $mod = ($i % 2 );++$i;?>
                <div class="m-index-mod m-index-goods-catlog">
                    <div class="w-hd">
                        <h3 class="w-hd-title"><?php echo $each_category['name']; ?></h3>
                        <a class="w-hd-more" href="<?php echo dwz_filter('lists/index',['category'=>$each_category['id']]); ?>">更多商品，点击查看&gt;&gt;</a>
                    </div>
                    <div class="m-index-mod-bd f-clear">
                        <div class="m-index-promotGoods">
                            <!--<div class="w-slide-wrap"> w-slide -->
                            <?php if(!empty($category_promo[$each_category['id']])): ?>
                            <ul class="w-slide-wrap-list" pro="list">
                                <li pro="item" class="w-slide-wrap-list-item">
                                    <?php if(empty($category_promo[$each_category['id']]['url'])): ?>
                                    <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',array('gid'=>$category_promo[$each_category['id']]['gid'])); ?>" target="_blank">
                                        <?php else: ?>
                                        <a href="<?php echo $category_promo[$each_category['id']]['url']; ?>" target="_blank">
                                            <?php endif; ?>
                                            <img width="239" height="400" src="__image_path__<?php echo $category_promo[$each_category['id']]['img_path']; ?>" onerror="no_img($(this));">
                                        </a>
                                    </a>
                                </li>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <ul class="w-goodsList">
                            <!--产品循环 4个一组-->
                            <?php if(is_array($goods_list[$each_category['id']])): $i = 0; $__LIST__ = $goods_list[$each_category['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_goods): $mod = ($i % 2 );++$i;?>
                            <li class="w-goodsList-item" data-nper="<?php echo $each_goods['id']; ?>" data-last="<?php echo $each_goods['remain']; ?>" data-unit="<?php echo $each_goods['unit_price']; ?>" data-min="<?php echo $each_goods['min_times']; ?>">
                                <div class="w-goods w-goods-ing">
                                    <div class="w-goods-pic">
                                        <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_goods['gid']]); ?>" title="<?php echo htmlspecialchars($each_goods['name']); ?>"
                                           target="_blank">
                                            <img width="200" height="200" alt=""
                                                 src="__image_path__<?php echo $each_goods['img_path']; ?>"
                                                 onerror="no_img($(this));"
                                                 style="min-height: 40px; min-width: 40px;" >
                                        </a>
                                    </div>
                                    <p class="w-goods-title f-txtabb"><a title="<?php echo htmlspecialchars($each_goods['sub_title']); ?>" href="#"
                                                                         target="_blank"><?php echo htmlspecialchars($each_goods['name']); ?></a></p>
                                    <p class="w-goods-price">总需：<?php echo $each_goods['sum_times']; ?> 人次</p>
                                    <div class="w-progressBar" title="<?php echo $each_goods['percent']; ?>%">
                                        <p class="w-progressBar-wrap">
                                            <span class="w-progressBar-bar" style="width:<?php echo $each_goods['percent']; ?>%;"></span>
                                        </p>
                                        <ul class="w-progressBar-txt f-clear">
                                            <li class="w-progressBar-txt-l"><p><b><?php echo $each_goods['participant_num']; ?></b></p>
                                                <p>已参与人次</p></li>
                                            <li class="w-progressBar-txt-r"><p><b><?php echo $each_goods['remain']; ?></b></p>
                                                <p>剩余人次</p></li>
                                        </ul>
                                    </div>
                                    <p class="w-goods-progressHint">
                                        <b class="txt-blue"><?php echo $each_goods['participant_num']; ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $each_goods['remain']; ?></b>人次
                                    </p>
                                    <div class="w-goods-opr">

                                        <a class="w-button w-button-main w-button-l w-goods-quickBuy"
                                           href="javascript:void(0)" style="width:70px;" title="立即夺宝">立即夺宝</a>
                                        <a class="w-button w-button-addToCart" href="javascript:void(0)"
                                           title="添加到购物车"></a>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <a name="newArrivals"></a>
                <div class="m-index-mod m-index-newArrivals">
                    <div class="w-hd">
                        <h3 class="w-hd-title">最新上架</h3>
                        <a class="w-hd-more" href="<?php echo dwz_filter('lists/index',['category'=>0,'sort'=>2]); ?>">更多新品，点击查看&gt;&gt;</a>
                    </div>
                    <div class="m-index-mod-bd">
                        <ul class="w-goodsList f-clear">
                            <!--循环-->
                            <?php if(is_array($new_goods)): $i = 0; $__LIST__ = $new_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_goods): $mod = ($i % 2 );++$i;?>
                            <li class="w-goodsList-item" data-nper="<?php echo $each_goods['id']; ?>" data-last="<?php echo $each_goods['remain']; ?>" data-unit="<?php echo $each_goods['unit_price']; ?>" data-min="<?php echo $each_goods['min_times']; ?>">
                                <div class="w-goods w-goods-ing">
                                    <div class="w-goods-pic">
                                        <a href="<?php echo dwz_filter('goods/jump_to_goods_buying',['gid'=>$each_goods['gid']]); ?>" title="<?php echo htmlspecialchars($each_goods['name']); ?>"
                                           target="_blank">
                                            <img width="200" height="200" alt=""
                                                 src="__image_path__<?php echo $each_goods['img_path']; ?>"
                                                 onerror="no_img($(this));"
                                                 style="min-height: 40px; min-width: 40px;">
                                        </a>
                                    </div>
                                    <p class="w-goods-title f-txtabb"><a title="<?php echo htmlspecialchars($each_goods['sub_title']); ?>" href="#"
                                                                         target="_blank"><?php echo htmlspecialchars($each_goods['name']); ?></a></p>
                                    <p class="w-goods-price">总需：<?php echo $each_goods['sum_times']; ?> 人次</p>
                                    <div class="w-progressBar" title="<?php echo $each_goods['percent']; ?>%">
                                        <p class="w-progressBar-wrap">
                                            <span class="w-progressBar-bar" style="width:<?php echo $each_goods['percent']; ?>%;"></span>
                                        </p>
                                        <ul class="w-progressBar-txt f-clear">
                                            <li class="w-progressBar-txt-l"><p><b><?php echo $each_goods['participant_num']; ?></b></p>
                                                <p>已参与人次</p></li>
                                            <li class="w-progressBar-txt-r"><p><b><?php echo $each_goods['remain']; ?></b></p>
                                                <p>剩余人次</p></li>
                                        </ul>
                                    </div>
                                    <p class="w-goods-progressHint">
                                        <b class="txt-blue"><?php echo $each_goods['participant_num']; ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $each_goods['remain']; ?></b>人次
                                    </p>
                                    <div class="w-goods-opr">

                                        <a class="w-button w-button-main w-button-l w-goods-quickBuy"
                                           href="javascript:void(0)" style="width:70px;" title="立即夺宝">立即夺宝</a>
                                        <a class="w-button w-button-addToCart" href="javascript:void(0)"
                                           title="添加到购物车"></a>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="m-index-mod m-index-share">
                    <div class="w-hd">
                        <h3 class="w-hd-title">晒单分享</h3>
                        <a class="w-hd-more" href="http://1.xiangchang.com/share.html">更多分享，点击查看&gt;&gt;</a>
                    </div>
                    <div class="m-index-mod-bd">
                        <ul class="w-intervalScroll f-clear" data-minline="4" data-perline="2" id="pro-view-12"
                            style="margin-top: 0px;">
                            <!--循环 left right 一组-->
                            <?php if(is_array($share_list)): $i = 0; $__LIST__ = $share_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_share): $mod = ($i % 2 );++$i;?>
                            <li pro="item" class="w-intervalScroll-item <?php echo ($mod==0)?'left':'right'; ?>">
                                <a class="m-index-share-picLink" href="<?php echo dwz_filter('share/detail',['id'=>$each_share['id']]); ?>" target="_blank">
                                    <img class="m-index-share-pic" width="110" src="__image_path__<?php echo (isset($each_share['share_image']) && ($each_share['share_image'] !== '')?$each_share['share_image']:'__noimg__'); ?>" onerror="no_img($(this));">
                                </a>
                                <div class="m-index-share-wrap">
                                    <i class="ico ico-quote ico-quote-former"></i>
                                    <p class="txt"><a
                                            href="<?php echo dwz_filter('share/detail',['id'=>$each_share['id']]); ?>"
                                            target="_blank"><span title="<?php echo htmlspecialchars($each_share['title']); ?>">【<?php echo htmlspecialchars($each_share['title']); ?>】</span><?php echo htmlspecialchars($each_share['content']); ?></a></p>
                                    <p class="author">—— <a title="<?php echo $each_share['username']; ?>(ID:<?php echo $each_share['uid']; ?>)"
                                                            href="<?php echo dwz_filter('ta/index',['uid'=>$each_share['uid']]); ?>"
                                                            target="_blank"><?php echo $each_share['username']; ?></a> <?php echo date('Y-m-d H:i:s',$each_share['create_time']); ?></p>
                                    <i class="ico ico-quote ico-quote-after"></i>
                                </div>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/template" id="opening_tpl">
    <div class="w-goods-countdown">请稍候:
        <div class="w-countdown" >
            <p class="w-countdown-ing txt-red" style="display:;">
                开奖中…</p>
        </div>
    </div>
</script>
<script type="text/template" id="error_tpl">
    <div class="w-goods-error" >
        <p class="txt-gray w-goods-err">非常抱歉~<br>服务器开小差了，请稍后再试...</p>
    </div>
</script>
<input type="hidden" id="nper_open_api" value="<?php echo U('core/gdfc/open_by_nper'); ?>" /><!--触发开奖-->
<input type="hidden" id="refresh_results" value="<?php echo U('index/refresh_results'); ?>" /><!--刷新开奖结果-->
<input type="hidden" id="add_to_cart_url" value="<?php echo U('Pay/add_to_cart'); ?>"><!--添加到购物车-->

<div class="g-footer">
    <div class="m-instruction">
        <div class="g-wrap f-clear">
            <div class="g-main">
                <ul class="m-instruction-list">
                    <?php if(is_array($help_category)): $i = 0; $__LIST__ = $help_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_help_category): $mod = ($i % 2 );++$i;?>
                    <li class="m-instruction-list-item">
                        <h5><i class="ico ico-instruction <?php echo $each_help_category['style']; ?>"></i><?php echo htmlspecialchars($each_help_category['name']); ?>
                        </h5>
                        <ul class="list">
                            <?php if(is_array($each_help_category['articles'])): $i = 0; $__LIST__ = $each_help_category['articles'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_help_article): $mod = ($i % 2 );++$i;if(empty($each_help_article['outlink'])): if(empty($each_help_article['name'])): ?>
                            <li><a href="<?php echo dwz_filter('help/read',['id'=>$each_help_article['id']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php else: ?>
                            <li><a href="<?php echo dwz_filter('help/read',['name'=>$each_help_article['name']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; else: ?>
                            <li><a href="<?php echo $each_help_article['outlink']; ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="g-side">
                <div class="g-side-l">
                    <ul class="m-instruction-state f-clear">
                        <li><i class="ico ico-state-l ico-state-l-1"></i>100%公平公正公开</li>
                        <li><i class="ico ico-state-l ico-state-l-2"></i>100%正品保证</li>
                        <li><i class="ico ico-state-l ico-state-l-3"></i>100%权益保障</li>
                    </ul>
                </div>
                <div class="g-side-r">
                    <div class="m-instruction-yxCode" style="background-color: #f5f5f5;">
                        <a href="javascript:" ><img width="100%" src="<?php echo (isset($conf['WEBSITE_QRCODE']) && ($conf['WEBSITE_QRCODE'] !== '')?$conf['WEBSITE_QRCODE']:''); ?>"></a>
                        <p style="line-height:12px;padding-left: 8px;padding-top: 10px;text-align: left">下载客户端</p>
                    </div>
                    <div class="m-instruction-service">
                        <p><?php echo (isset($conf['WEB_SERVICE_TIME']) && ($conf['WEB_SERVICE_TIME'] !== '')?$conf['WEB_SERVICE_TIME']:''); ?></p>
                        <p><?php echo (isset($conf['WEB_SERVICE_TEL']) && ($conf['WEB_SERVICE_TEL'] !== '')?$conf['WEB_SERVICE_TEL']:''); ?></p>
                        {}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-copyright">
        <div class="g-wrap">
            <div class="m-copyright-logo">
                <?php if(is_array($friend_link)): $i = 0; $__LIST__ = $friend_link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <a href="<?php echo (isset($vo['url']) && ($vo['url'] !== '')?$vo['url']:'#'); ?>" target="_blank">
                    <img width="130" src="<?php echo (isset($vo['img_url']) && ($vo['img_url'] !== '')?$vo['img_url']:''); ?>"></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="m-copyright-txt">
                <p> <?php echo (isset($conf['WEB_INC_INFO']) && ($conf['WEB_INC_INFO'] !== '')?$conf['WEB_INC_INFO']:''); ?> | <?php echo (isset($conf['WEBSITE_BEIAN']) && ($conf['WEBSITE_BEIAN'] !== '')?$conf['WEBSITE_BEIAN']:''); ?></p>
                <p><a href="#" target="_blank">关于香肠</a>
                    <a href="<?php echo (isset($site_config['website_sina_weibo']) && ($site_config['website_sina_weibo'] !== '')?$site_config['website_sina_weibo']:''); ?>" target="_blank">官方微博</a>
                    <a href="#" target="_blank">客户服务</a>
                    <a href="#" target="_blank">隐私政策</a></p>
            </div>
        </div>
    </div>
</div>
<?php if(isset($notify_list)): if(is_array($notify_list)): $i = 0; $__LIST__ = $notify_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_notify): $mod = ($i % 2 );++$i;?>
<div style="display: none;" class="luck">
    <div class="luck-bg"></div>
    <div class="luck-main active">
        <button class="luck-close" title="关闭"><i class="iconfont"></i></button>
        <img src="__image_path__<?php echo $each_notify['goods_image']; ?>">
        <h6><?php echo $each_notify['goods_name']; ?></h6>
        <p>期号：<span><?php echo num_base_mask($each_notify['n_id']); ?></span><br>
            中奖号码：<span><?php echo num_base_mask($each_notify['luck_num']); ?></span></p>
        <a href="<?php echo U('ucenter/luck_detail',['id'=>$each_notify['w_id']]); ?>" target="_blank" class="verify_btn">确认收货地址</a>
    </div>
</div>
<?php endforeach; endif; else: echo "" ;endif; endif; ?>
<!--全局url-->
<input type="hidden" id="login_out" value="<?php echo U('User/login_out'); ?>"><!--退出登录-->
<input type="hidden" id="get_user_login_info" value="<?php echo U('User/get_user_login_info'); ?>"><!--用户登录状态-->
<input type="hidden" id="show_login" value="<?php echo U('User/show_login'); ?>"><!--显示登录界面-->
<input type="hidden" id="cart_page_url" value="<?php echo U('Pay/cart'); ?>"><!--购物车页面-->
<input type="hidden" id="cart_list_div_url" value="<?php echo U('Pay/cart_list_div'); ?>"><!--购物车ajax载入时候的页面-->
<input type="hidden" id="del_cart_by_nper_id_url" value="<?php echo U('Pay/del_cart_by_nper_id'); ?>"><!--购物车ajax载入时候的页面-->
<input type="hidden" id="del_cart_by_ids_url" value="<?php echo U('Pay/del_cart_by_ids'); ?>"><!--根据id删除购物车内容-->
<input type="hidden" id="update_cart_num_url" value="<?php echo U('Pay/update_cart_num'); ?>"><!--更新购物车数量-->
<input type="hidden" id="create_order_url" value="<?php echo U('Pay/create_order'); ?>"><!--生成订单-->

<!--登录相关-->
<input type="hidden" id="gee_test_url" value="<?php echo U('core/api/gee_test'); ?>"><!--极验证-->
<input type="hidden" id="user_login_do_url" value="<?php echo U('User/user_login_do'); ?>"><!--ajax登录-->
<input type="hidden" id="check_need_verify_url" value="<?php echo U('User/check_need_verify'); ?>"><!--需要验证码检测-->
<!--开奖相关-->
<input type="hidden" id="trigger_open_url" value="<?php echo U('core/Gdfc/trigger_open'); ?>"><!--全局开奖定时触发任务-->
<input type="hidden" id="collect_url" value="<?php echo U('core/Collect/index'); ?>"><!--彩票开奖定时触发任务-->

<input type="hidden" id="no_img_url" value="__yyg__/images/empty_img.jpg"><!--图片不存在时候显示的图片-->
<script type="text/javascript" src="__plugin__/layer/layer.js"></script>
<script type="text/javascript" src="__common__/js/common.js"></script>
<script type="text/javascript" src="__yyg__/js/public.js"></script>
<script type="text/javascript" src="__common__/js/geetest.js"></script>

<script type="text/javascript" src="__static__/js/index.js"></script>
<script type="text/javascript" src="__static__/js/count_down.js"></script>
<script type="text/javascript" src="__yyg__/js/index/index.js"></script>

</body>

<script>
    //DUANG恭喜你中奖了
//    $(".luck").show().find(".luck-main").addClass("active");
//    $(document).on("click",".luck-close,.verify_btn",function(){
//        $(this).parents(".luck").hide();
//    });
</script>
<div style="display: none;">

<!--WEBSITE_TONGJI_BD-->

<?php echo $site_config['website_tongji_bd']; ?>
<!--WEBSITE_TONGJI_CNZZ-->
<?php echo $site_config['website_tongji_cnzz']; ?>

</div>
</html>