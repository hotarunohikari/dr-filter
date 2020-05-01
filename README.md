# dr-filter
## DrFilter输入过滤帮助类

用于对传入内容进行过滤,支持传入数组，违规的输入会被替换为null后返回。

内置1个默认过滤字符集和5个过滤等级,分别对应描述如下:

0:防xss攻击,并去除输入中的空格和换行回车

1:仅支持输入数字字母下划线和中日韩文字

2:仅支持输入数字字母下划线和中文

3:仅支持输入数字字母下划线

4:仅支持输入数字

默认过滤等级为0

一. 实例化: 

单例模式(传入过滤等级)：

$filter = DrFilter::instance(1);

新建模式(传入过滤等级):

$filter = new DrFilter(1);

二. API:


    /**
     * 设置默认的过滤字符
     * @param array $deny
     * @return $this;
     */
    function setDefaultDeny(array $deny)

    /**
     * 查看默认的过滤字符
     * @return array
     */
    function getDefaultDeny()

    /**
     * 查看默认的过滤等级
     * @return mixed
     */
    function getStrict() 

    /**
     * 设置过滤等级
     * @param int $strict
     * @return $this
     */
    function setStrict(int $strict)

    /**
     * 设置自定义正则校验
     * @param int $strict
     * @return $this
     */
    function setPreg($preg) 

    /**
     * 安全过滤输入,支持数组
     * 1.筛选默认过滤字符
     * 2.根据过滤等级或附加正则筛选
     * @param string|array $input 输入
     * @param int $strict 过滤级别,置空则为0
     * @return array
     */
    function filter($input, $strict = null) 

    

示例如下:

// 过滤输入

$param = DrFilter::instance()->filter(input(''));

// 按照指定正则过滤输入

$param = DrFilter::instance()->setGrep->('')->filter(input(''));


## DrCheck常见的输入检查


    /**
     * 账户是否合法,数字字母下划线,指定长度区间
     * @param $account
     * @param int $min 最小长度
     * @param int $max 最大长度
     * @return false|int
     */
    static function isValidAccount($account, $min, $max)

    /**
     * 电子邮箱是否合法
     * @param $email
     * @return boolean
     */
    static function isValidEmail($email)

    /**
     * 手机号码是否合法
     * @param $mobile
     * @return boolean
     */
    static function isValidMobile($mobile)

    /**
     * 是否强密码(必须同时含有且仅含有 大小写字母数字)
     * @param $pass
     * @param int $min 最小长度
     * @param int $max 最大长度
     * @return boolean
     */
    static function isStrongPass($pass,$min,$max)

    /**
     * 网址是否合法
     * @param $url
     * @return boolean
     */
    static function isValidUrl($url)

    /**
     * 域名是否合法
     * @param $domain
     * @return boolean
     */
    static function isValidDomain($domain)

    /**
     * ip是否合法
     * @param $ip
     * @return boolean
     */
    static function isValidIp($ip)

    /**
     * CN固话是否合法
     * @param $tel
     * @return boolean
     */
    static function isValidTel($tel)

    /**
     * QQ号码是否合法
     * @param $qq
     * @return boolean
     */
    static function isValidQQ($qq)

    /**
     * 留言内容是否合法(最少15字)
     * @param $content
     * @return boolean
     */
    static function isValidContent($content)

    /**
     * 身份证合法性验证
     * @param string $idCard 身份证号码
     * @return boolean
     */
    static function isValidIdCard($idCard)

    /**
     * 是否为合法的银行卡号
     * @param $card_number
     * @return bool
     */
    static function isBankCard($card_number)

    /**
     * 验证组织机构代码是否合法：组织机构代码为8位数字或者拉丁字母+“-”+1位校验码。
     * @param string $value 字符
     * @return boolean
     */
    static function isValidOrgCode($value)

    /**
     * 验证国税税务登记号是否合法:税务登记证是6位区域代码+组织机构代码
     * @param string $taxCode 税字号
     * @return boolean
     */
    static function isValidTaxCode($taxCode)



