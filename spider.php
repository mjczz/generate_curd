<?php
/**
 * namespace bank_spider;
 * Created by czz.
 * User: czz
 * Date: 2019/9/12
 * Time: 10:21
 */
require __DIR__ . '/vendor/autoload.php';

use QL\QueryList;
use GuzzleHttp\Client;

function getData($base_url = '', $param = [], $method = 'get')
{
    try {
        $ql = QueryList::$method($base_url);
        $html = $ql->getHtml();
        $table = QueryList::html($html)->find('table:table');

        // 采集表头
        $tableHeader = $table->find('tr>th')->texts();
        $header = $tableHeader->all();

        // 采集表的每行内容
        $tableRows = $table->find('tr:gt(0)')->map(
                function($row) {
                    return $row->find('td')->texts()->all();
                }
            );

        return [
            'header'            => $tableHeader->all(),
            'rows'              => $tableRows->all(),
        ];

    } catch(Exception $e) {
        return $e->getMessage();
    }
}

$province_arr = array(
        "jiangsu" => "江苏",
        "guangdong" => "广东",
        //"shandong" => "山东",
        //"hebei" => "河北",
        //"zhejiang" => "浙江",
        //"fujian" => "福建",
        //"liaoning" => "辽宁",
        //"anhui" => "安徽",
        //"hubei" => "湖北",
        //"sichuan" => "四川",
        //"shanxisheng" => "陕西",
        //"hunan" => "湖南",
        //"shanxi" => "山西",
        //"guizhou" => "贵州",
        //"henan" => "河南",
        //"heilongjiang" => "黑龙江",
        //"jilin" => "吉林",
        //"xinjiang" => "新疆",
        //"shanghai" => "上海",
        //"gansu" => "甘肃",
        //"yunnan" => "云南",
        //"beijing" => "北京",
        //"neimenggu" => "内蒙古",
        //"tianjin" => "天津",
        //"jiangxi" => "江西",
        //"chongqing" => "重庆",
        //"guangxi" => "广西",
        //"ningxia" => "宁夏",
        //"hainan" => "海南",
        //"qinghai" => "青海",
        //"xianggang" => "香港",
        //"xicang" => "西藏",
        //"aomen" => "澳门",
);

$data = [];
ini_set ('memory_limit', '500M');

$filed = [
    'bank_no' => '行号',
    'bank_name' => '名称',
    'mobile' => '电话',
    'zip_code' => '邮编',
    'address' => '地址',
    'WWIFT CODE' => 'WWIFT CODE',
];


foreach ($province_arr as $key => $item) {
    !isset($data[$key]) && $data[$key] = [];
    $page = 1;

    while ($page != 0 && $page < 2) {
        $base_url = "http://5cm.cn/bank/".$key.'/'.$page;
        $res = getData($base_url, [], 'get');
        if (empty($res['rows'])) {
            $page = 0;
        } else {
            $data[$key] = array_merge($data[$key], $res['rows']);
            $page++;
        }
    }
}


$data = json_encode($data, true);
echo $data;





