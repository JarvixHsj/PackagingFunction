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

//农历转公历(date：农历日期； type：是否闰月)
function L2S($date,$type = 0)
    {
        list($year, $month, $day) = split("-",$date);
        if($year <= 1951 || $month <= 0 || $day <= 0 || $year >= 2051 ) return false;
        $Larray = $this->_LMDay[$year - $this->_LStart];
        if($type == 1 && count($Larray)<=12 ) return false;//要求查询闰，但查无闰月
        //如果查询的农历是闰月并该年度农历数组存在闰月数据就获取
        if($Larray[$month]>30 && $type == 1 && count($Larray) >=13)   $day = $Larray[13] + $day;
        //获取该年农历日期到公历1月1日的天数
        $days = $day;
        for($i=0;$i<=$month-1;$i++)
            $days += $Larray[$i];
        //当查询农历日期距离公历1月1日超过一年时
        if($days > 366 || ($this->GetSMon($month,2)!=29 && $days>365 ))
        {
            $Syear = $year +1;
            if($this->GetSMon($month,2)!=29)
                $days-=366;
            else
                $days-=365;
            if($days > $this->_SMDay[1])
            {
                $Smonth = 2;
                $Sday = $days - $this->_SMDay[1];
            }
            else
            {
                $Smonth = 1;
                $Sday = $days;
            }
        }
        else
        {
            $Syear =$year;
            for($i=1;$i<=12;$i++)
            {
                if($days > $this->GetSMon($Syear,$i))
                    $days-=$this->GetSMon($Syear,$i);
                else
                {
                    $Smonth = $i;
                    $Sday = $days;
                    break;
                }
            }
        }
        return mktime(0, 0, 0, $Smonth, $Sday, $Syear);
        //$Sdate = $Syear."-".$Smonth."-".$Sday;
        //return $Sdate;
}

    //公历转农历(Sdate：公历日期)
    function S2L($date)
    {
        list($year, $month, $day) = explode("-", $date);
        if($year <= 1951 || $month <= 0 || $day <= 0 || $year >= 2051 ) return false;
        //获取查询日期到当年1月1日的天数
        $date1 = strtotime($year."-01-01");//当年1月1日
        $date2 = strtotime($year."-".$month."-".$day);
        $days=round(($date2-$date1)/3600/24);
        $days += 1;
        //获取相应年度农历数据，化成数组Larray
        $Larray = $this->_LMDay[$year - $this->_LStart];
        if($days <= $Larray[0])
        {
            $Lyear = $year - 1;
            $days = $Larray[0] - $days;
            $Larray = $this->_LMDay[$Lyear - $this->_LStart];
            if($days < $Larray[12])
            {
                $Lmonth = 12;
                $Lday = $Larray[12] - $days;
            }
            else
            {
                $Lmonth = 11;
                $days = $days - $Larray[12];
                $Lday = $Larray[11] - $days;
            }
        }
        else
        {
            $Lyear = $year;
            $days = $days - $Larray[0];
            for($i = 1;$i <= 12;$i++)
            {
                if($days > $Larray[$i]) $days = $days - $Larray[$i];
                else
                {
                    if ($days > 30){
                        $days = $days - $Larray[13];
                        $Ltype = 1;
                    }

                    $Lmonth = $i;
                    $Lday = $days;
                    break;
                }
            }
        }
        return mktime(0, 0, 0, $Lmonth, $Lday, $Lyear);
        //$Ldate = $Lyear."-".$Lmonth."-".$Lday;
        //$Ldate = $this->LYearName($Lyear)."年".$this->LMonName($Lmonth)."月".$this->LDayName($Lday);
        //if($Ltype) $Ldate.="(闰)";
        //return $Ldate;
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



/**
 * 验证手机号码格式
 * @param $phone
 * @return bool
 */
function checkPhone($phone)
{
    $reg = '/^(0|86|17951)?(13[0-9]|15[012356789]|17[031678]|18[0-9]|14[57])[0-9]{8}$/i';
    if (!preg_match($reg, $phone)) return false;
    return true;
}

/**
 * 验证身份证号码格式
 * @param $id_card
 * @return bool
 */
function checkId($id_card)
{
    $reg = '/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/';
    if (!preg_match($reg, $id_card)) return false;
    return true;
}

/**
 * 密码正则
 * 以字母开头，长度在6~18之间，只能包含字符、数字和下划线
 * @param $pwd
 * @return bool
 */
function checkPwd($pwd)
{
    $reg = '/^(?![0-9]+$)(?![a-zA-Z]+$)[a-zA-Z0-9]{6,18}/';
    if (!preg_match($reg, $pwd)) return false;
    return true;
}
