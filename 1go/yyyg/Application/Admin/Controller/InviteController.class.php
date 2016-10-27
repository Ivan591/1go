<?php
namespace Admin\Controller;

class InviteController extends WebController {

	 /**
     * 中奖管理首页
     */
	public function edit($id){
		if(IS_POST){
			if(false !==D('Invite')->update()){
                $this->success('修改为已汇款！');
            } else {
                $this->error(D('Invite')->getError());
            }
		}else{
			$info=D('Invite')->withdraw($id);
            $this->assign('info',$info);
			$this->meta_title = '提现支付';
			$this->display();
		}
	}

	public function pay(){
		if(is_numeric($_GET['type'])){
			$map['pay_state']=I('type');
		}
        $list = $this->lists('cash_log',$map,$order='create_time desc',$rows=0,$base = array('status'=>1,'type'=>0),$field=true);
        $this->assign('_list', $list);
        $this->meta_title = '提现管理';
        $this->display();
	}
}