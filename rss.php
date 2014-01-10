<?php  
header('Content-type: application/json; charset=utf-8');
include_once('includes/config.php');
include_once('includes/classXmlArray.php');
$db = new DB();
$response = array();
$url = 'http://www.queencreek.org/Home/Components/RssFeeds/RssFeed/View?ctID=6&cateIDs=2';
switch($g_requestType){
	case 'news':
		$url = 'http://www.queencreek.org/Home/Components/RssFeeds/RssFeed/View?ctID=5&cateIDs=6';
		$getXML = LoadRSS($url);
		if(is_array($getXML)){
			$response = getRSS($getXML);
		}
	break;
	case 'events':
	break;
	
}
echo json_encode($response);


function LoadRSS($url){
	$result = array();
	if($url != ''){
		$xmlString = file_get_contents($url);
		$xml = xml2array($xmlString);
		return $xml;
	}else{
		$result['Status'] = 'Error';
		$result['ErrorMsg'] = 'Invalid URL';
	}
}

function getRSS($xml){
	$result = array();
	if(is_array($xml)){
		if(isset($xml['rss']['channel']['item'])){
			$count = 0;
			foreach($xml['rss']['channel']['item'] as $key => $val){
				$result[$count]['title'] = $val['title'];
				$result[$count]['description'] = $val['description'];
				$result[$count]['pubDate'] = $val['pubDate'];
				$result[$count]['guid'] = $val['guid'];
				$count++;
			}
		}
		return $result;
	}else{
		$result['Status'] = 'Error';
		$result['ErrorMsg'] = 'Invalid XML';
	}
}
?>