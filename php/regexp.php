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
