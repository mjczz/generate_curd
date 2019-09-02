<?php
/**
 *  Date: DATE_TIME
 *	@author czz
 */

class MODEL_NAME_model extends CI_Model
{
    protected $table = "TABLE_NAME";

    public function __construct()
    {
        parent::__construct();
    }

    // 查询条件
    public function getWhere($param)
    {
        $wherestr = " FIRST_WHERE";

        if (!empty($param['id'])) {
            $wherestr .= " AND t1.id = '". $param['id'] ."'";
        }

        $wherestr = str_replace("FIRST_WHERE AND", "WHERE", $wherestr);

        if (trim($wherestr) == 'FIRST_WHERE') {
            $wherestr = '';
        }

        return $wherestr;
    }

    // 排序
    public function getOrder($param)
    {
        empty($param['order']) && $param['order'] = 0;

        switch ($param['order']) {
            case 1:
                // TODO
                break;
            case 2:
                // TODO
                break;
            default:
                $param['order'] = " ORDER BY t1.id DESC";
                break;
        }

        return $param['order'];
    }

    // 查询列表
    public function listData($param, $page = 0, $pagenum = 10)
    {
        $wherestr = $this->getWhere($param);

        $orderstr = $this->getOrder($param);

        $sqlstr = "SELECT t1.*
                   FROM {$this->table} AS t1
                   ";

        // 满足要查询所有数据的需求
        if (!empty($param['all_data']) && $param['all_data'] == 1) {
            $sqlstr .= $wherestr.$orderstr;
        }
        // 分页查询
        else {
            $sqlstr .= $wherestr.$orderstr." LIMIT ".$pagenum." OFFSET ".$page;
        }

        return $this->db->query($sqlstr)->result_array();
    }

    // 总数
    public function countData($param)
    {
        $wherestr = $this->getWhere($param);

        $sqlstr = "SELECT COUNT(*) counts
                   FROM {$this->table} AS t1
                  ";

        $sqlstr .= $wherestr;

        $res = $this->db->query($sqlstr)->row_array();
        return $res['counts'];
    }

    // 单条数据
    public function info($param)
    {
        $wherestr = $this->getWhere($param);

        $sqlstr = "SELECT t1.* FROM {$this->table} AS t1";
        $sqlstr .= $wherestr;

        return $this->db->query($sqlstr)->row_array();
    }

    // 新增
    public function create($param)
    {
        $param['ctime'] = !isset($param['ctime']) ? $_SERVER['REQUEST_TIME'] : $param['ctime'];

        return saveData($this->table, $param);
    }

    // 更新
    public function save($param, $where = array())
    {
        $param['mtime'] = !isset($param['mtime']) ? $_SERVER['REQUEST_TIME'] : $param['mtime'];

        return !empty($where) ? saveData($this->table, $param, $where) : saveData($this->table, $param,'id',$param['id']);
    }

    // 删除
    public function delData($id)
    {
        if (empty($id)) {
            return 0;
        }

        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

}
