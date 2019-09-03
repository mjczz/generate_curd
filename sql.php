#!/usr/bin/env php
<?php
/**
 * @author czz
 */
require './config.php';

function index($config)
{
    $table_name = $config['table_name'];
    $TABLE_DESC = $config['table_desc'];

    // 生成model文件
    $tpl_sql = file_get_contents('./tpl/tpl_sql.sql');
    $tpl_sql = str_replace('DATE_TIME', date("Y-m-d"), $tpl_sql);
    $tpl_sql = str_replace('TABLE_DESC', $TABLE_DESC, $tpl_sql);
    $tpl_sql = str_replace('TABLE_NAME', $table_name, $tpl_sql);

    if (!is_dir('sql')) {
        if (!mkdir('./sql', 0777, 1)) {
            echo "创建目录失败"; exit;
        }
    }

    file_put_contents('./sql/' .$table_name. '.sql', $tpl_sql);
    echo "生成sql文件-------" .$table_name. '.sql';
    exit;
}

index($config);
