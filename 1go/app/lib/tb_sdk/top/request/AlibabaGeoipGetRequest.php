<?php

class AlibabaGeoipGetRequest
{
	
	private $ip;
	
	
	private $language;
	
	private $apiParas = array();
	
	public function setIp($ip)
	{
		$this->ip = $ip;
		$this->apiParas["ip"] = $ip;
	}

	public function getIp()
	{
		return $this->ip;
	}

	public function setLanguage($language)
	{
		$this->language = $language;
		$this->apiParas["language"] = $language;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function getApiMethodName()
	{
		return "alibaba.geoip.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->ip,"ip");
		RequestCheckUtil::checkNotNull($this->language,"language");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
