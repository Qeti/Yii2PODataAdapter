<?php

namespace iriscrm\Yii2PODataAdapter;

use yii;
use POData\Common\ODataConstants;
use POData\OperationContext\HTTPRequestMethod;
use POData\OperationContext\IHTTPRequest;

class RequestAdapter implements IHTTPRequest
{
    /**
     * @var yii\base\Request
     */
    protected $request;

    public function __construct(yii\base\Request $request)
    {
        $this->request = $request;
    }

    /**
     * get the raw incoming url
     *
     * @return string RequestURI called by User with the value of QueryString
     */
    public function getRawUrl()
    {
        return $this->request->absoluteUrl;
    }

    /**
     * get the specific request headers
     *
     * @param string $key The header name
     *
     * @return string|null value of the header, NULL if header is absent.
     */
    public function getRequestHeader($key)
    {
        return $headers = $this->request->headers->get($key);
    }

    /**
     * Returns the Query String Parameters (QSPs) as an array of KEY-VALUE pairs.  If a QSP appears twice
     * it will have two entries in this array
     *
     * @return array[]
     */
    public function getQueryParameters()
    {
        //TODO: the contract is more specific than this, it requires the name and values to be decoded
        //not sure how to test that...
        //TODO: another issue.  This may not be the right thing to return...since POData only really understands GET requests today

        //Have to convert to the stranger format known to POData that deals with multiple query strings.
        //this makes this request a bit non compliant as it doesn't expose duplicate keys, something POData will check for
        //instead whatever parameter was last in the query string is set.  IE
        //odata.svc/?$format=xml&$format=json the format will be json
        $data = array();
        foreach($this->request->get() as $key => $value)
        {
            $data[] = array($key => $value );
        }

        return $data;
    }

    /**
     * Get the HTTP method/verb of the HTTP Request
     *
     * @return HTTPRequestMethod
     */
    public function getMethod()
    {
        return new HTTPRequestMethod($this->request->getMethod());
    }
}