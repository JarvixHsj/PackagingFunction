
/**
 * 如果一个数组中没有唯一的id，使用下面这种方式
 * 使用了 in_array() 和 闭包
 * 注意最后的一个 array_filter() 能够重新索引数组，将空的索引给去掉
 * 使用in_array()对两个二维数组取差集
 *  - 去除$arr1 中 存在和$arr2相同的部分之后的内容
 * @param $arr1
 * @param $arr2
 * @return array
 */
function get_diff_array_by_filter($arr1,$arr2){
    try{
        return array_filter($arr1,function($v) use ($arr2){
            return !in_array($v,$arr2);
        });
    }catch (\Exception $exception){
        return $arr1;
    }
}

/**
 * 如果一个数组中某个key是唯一的，则通过key操作不适用 in_array()
 * 根据唯一字段对两个二维数组取差集
 *  - 去除$arr1 中 存在和$arr2相同的部分之后的内容
 * - 返回差集数组
 * @param $arr1
 * @param $arr2
 * @param string $pk
 * @return array
 */
function get_diff_array_by_pk($arr1,$arr2,$pk='pid'){
    try{
        $res=[];
        foreach($arr2 as $item) $tmpArr[$item[$pk]] = $item;
        foreach($arr1 as $v) if(! isset($tmpArr[$v[$pk]])) $res[] = $v;
        return $res;
    }catch (\Exception $exception){
        return $arr1;
    }
}