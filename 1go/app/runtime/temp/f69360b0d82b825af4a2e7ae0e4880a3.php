<?php if (!defined('THINK_PATH')) exit();  ?>
<div style="max-height:400px;overflow-y: auto;background-color:#fff;">
    <?php if(empty($list)): ?>
    <div class="w-miniCart-loading">
        <span class="w-loading-txt">您的购物车没有任何东西哟~</span>
    </div>
    <?php else: ?>
    <ul pro="list" class="w-miniCart-list">
        <?php if(is_array($list)): foreach($list as $k=>$vo): ?>
        <li class="w-miniCart-item" id="pro-view-27">
            <div class="w-miniCart-item-pic">
                <img src="__upload__<?php if(!empty($vo['i_img_path'])): echo $vo['i_img_path']; else: ?>__yyg__/images/empty_img.jpg<?php endif; ?>" alt="<?php echo (isset($vo['g_name']) && ($vo['g_name'] !== '')?$vo['g_name']:'暂无商品标题'); ?>" width="74px" height="74px"/>
            </div>
            <div class="w-miniCart-item-text">
                <p><strong><?php echo (isset($vo['g_name']) && ($vo['g_name'] !== '')?$vo['g_name']:'暂无商品标题'); ?></strong></p>
                <p><em><?php if(!empty($vo['unit_price'])): echo (int)$vo['unit_price'].'根香肠'; else: ?>--<?php endif; ?>&times; <?php echo (isset($vo['num']) && ($vo['num'] !== '')?$vo['num']:'--'); ?>次参与( 期数:<?php echo (num_base_mask($vo['nper_id']) !== ''?num_base_mask($vo['nper_id']):'--'); ?>)</em><a data-nper="<?php echo $vo['nper_id']; ?>" class="w-miniCart-item-del del_cart_btn" href="javascript:void(0);" pro="del">删除</a></p>
            </div>
        </li>
        <?php endforeach; endif; ?>
    </ul>
</div>
<div pro="footer" class="w-miniCart-layer-footer" id="pro-view-29">
    <p><strong>共有<b pro="count"><?php echo (isset($count) && ($count !== '')?$count:'0'); ?></b>件商品，金额总计：<em><span pro="amount"><?php echo (isset($sum_money) && ($sum_money !== '')?$sum_money:'0'); ?></span>根香肠</em></strong></p>
    <p>
        <a href="javascript:" id="go_to_cart_list" class="w-button w-button-main">查看清单并结算</a>
    </p>
    <?php endif; ?>

</div>