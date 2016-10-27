<?php

class AlibabaAliqinFcVoiceNumSinglecallRequest
{
	
	private $calledNum;
	
	
	private $calledShowNum;
	
	
	private $extend;
	
	
	private $voiceCode;
	
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

	public function setExtend($extend)
	{
		$this->extend = $extend;
		$this->apiParas["extend"] = $extend;
	}

	public function getExtend()
	{
		return $this->extend;
	}

	public function setVoiceCode($voiceCode)
	{
		$this->voiceCode = $voiceCode;
		$this->apiParas["voice_code"] = $voiceCode;
	}

	public function getVoiceCode()
	{
		return $this->voiceCode;
	}

	public function getApiMethodName()
	{
		return "alibaba.aliqin.fc.voice.num.singlecall";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->calledNum,"calledNum");
		RequestCheckUtil::checkNotNull($this->calledShowNum,"calledShowNum");
		RequestCheckUtil::checkNotNull($this->voiceCode,"voiceCode");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
