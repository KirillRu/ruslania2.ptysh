<?php

class MyUrlManager extends CUrlManager
{
    public static function RewriteCurrent($controller, $lang)
    {
        $params = $_GET;
        unset($params['language']);
        $ctrl = $controller->id;
        $action = $controller->action->id;
        $param = 'language='.$lang;
        $url = Yii::app()->createUrl($ctrl.'/'.$action, $params);

        if(strpos($url, '?') === false) $url .= '?'.$param;
        else $url .= '&'.$param;

        return $url;
    }

    public static function RewriteCurrency($controller, $currency)
    {
        $params = $_GET;
        unset($params['currency']);
        $ctrl = $controller->id;
        $action = $controller->action->id;
        $param = 'currency='.$currency;
        $url = Yii::app()->createUrl($ctrl.'/'.$action, $params);

        if(strpos($url, '?') === false) $url .= '?'.$param;
        else $url .= '&'.$param;

        return $url;
    }

//    public function createUrl($route,$params=array(),$ampersand='&')
//    {
//        return 'A';
//        Yii::beginProfile('URL = '.$route);
//        $ret = parent::createUrl($route, $params, $ampersand);
//        Yii::endProfile('URL = '.$route);
//        return $ret;
//    }

}