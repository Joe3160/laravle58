<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/12
 * Time: 11:01
 */
function check_mobile($mobile)
{
    $pattern = '/^(13[0-9]|14[0|9]|15[0-9]|167[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/';
    $bool = false;
    if (preg_match($pattern, $mobile)) {
        $bool = true;
    }
    return $bool;
}

function check_user_name($name)
{
    $len = mb_strlen($name);
    if ($len > 20 || $len < 4) {
        return false;
    }
    $pattern = '/^[a-zA-Z]+\w$/';
    $bool = false;
    if (preg_match($pattern, $name)) {
        $bool = true;
    }
    return $bool;


}


function dataFormat($code = 0, $msg = '', $data = [])
{
    if (func_num_args() == 1) {
        $args = func_get_arg(0);
        $code = (string)array_shift($args);
        $msg = (string)array_shift($args);
        $data = array_shift($args);
    }
    $result = [
        'code' => (string)$code,
        'msg'  => (string)$msg,
    ];
    if (empty($data)) {
        return $result;
    }
    if (is_array($data) || is_object($data)) {
        $data = recursion(json_decode(json_encode($data), true));
    } else {
        $data = strval($data);
    }
    //数据中如果有一层data,则不再添加一层data
    if (is_array($data) && count($data) == 1 && key_exists('data', $data)) {
        return array_merge($result, $data);
    } else {
        $result['data'] = $data;
        return $result;
    }
}

function recursion($arr = [])
{
    if (empty($arr)) {
        return [];
    }
    $arr = json_decode(json_encode($arr), true);
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            $arr[$k] = recursion($v);
        } else {
            $arr[$k] = strval($v);
        }
    }
    return $arr;
}

function getTree($data, $pid = 0, $sub_name = 'sub', $parent_name = 'parent_id', $id_name = 'id')
{
    $tree = [];
    foreach ($data as $k => $v) {
        if ($v[$parent_name] == $pid) {
            $v[$sub_name] = getTree($data, $v[$id_name], $sub_name, $parent_name, $id_name);
            if (empty($v[$sub_name])) {
                unset($v[$sub_name]);//删除空数据
            }
            $tree[] = $v;
            unset($data[$k]);//减少内存消耗
        }
    }
    return $tree;
}

