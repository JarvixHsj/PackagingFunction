
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