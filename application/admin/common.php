<?php

function userIDtoPhone($userID){
    $username = model('Users')->where('id', $userID)->value('username');
    return $username ?? '姓名';
}

function majorIdToMajorName($lesson){
    $majorname = model('Major')->where('id', $lesson)->value('majorname');
    return $majorname ?? '专业';
}

function majorIdToMajorTime($lesson){
    $majortime = model('Major')->where('id', $lesson)->value('studytime');
    return $majortime ?? '7天';
}

function setImageConfig($filePath, $config){
    $text = "<?php\r\nreturn " . var_export($config, true) . ";";  
    return file_put_contents($filePath, $text);
}

function isLogin(){
    $user = session(config('auth.SESSION_ADMIN_KEY'), '', 'admin');
        if(empty($user['uid'])){
            return false;
        }else{
            return $user['uid'];
        }
}

function isAdministrator(){
    $uid = isLogin();
    if($uid){
        $groupid = model('AuthGroupAccess')->where('uid', $uid)->value('group_id');
        if($groupid === config("auth.USER_ADMINISTRATOR")){
            return true;
        }else{
            return false;
        }
    }
    return false;

}

