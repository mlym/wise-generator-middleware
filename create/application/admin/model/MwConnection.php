<?php

namespace app\admin\model;

use think\Model;


class MwConnection extends Model
{

    

    

    // 表名
    protected $name = 'mw_connection';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'type_text',
        'create_time_text'
    ];
    

    
    public function getTypeList()
    {
        return ['mysql' => __('Mysql'), 'pgsql' => __('Pgsql')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    /**
     * @param $prohect
     * @param $module
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getModuleConnection($prohect, $module)
    {
        $where['p.code'] = $prohect;
        $where['m.name'] = $module;
        $info = $this->alias('c')
            ->join('fa_mw_module m', 'm.connection_id = c.id', 'LEFT')
            ->join('fa_mw_project p', 'm.project_id = p.id', 'LEFT')
            ->field('c.*')
            ->where($where)
            ->find();

        return $info;
    }

}
