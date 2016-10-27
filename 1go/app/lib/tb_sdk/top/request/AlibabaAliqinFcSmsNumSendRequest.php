<?php
namespace app\lib\tb_sdk\top\request;
use app\lib\tb_sdk\top\RequestCheckUtil;



class AlibabaAliqinFcSmsNumSendRequest
{
	
	private $extend;
	
	
	private $recNum;
	
	
	private $smsFreeSignName;
	
	
	private $smsParam;
	
	
	private $smsTemplateCode;
	
	
	private $smsType;
	
	private $apiParas = array();
	
	public function setExtend($extend)
	{
		$this->extend = $extend;
		$this->apiParas["extend"] = $extend;
	}

	public function getExtend()
	{
		return $this->extend;
	}

	public function setRecNum($recNum)
	{
		$this->recNum = $recNum;
		$this->apiParas["rec_num"] = $recNum;
	}

	public function getRecNum()
	{
		return $this->recNum;
	}

	public function setSmsFreeSignName($smsFreeSignName)
	{
		$this->smsFreeSignName = $smsFreeSignName;
		$this->apiParas["sms_free_sign_name"] = $smsFreeSignName;
	}

	public function getSmsFreeSignName()
	{
		return $this->smsFreeSignName;
	}

	public function setSmsParam($smsParam)
	{
		$this->smsParam = $smsParam;
		$this->apiParas["sms_param"] = $smsParam;
	}

	public function getSmsParam()
	{
		return $this->smsParam;
	}

	public function setSmsTemplateCode($smsTemplateCode)
	{
		$this->smsTemplateCode = $smsTemplateCode;
		$this->apiParas["sms_template_code"] = $smsTemplateCode;
	}

	public function getSmsTemplateCode()
	{
		return $this->smsTemplateCode;
	}

	public function setSmsType($smsType)
	{
		$this->smsType = $smsType;
		$this->apiParas["sms_type"] = $smsType;
	}

	public function getSmsType()
	{
		return $this->smsType;
	}

	public function getApiMethodName()
	{
		return "alibaba.aliqin.fc.sms.num.send";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		$request = new RequestCheckUtil();
		$request::checkNotNull($this->recNum,"recNum");
		$request::checkNotNull($this->smsFreeSignName,"smsFreeSignName");
		$request::checkNotNull($this->smsTemplateCode,"smsTemplateCode");
		$request::checkNotNull($this->smsType,"smsType");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
