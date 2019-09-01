#!/usr/bin/env php
<?php
/**
 * @author czz
 */

function index($page = 0)
{
    $table_name = 'nice_xz_car';
    $dir_name = 'xz';
    $TableName = convertUnderline($table_name);

    // 生成model文件
    $tpl_model = file_get_contents('tpl_model.php');
    $tpl_model = str_replace('DATE_TIME', date("Y-m-d H:i"), $tpl_model);
    $tpl_model = str_replace('MODEL_NAME', $TableName, $tpl_model);
    $tpl_model = str_replace('TABLE_NAME', $table_name, $tpl_model);

    // 生成controller文件
    $tpl_controller = file_get_contents('tpl_controller.php');
    $tpl_controller = str_replace(
        'DATE_TIME', date("Y-m-d H:i"), $tpl_controller
    );
    $tpl_controller = str_replace(
        'CONTROLLER_NAME', $TableName, $tpl_controller
    );
    $tpl_controller = str_replace('TABLE_NAME', $table_name, $tpl_controller);
    $tpl_controller = str_replace('DIR_NAME', $dir_name, $tpl_controller);
    $tpl_controller = str_replace('MODEL_NAME', $TableName, $tpl_controller);

    file_put_contents($TableName . '_model.php', $tpl_model);
    echo "生成model文件-------" . $TableName . '_model.php';
    echo "<br>";

    file_put_contents($TableName . '.php', $tpl_controller);
    echo "生成controller文件-------" . $TableName . '.php';
    exit;

    // TODO 生成文档
}

function convertUnderline($str, $search = 'nice')
{
    $str = preg_replace_callback(
        '/([-_]+([a-z]{1}))/i', function($matches) {
        return strtoupper($matches[2]);
    }, $str
    );

    return str_replace($search, '', $str);
}

index();
