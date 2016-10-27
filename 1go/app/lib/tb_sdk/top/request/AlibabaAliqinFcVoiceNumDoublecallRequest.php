<?php

class AlibabaAliqinFcVoiceNumDoublecallRequest
{
	
	private $calledNum;
	
	
	private $calledShowNum;
	
	
	private $callerNum;
	
	
	private $callerShowNum;
	
	
	private $extend;
	
	
	private $sessionTimeOut;
	
	private $apiParas = array();
	
	public function setCalledNum($calledNum)
	{
		$this->calledNum = $calledNum;
		$this->apiParas["called_num"] = $calledNum;
	}

	public function getCalledNum()
	{
		return $this->calledNum;
	}

	public function setCalledShowNum($calledShowNum)
	{
		$this->calledShowNum = $calledShowNum;
		$this->apiParas["called_show_num"] = $calledShowNum;
	}

	public function getCalledShowNum()
	{
		return $this->calledShowNum;
	}

	public function setCallerNum($callerNum)
	{
		$this->callerNum = $callerNum;
		$this->apiParas["caller_num"] = $callerNum;
	}

	public function getCallerNum()
	{
		return $this->callerNum;
	}

	public function setCallerShowNum($callerShowNum)
	{
		$this->callerShowNum = $callerShowNum;
		$this->apiParas["caller_show_num"] = $callerShowNum;
	}

	public function getCallerShowNum()
	{
		return $this->callerShowNum;
	}

	public function setExtend($extend)
	{
		$this->extend = $extend;
		$this->apiParas["extend"] = $extend;
	}

	public function getExtend()
	{
		return $this->extend;
	}

	public function setSessionTimeOut($sessionTimeOut)
	{
		$this->sessionTimeOut = $sessionTimeOut;
		$this->apiParas["session_time_out"] = $sessionTimeOut;
	}

	public function getSessionTimeOut()
	{
		return $this->sessionTimeOut;
	}

	public function getApiMethodName()
	{
		return "alibaba.aliqin.fc.voice.num.doublecall";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->calledNum,"calledNum");
		RequestCheckUtil::checkNotNull($this->calledShowNum,"calledShowNum");
		RequestCheckUtil::checkNotNull($this->callerNum,"callerNum");
		RequestCheckUtil::checkNotNull($this->callerShowNum,"callerShowNum");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
