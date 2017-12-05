/**
 * 下划线转驼峰
 * @param string $str
 * @return string
 */
function convertUnderline($str) {
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i',function($matches){
        return strtoupper($matches[2]);
    },$str);
    return $str;
}