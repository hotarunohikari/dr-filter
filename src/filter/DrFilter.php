<?php

namespace dr\filter;

/**
 * 输入过滤类,违规数据均替换为null
 * Class DrFilter
 * @package dr\filter
 * hotarunohikari
 */
class DrFilter
{

    // 默认过滤的字符
    private $defaultDeny = ['/', '\\', ';', '<', '>', '\'', '\"', '%', '(', ')', '&', '+', '=', '||', '&quot;', '&apos;', '&amp;', '&lt;', '&gt;'];
    // 内置过滤规则
    private $rule = [
        0 => '/[\s\S]/',
        1 => '/^[\x{2E80}-\x{9FFF}0-9a-zA-Z_]+$/u',
        2 => '/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_]+$/u',
        3 => '/^[A-Za-z0-9]+$/',
        4 => '/^[0-9]+$/',
    ];

    // 严格等级
    private $strict = 1;
    // 自定义正则
    private $preg;
    // 默认单例
    private static $_drFilter;

    /**
     * 单例使用,设置过滤等级即可
     * @param $strict
     * @return DrFilter
     */
    static function instance($strict = 0) {
        if (!self::$_drFilter) {
            self::$_drFilter = new DrFilter($strict);
        }
        return self::$_drFilter;
    }

    // 实例化时指定过滤等级
    function __construct($strict = 0) {
        $this->strict = $strict;
    }

    /**
     * 设置默认的过滤字符
     * @param array $deny
     * @return $this;
     */
    function setDefaultDeny(array $deny) {
        $this->defaultDeny = $deny;
        return $this;
    }

    /**
     * 查看默认的过滤字符
     * @return array
     */
    function getDefaultDeny() {
        return $this->defaultDeny;
    }

    /**
     * 查看默认的过滤等级
     * @return mixed
     */
    function getStrict() {
        return $this->strict;
    }

    /**
     * 设置过滤等级
     * @param int $strict
     * @return $this
     */
    function setStrict(int $strict) {
        $this->strict = $strict;
        return $this;
    }

    function setPreg($preg) {
        $this->preg = $preg;
        return $this;
    }

    /**
     * 安全过滤输入,支持数组
     * 1.筛选默认过滤字符
     * 2.根据过滤等级或附加正则筛选
     * @param string|array $input 输入
     * @param int $strict 过滤级别
     * @return array
     */
    function filter($input, $strict = null) {
        $input  = (array)$input;
        $strict = $strict ?? $this->strict;
        array_walk($input, function (&$val) use ($strict) {
            $val = $this->filterInput($val, $strict);
        });
        return $input;
    }

    /**
     * 过滤输入信息
     * @param $input
     * @param int $strict
     * @return string|string[]|null
     */
    private function filterInput($input, $strict) {
        $deny = $this->defaultDeny;
        foreach ($deny as $chr) {
            if (strpos($input, $chr) > -1) {
                return null;
            }
        }
        if ($this->preg && !preg_match($this->preg, $input)) {
            return null;
        } else {
            $pattern = empty($this->rule[$strict]) ? $this->rule[3] : $this->rule[$strict];
            if (!preg_match($pattern, $input)) {
                return null;
            }
        }
        $search  = [" ", "　", "\n", "\r", "\t"];
        $replace = ["", "", "", "", ""];
        return str_replace($search, $replace, $input);
    }

}