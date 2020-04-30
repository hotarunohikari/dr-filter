<?php


namespace dr\filter;

/**
 * 常用格式校验
 * Class DrCheck
 * @package dr\filter
 * hotarunohikari
 */
class DrCheck
{

    /**
     * 账户是否合法,数字字母下划线,指定长度区间
     * @param $account
     * @param int $min 最小长度
     * @param int $max 最大长度
     * @return false|int
     */
    static function isValidAccount($account, $min, $max) {
        $search  = ['MIN', 'MAX'];
        $replace = [$min ?? 1, $max ?? ''];
        $pattern = str_replace($search,$replace,'/^[\w]{MIN,MAX}$/');
        return preg_match($pattern, $account);
    }

    /**
     * 电子邮箱是否合法
     * @param $email
     * @return boolean
     */
    static function isValidEmail($email) {
        return preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $email);
    }

    /**
     * 邮政编码是否合法
     * @param $mail
     * @return boolean
     */
    static function isValidMail($mail) {
        return preg_match('/^[1-9]\d{5}(?!\d)$/', $mail);
    }

    /**
     * 手机号码是否合法
     * @param $mobile
     * @return boolean
     */
    static function isValidMobile($mobile) {
        return preg_match('/^1[345678]\d{9}$/', $mobile);

    }

    /**
     * 是否强密码(必须同时含有且仅含有 大小写字母数字)
     * @param $pass
     * @param int $min 最小长度
     * @param int $max 最大长度
     * @return boolean
     */
    static function isStrongPass($pass,$min,$max) {
        $search  = ['MIN', 'MAX'];
        $replace = [$min ?? 1, $max ?? ''];
        $pattern = str_replace($search,$replace,'/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{MIN,MAX}$/');
        return preg_match($pattern, $pass);
    }

    /**
     * 网址是否合法
     * @param $url
     * @return boolean
     */
    static function isValidUrl($url) {
        return preg_match('/[a-zA-z]+://[^\s]*/', $url);
    }

    /**
     * 域名是否合法
     * @param $domain
     * @return boolean
     */
    static function isValidDomain($domain) {
        return preg_match('/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(/.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+/.?/', $domain);
    }

    /**
     * ip是否合法
     * @param $ip
     * @return boolean
     */
    static function isValidIp($ip) {
        return preg_match('/((?:(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d)\\.){3}(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d))/', $ip);

    }

    /**
     * CN固话是否合法
     * @param $tel
     * @return boolean
     */
    static function isValidTel($tel) {
        return preg_match('/^\d{3}-\d{8}|\d{4}-\d{7,8}$/', $tel);

    }

    /**
     * QQ号码是否合法
     * @param $qq
     * @return boolean
     */
    static function isValidQQ($qq) {
        return preg_match('/[1-9][0-9]{4,}/', $qq);

    }

    /**
     * 留言内容是否合法(最少15字)
     * @param $content
     * @return boolean
     */
    static function isValidContent($content) {
        return preg_match('/^[\s|\S]{30,}$/', $content);
    }

    /**
     * 身份证合法性验证
     * @param string $idCard 身份证号码
     * @return boolean
     */
    static function isValidIdCard($idCard) {
        if ($idCard == '')
            return false;
        $ret = false;
        $w   = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        //身份证号码长度必须为18，只要校验位正确就算合法
        $crc = substr($idCard, 17, 18);
        $a   = [];
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $str = substr($idCard, $i, 1);
            array_push($a, $str);
            $sum += intval($a[$i], 10) * intval($w[$i], 10);
        }
        $sum %= 11;
        $res = "-1";
        switch ($sum) {
            case 0 :
                $res = "1";
                break;
            case 1 :
                $res = "0";
                break;
            case 2 :
                $res = "X";
                break;
            case 3 :
                $res = "9";
                break;
            case 4 :
                $res = "8";
                break;
            case 5 :
                $res = "7";
                break;
            case 6 :
                $res = "6";
                break;
            case 7 :
                $res = "5";
                break;
            case 8 :
                $res = "4";
                break;
            case 9 :
                $res = "3";
                break;
            case 10 :
                $res = "2";
                break;
        }
        if (strtolower($crc) == strtolower($res)) {
            $ret = true;
        }
        return $ret;
    }

    /**
     * 是否为合法的银行卡号
     * @param $card_number
     * @return bool
     */
    static function isBankCard($card_number) {
        if (empty($card_number))
            return false;
        $len = strlen($card_number);
        if ($len == 16) {
            $arr_no = str_split($card_number);
            $last_n = $arr_no[count($arr_no) - 1];
            krsort($arr_no);
            $i     = 1;
            $total = 0;
            foreach ($arr_no as $n) {
                if ($i % 2 == 0) {
                    $ix = $n * 2;
                    if ($ix >= 10) {
                        $nx    = 1 + ($ix % 10);
                        $total += $nx;
                    } else {
                        $total += $ix;
                    }
                } else {
                    $total += $n;
                }
                $i++;
            }
            $total -= $last_n;
            $x     = 10 - ($total % 10);
            return $x == $last_n;
        } else if ($len == 19) {
            $arr_no = str_split($card_number);
            $last_n = $arr_no[count($arr_no) - 1];
            krsort($arr_no);
            $i     = 1;
            $total = 0;
            foreach ($arr_no as $n) {
                if ($i % 2 == 0) {
                    $ix = $n * 2;
                    if ($ix >= 10) {
                        $nx    = 1 + ($ix % 10);
                        $total += $nx;
                    } else {
                        $total += $ix;
                    }
                } else {
                    $total += $n;
                }
                $i++;
            }
            $total -= $last_n;
            $total *= 9;
            return $last_n == ($total % 10);
        } else {
            return false;
        }
    }

    /**
     * 验证营业执照是否合法：营业执照长度须为15位数字
     * @param string $Code 统一社会信用代码
     * @return boolean
     */
    public static function isValidBusCode($Code) {
        $patrn = '/^[0-9A-Z]+$/';
        $ret   = true;
        //18位校验及大写校验
        if ((strlen($Code) != 18) || (preg_match($patrn, $Code) == false)) {
            $ret = false;
        } else {
            $Ancode          = '';//统一社会信用代码的每一个值
            $Ancodevalue     = '';//统一社会信用代码每一个值的权重
            $total           = 0;
            $weightedfactors = [1, 3, 9, 27, 19, 26, 16, 17, 20, 29, 25, 13, 8, 24, 10, 30, 28];//加权因子
            $str             = '0123456789ABCDEFGHJKLMNPQRTUWXY';
            //不用I、O、S、V、Z
            for ($i = 0; $i < strlen($Code) - 1; $i++) {
                $Ancode      = substr($Code, $i, 1);
                $Ancodevalue = strpos($str, $Ancode);
                $total       = $total + $Ancodevalue * $weightedfactors[$i];
                //权重与加权因子相乘之和
            }
            $logiccheckcode = 31 - $total % 31;
            if ($logiccheckcode == 31) {
                $logiccheckcode = 0;
            }
            $Str            = "0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,J,K,L,M,N,P,Q,R,T,U,W,X,Y";
            $Array_Str      = explode(',', $Str);
            $logiccheckcode = $Array_Str[$logiccheckcode];
            $checkcode      = substr($Code, 17, 18);
            if ($logiccheckcode != $checkcode) {
                $ret = false;
            }
        }
        return $ret;
    }

    /**
     * 验证组织机构代码是否合法：组织机构代码为8位数字或者拉丁字母+“-”+1位校验码。
     * @param string $value 字符
     * @return boolean
     */
    static function isValidOrgCode($value) {
        if ($value != "") {
            $values = explode('-', $value);
            if (count($values) != 2)
                return false;
            $ws   = [3, 7, 9, 10, 5, 8, 4, 2];
            $str  = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $reg  = '/^([0-9A-Z]){8}$/';
            $code = $values[0];
            if (!preg_match($reg, $code)) {
                return false;
            }
            $sum = 0;
            for ($i = 0; $i < 8; $i++) {
                $sum += strpos($str, self::charAt($code, $i)) * $ws[$i];
            }
            $C9 = 11 - ($sum % 11);
            if ($C9 == 11) {
                $C9 = '0';
            } else if ($C9 == 10) {
                $C9 = 'X';
            }
            if (strlen($values[1]) != 1)
                return false;
            return $C9 != self::charAt($code, 9);
        }
        return false;
    }

    /**
     * 验证国税税务登记号是否合法:税务登记证是6位区域代码+组织机构代码
     * @param string $taxCode 税字号
     * @return boolean
     */
    static function isValidTaxCode($taxCode) {
        if ($taxCode == '')
            return false;
        $ret  = true;
        $patt = '/^(\d{15})$/';
        if (!preg_match($patt, $taxCode)) {
            $ret = false;
        }
        return $ret;
    }

    /**
     * 获取指定字符
     * @param string $str 字符串
     * @param integer $inx 下标
     * @return string
     */
    private static function charAt($str, $inx) {
        $arr = str_split($str, 1);
        return isset($arr[$inx]) ? $arr[$inx] : false;
    }

}