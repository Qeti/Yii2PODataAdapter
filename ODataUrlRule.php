<?php

namespace iriscrm\Yii2PODataAdapter;

use yii;
use yii\web\UrlRule;

class ODataUrlRule extends UrlRule
{
    public $baseUrl = 'odata.svc';

    public $route = 'o-data';

    public function init()
    {
        if (!$this->pattern) {
            $tr = [
                '.' => '\\.',
                '*' => '\\*',
                '$' => '\\$',
                '[' => '\\[',
                ']' => '\\]',
                '(' => '\\(',
                ')' => '\\)',
            ];
            $this->pattern = '#^(' . trim(strtr($this->baseUrl, $tr), '/') . ')()|(\/.*)(\?.*)$#u';
        }
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        if (preg_match($this->pattern, $pathInfo, $matches)) {
            return [$this->route, []];
        }
        return false;
    }
}