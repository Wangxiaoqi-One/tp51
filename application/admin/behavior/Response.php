<?php
namespace app\admin\behavior;

class Response 
{
    public function run($params)
    {
        // 行为逻辑
        if(request()->isPost()){
            $data = $params->getData();
            if (!empty($data) && is_array($data)) {
                if (input('?param.navTabId')) {
                    $data['navTabId'] = input('param.navTabId');
                }

                if (input('?param.callbackType')) {
                    $data['callbackType'] = input('param.callbackType');
                }
                if (input('?param.forwardUrl')) {
                    $data['forwardUrl'] = input('param.forwardUrl');
                }
                $params->data($data);
            }
        }
    }
}