/**
 * 远程获取数据，GET模式 注意： 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * @author krin
 * @param string $url
 * @return string
 */
function doRequestGET($url) {
    $ch = curl_init();
    // 设置URL参数
    curl_setopt($ch, CURLOPT_URL, $url);
    // 设置cURL允许执行的最长秒数
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    // 要求CURL返回数据
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行请求
    $responseText = curl_exec($ch);
    //var_dump( curl_error($ch) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
    curl_close($ch);

    return $responseText;
}



    
    
/**
 * 远程获取数据，POST模式 注意： 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
 * @author krin
 * @param string $url
 * @param array $data post数据
 * @return string
 */
function doRequestPOST($url, $data = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}
