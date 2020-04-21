<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_components = parse_url($url); 
  
// Use parse_str() function to parse the 
// string passed via URL 
parse_str($url_components['query'], $params); 

$client = new GuzzleHttp\Client();
try {
$res = $client->request('GET', 'http://cdn.nhent.ai/galleries/'.$params['id'].'/'.$params['page'].'.jpg');
}catch(Exception $e){
$res = $client->request('GET', 'http://cdn.nhent.ai/galleries/'.$params['id'].'/'.$params['page'].'.png');	
}
echo $res->getStatusCode();
// "200"
//echo $res->getBody();
// {"type":"User"...'
$dir = "images";
$headerfile = 'images/'.$params['id'];
if( is_dir($dir) === false )
{
    mkdir($dir);
}
$files = glob('images/*'); // get all file names
if(file_exists($headerfile)){

}else{
 foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file);

}
file_put_contents($headerfile,'r');	
}

$file = 'images/'.$params['page'].'-'.$params['id'].'.jpg';
file_put_contents($file, $res->getBody());
?>