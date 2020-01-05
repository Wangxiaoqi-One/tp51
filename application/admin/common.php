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