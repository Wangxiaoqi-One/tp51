<?php

if(!function_exists('userIDtoPhone'))
{
    /**
     * 根据用户id获取用户名称
     * @param string    $userID 用户id
     * @return string
     */
    function userIDtoPhone($userID){
        $username = model('Users')->where('id', $userID)->value('username');
        return $username ?? '姓名';
    }
}


if(!function_exists('majorIdToMajorName')){
    /**
     * 根据专业id获取专业名称
     * @param string    $lesson 专业id
     * @return string
     */
    function majorIdToMajorName($lesson){
        $majorname = model('Major')->where('id', $lesson)->value('majorname');
        return $majorname ?? '专业';
    }
}


if(!function_exists('majorIdToMajorTime')){
    /**
     * 根据专业id获取专业学习时间
     * @param string    $lesson 专业id
     * @return string
     */
    function majorIdToMajorTime($lesson){
        $majortime = model('Major')->where('id', $lesson)->value('studytime');
        return $majortime ?? '7天';
    }
}


if(!function_exists('setImageConfig')){
    /**
     * 修改图片配置文件
     * @param string    $filePath 修改文件的路径
     * @param string    $config 配置信息
     * @return mixed
     */
    function setImageConfig($filePath, $config){
        $text = "<?php\r\nreturn " . var_export($config, true) . ";";  
        return file_put_contents($filePath, $text);
    }
}


if(!function_exists('isLogin')){
    /**
    * 判断是否登录
    * @return int
    */
    function isLogin(){
        if (config('auth.SESSION_ADMIN_KEY') && ($user = session(config('auth.SESSION_ADMIN_KEY'), '', 'admin'))) {
            return $user['uid'];
        } else {
            return 0;
        }
    }
}


if(!function_exists('isAdministrator'))
{
    /**
     * 判断是否是超级管理员
     * @param string    $uid 管理员id
     * @return int
     */
    function isAdministrator($uid=null){
        $uid = is_null($uid) ? isLogin() : $uid;
        return $uid && (intval($uid) === config("auth.USER_ADMINISTRATOR"));
    }
}


if(!function_exists('adminIDtoAdminName'))
{
    /**
     * 根据管理员id返回管理员名称
     * @param string    $admin_id 管理员id
     * @return string
     */
    function adminIDtoAdminName($admin_id){
        $adminName = model('Admin')->where('id', $admin_id)->value('username');
        return $adminName ?? '姓名';
    }
}


if(!function_exists('groupIDtoGroupName'))
{
    /**
     * 根据管理组id返回管理组名
     * @param string    $group_id 管理组id
     * @return string
     */
    function groupIDtoGroupName($group_id=0){
        $title = model('AuthGroup')->where('id', $group_id)->value('title');
        return $title ?? '未选择用户组';
    }

}

if (!function_exists('getGrouperName')) {
    /**
     * 根据管理组id返回管理组成员
     * @param string    $group_id 管理组id
     * @return string
     */
    function getGrouperName($group_id = 0)
    {
        $grouper = "";
        if ($group_id !== 0) {
            $admins = model("AuthGroupAccess")->where('group_id', $group_id)->column('uid');
            foreach ($admins as $uid) {
                $username = adminIDtoAdminName($uid);
                $grouper = $grouper . $username . ',';
            }
        }
        return $grouper;
    }
}