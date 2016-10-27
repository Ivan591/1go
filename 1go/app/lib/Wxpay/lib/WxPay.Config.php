<?php


class WxPayConfig
{
	//=======【基本信息设置】=====================================
	//
	
	const APPID = 'wx04a6e7de38e51da9';
	const MCHID = '1330555801';
	const KEY = 'lingjiang735mengdie735xiangchang';
	const APPSECRET = 'aeffc341ce12c63e2121afd593fe96c6';
	
	//=======【证书路径设置】=====================================
	
	const SSLCERT_PATH = '../cert/apiclient_cert.pem';
	const SSLKEY_PATH = '../cert/apiclient_key.pem';
	
	//=======【curl代理设置】===================================
	
	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080;
	
	//=======【上报信息配置】===================================
	
	const REPORT_LEVENL = 1;
}


