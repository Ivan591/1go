<?php
namespace Admin\Model;
use Think\Model;

class InviteModel extends Model {

	public function withdraw($id){
		$map=array('pay_state'=>0,'id'=>$id,'status'=>1);
		$closing =M('cash_log')->where($map)->field(true)->find();
		return $closing;
	}

	public function update(){
		if($data=M('cash_log')->create()){
			return M('cash_log')->save($data);
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
	}
}