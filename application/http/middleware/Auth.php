<?php
namespace app\http\middleware;

use think\facade\Log;
use traits\controller\Jump;

class Auth{

    use Jump;

    public function handle($request, \Closure $next)
    {
        $this->_auth();

        return $next($request);
    }


    //验证权限
    final function _auth(){
        
        //判断是否登录
        define('UID', isLogin());
        define('ISROOT', isAdministrator());

        
        // 所访问的url
        $url = strtolower(request()->module() . '/' . request()->controller() . '/' . request()->action());

        if (!UID && (request()->controller() != 'Pub')) {
            return $this->redirect('admin/pub/index');
        } else {
            // 进行权限验证
            if (!ISROOT && (request()->controller() != 'Pub')) {
                // 访问权限检测
                if (!$this->checkrule($url, ['1', '2'])) {
                    $this->error('未授权访问！');

                } else {
                    // 检测分类及内容有关的各项动态权限
                    $dynamic = $this->checkdynamic();
                    if (false === $dynamic) {
                        $this->error('未授权访问！');
                    }
                }
            }
            $method = request()->method();
            $param = json_encode(input('param.'), JSON_UNESCAPED_UNICODE);
            $admin_id = UID;
            $group_id = model('AuthGroupAccess')->where('uid', $admin_id)->value('group_id') ?: 0;
            $ip = ip2long(request()->ip());
            // // 记录日志
            $this->writeLog($url, $method, $param, $admin_id, $group_id, $ip);
        }

    }


    /**
     * 权限检测
     * @param string $rule 检测的规则
     * @param string $mode check模式
     * @return boolean
     * @author
     */
    final protected function checkrule($rule, $type = 1, $model = 'url')
    {
        static $auth = null;
        if (!$auth) {
            $auth = new \Auth();
        }
        if (!$auth->check($rule, UID, $type, $model)) {
            return false;
        }
        return true;
    }

    /**
     * 检测是否是需要动态判断的权限
     * @return boolean | null
     *  返回 true 则表示当前访问有权限
     *  返回 false 则表示当前访问无权限
     *  返回 null，则表示权限不明
     */
    protected function checkdynamic()
    {

    }


    /**
     * 后台操作日志
     * @param string $url 访问的url
     * @param string $method 请求类型
     * @param json $param 请求参数
     * @param integer $admin_id 管理员id
     * @param integer $group_id 管理组id
     */
    final protected function writeLog($url, $method, $param, $admin_id, $group_id, $ip)
    {
        Log::write('url:' . $url . '--method:' . $method . '--param:' . $param . '--admin_id:' . $admin_id . '--group_id:' . $group_id . 'ip:' . long2ip($ip) . '--date:' . date('Y-m-d H:i:s', time()), 'adminlog');
        $data['url'] = $url;
        $data['method'] = $method;
        $data['param'] = $param;
        $data['admin_id'] = $admin_id;
        $data['group_id'] = $group_id;
        $data['ip'] = $ip;
        model('AdminLog')->save($data);
    }

}