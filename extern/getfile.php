<?php

class RequestFile
{
	var $StatusLogOn = false;
	
	//tries different methods for retrieving a url as 
	//each hosting company tends to screw this up in one way or another
	//it logs the successful one in the db for use next time
	function get_file($url)
	{
		//attempt the standard file_get_contents 
		$data = $this->cc_file_get_contents($url); 
		
		//if that didn't work try curl
		if(!$data)
		{
			$data = $this->cc_curl_file($url);			 
		}
		
		//if that didn't work try a socket
		if(!$data)
		{
			$data = $this->cc_socket_file($url);		 
		}
		
		//if all else fails we can try wget (assuming we're on linux)
		if(!$data)
		{
			$data = $this->cc_wget_file($url);			 
		}
		
		return $data;
	}
	
	//minor modification to file_get_contents to log if it worked or not
	//note this or (fopen) will not work if allow_url_fopen = 0 in php.ini
	function cc_file_get_contents($url)
	{
		if($data = @file_get_contents($url))
		{
			$this->log_status(date("H:i:s d-m-Y").' SUCCESS: Data Has Been Downloaded Using file_get_contents');
			return $data;
		}
		else
		{	
			if (ini_get('allow_url_fopen') != '1') 
			{
			   $msg = "fopen wrappers are disabled";
			}
					
			$this->log_status(date("H:i:s d-m-Y").' FAIL: '.$msg);
			
			return FALSE;	
		}
	}
	
	//try and use curl
	function cc_curl_file($url)
	{
		// make sure curl is installed
		if (function_exists('curl_init')) 
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, $this->rand_user_agent());
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
			$data = curl_exec($ch);
			if($data!==false)
			{
				$this->log_status(date("H:i:s d-m-Y").' SUCCESS: Data Has Been Downloaded Using CURL');
				curl_close($ch);
				return $data;
			}
			$this->log_status(date("H:i:s d-m-Y").' FAIL: CURL error '.curl_error($ch));
			curl_close($ch);
			return false;
		} 
		else
		{
			$this->log_status(date("H:i:s d-m-Y").' FAIL: CURL is not installed');
			return FALSE;
		}		
	}
	
	//try and use sockets - this code is untested
	function cc_socket_file($url)
	{
		$parsedUrl = parse_url($url);	//get the host name and url path
	
		$host = $parsedUrl['host'];
	
		if(isset($parsedUrl['path'])) 
		{
			$path = $parsedUrl['path'];
		} 
		else 
		{
			$path = '/';	//the url is pointing to the host like http://www.mysite.com
		}
		
		if (isset($parsedUrl['query'])) 
		{
			$path .= '?'.$parsedUrl['query'];
		}
		
		if (isset($parsedUrl['port'])) 
		{
			$port = $parsedUrl['port'];
		} 
		else 
		{
			$port = '80';	//most sites use port 80
		}
		
		$timeout = 10;
		$response = '';
		
		$fp = @fsockopen($host, $port, $errno, $errstr, $timeout);	//connect to the remote server
		
		if(!$fp) 
		{
			$this->log_status(date("H:i:s d-m-Y").' FAIL: Socket Failed Cannot Retrieve '.$url);
			return FALSE;
		} 
		else 
		{
			//send the necessary headers to get the file
			fputs($fp,	"GET $path HTTP/1.0\r\n" .
						"Host: $host\r\n" .
						"User-Agent: ".$this->rand_user_agent()."\r\n" .
						"Accept: */*\r\n" .
						"Accept-Language: en-us,en;q=0.5\r\n" .
						"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
						"Keep-Alive: 300\r\n" .
						"Connection: keep-alive\r\n" .
						"Referer: http://$host\r\n\r\n");
		
			//retrieve the response from the remote server
			while($line = fread($fp, 4096)) 
			{
				$response .= $line;
			}
			
			fclose($fp);
			
			//strip the headers
			$pos = strpos($response, "\r\n\r\n");
			$response = substr($response, $pos + 4);
		}
		
		$this->log_status(date("H:i:s d-m-Y").' SUCCESS: Data Has Been Downloaded Via A Socket Connection');
		return $response;	
	}
	
	//try and use wget if on linux
	function cc_wget_file($url)
	{
		$cmd = "wget '".$url."'";
		exec($cmd);
	
		if($data = @file_get_contents("broadcast"))	//the file gets saved as file simply called broadcast
		{
			$this->log_status(date("H:i:s d-m-Y").' SUCCESS: File Downloaded Using wget');
			return $data;
		}
		else
		{
			$this->log_status(date("H:i:s d-m-Y").' FAILED: Data Could not be retrieved using wget and file_get_contents');
			return FALSE;
		}		
	}
	
	//select an random user agent from the db
	function rand_user_agent()
	{
		return "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3";
	}
	
	//log status to a file
	function log_status($msg)
	{
		if($this->StatusLogOn === TRUE)
		{
			echo $msg."<br>";
		}
		
		return TRUE;
	}
}
/*
$rf=new RequestFile();
$file="http://www.bnro.ro/files/xml/curs_".date("Y").'_'.date("n")."_".date("j").".xml";
$contents = $rf->get_file($file);
*/
?>
