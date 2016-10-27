<?php

class AlibabaAliqinFcTtsNumSinglecallRequest
{
	
	private $calledNum;
	
	
	private $calledShowNum;
	
	
	private $extend;
	
	
	private $ttsCode;
	
	
	private $ttsParam;
	
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

	public function setTtsCode($ttsCode)
	{
		$this->ttsCode = $ttsCode;
		$this->apiParas["tts_code"] = $ttsCode;
	}

	public function getTtsCode()
	{
		return $this->ttsCode;
	}

	public function setTtsParam($ttsParam)
	{
		$this->ttsParam = $ttsParam;
		$this->apiParas["tts_param"] = $ttsParam;
	}

	public function getTtsParam()
	{
		return $this->ttsParam;
	}

	public function getApiMethodName()
	{
		return "alibaba.aliqin.fc.tts.num.singlecall";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->calledNum,"calledNum");
		RequestCheckUtil::checkNotNull($this->calledShowNum,"calledShowNum");
		RequestCheckUtil::checkNotNull($this->ttsCode,"ttsCode");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
