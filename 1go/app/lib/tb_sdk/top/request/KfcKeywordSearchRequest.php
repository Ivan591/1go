<?php

class KfcKeywordSearchRequest
{
	
	private $apply;
	
	
	private $content;
	
	
	private $nick;
	
	private $apiParas = array();
	
	public function setApply($apply)
	{
		$this->apply = $apply;
		$this->apiParas["apply"] = $apply;
	}

	public function getApply()
	{
		return $this->apply;
	}

	public function setContent($content)
	{
		$this->content = $content;
		$this->apiParas["content"] = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setNick($nick)
	{
		$this->nick = $nick;
		$this->apiParas["nick"] = $nick;
	}

	public function getNick()
	{
		return $this->nick;
	}

	public function getApiMethodName()
	{
		return "taobao.kfc.keyword.search";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->content,"content");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
