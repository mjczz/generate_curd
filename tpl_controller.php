<?php
/**
 * Date: DATE_TIME
 * @author czz
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type:text/html;charset=utf-8');
include dirname(__FILE__) . '/../ApiCommon.php';

class CONTROLLER_NAME extends ApiCommon
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('v1/DIR_NAME/MODEL_NAME_model', 'model');
    }

    // 列表
    public function listData()
    {
        $post = $this->input->post('body');
        $param = $this->getWhere($post);
        $page = ($param['page'] - 1) * $param['per_page'];
        $res = $this->selectData($param, $page, $param['per_page']);

        $result['param'] = $post;
        $result['counts'] = $res['count'];
        $result['data'] = $res['list'];
        self::success($result);
    }

    // 转换查询条件
    public function getWhere($post)
    {
        $param = $post;
        $param['per_page'] = !empty($post['per_page']) ? $post['per_page'] : 0; // 0或不传此参数，查询所有记录
        $param['page'] = !empty($post['page']) ? $post['page'] : 1;

        return $param;
    }

    // 单条记录
    public function info()
    {
        $post = $this->input->post('body');
        $param = $this->getWhere($post);

        $res = $this->selectData($param, 0, 1, 0);
        !empty($res['list']) ? self::success($res['list'][0]) : self::fail('无数据','2004');
    }

    /**
     * @param $param     查询参数
     * @param $page      当前页
     * @param $per_page  每页条数
     * @param $select_count  是否查询总条数
     *
     * @return mixed
     */
    public function selectData($param, $page, $per_page, $select_count = 1)
    {
        if (!empty($select_count)) {
            $res['count'] = $this->model->countData($param);
        }

        $res['list'] = $this->model->listData($param, $page, $per_page);
        !empty($res['list']) && $res['list'] = $this->transferData($res['list']);

        return $res;
    }

    // 转换数据
    public function transferData($list)
    {
        $cache_options = self::Mget("cache_options");
        $cache_admin = self::Mget("cache_admin");

        foreach ($list as &$item) {
            $item = $this->transfer($item, $cache_options, $cache_admin);
        }

        return $list;
    }

    // 新增
    public function add()
    {
        $post = $this->input->post('body');
        $this->repeated_submit($post['user_id'].'_'.__CLASS__.'_'.__FUNCTION__);
        $this->validateNumeric($post);

        $gm = self::Mget("gm_".$post['user_id']);
        self::is_empty($gm,'登录账号异常',6001);

        $post['cuid'] = $gm['userid'];
        $res = $this->model->create($post);

        return $res ? self::success() : self::fail();
    }

    // 编辑
    public function edit()
    {
        $post = $this->input->post('body');
        $this->repeated_submit($post['user_id'].'_'.__CLASS__.'_'.__FUNCTION__);
        $this->validateNumeric($post);

        empty($post['id']) && self::fail('id：不能为空');
        $gm = self::Mget("gm_".$post['user_id']);
        self::is_empty($gm,'登录账号异常',6001);

        $info = getData(TABLE_NAME, array("id" => $post['id']), array(), 1);
        empty($info) && self::fail('数据不存在');

        $post['muid'] = $gm['userid'];
        $res = $this->model->save($post);

        return $res ? self::success() : self::fail();
    }

    // 删除
    public function del()
    {
        $post = $this->input->post('body');
        $this->repeated_submit($post['user_id'].'_'.__CLASS__.'_'.__FUNCTION__);

        empty($post['id']) && self::fail('id：不能为空');
        $gm = self::Mget("gm_".$post['user_id']);
        self::is_empty($gm,'登录账号异常',6001);

        // TODO 是否需要满足一些条件，才可以删除

        $res = $this->model->delData($post['id']);

        return $res ? self::success() : self::fail();
    }

    // 验证数字
    public function validateNumeric($post)
    {
        $this->issetAndIsNumeric($post, array(
            "id",
        ));
    }

}


