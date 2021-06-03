<?php

namespace app\admin\model;

use think\Model;


class MwColumn extends Model
{

    

    

    // 表名
    protected $name = 'mw_column';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'search_static_text',
        'create_time_text'
    ];
    

    
    public function getSearchStaticList()
    {
        return ['0' => __('否'), '1' => __('是')];
    }


    public function getSearchStaticTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['search_static']) ? $data['search_static'] : '');
        $list = $this->getSearchStaticList();
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
     * @param $module_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaticCondition($module_id, $search_static)
    {
        $where['module_id'] = $module_id;
        $where['search_static'] = $search_static;

        $info = $this->where($where)->select();

        return $info;
    }




}
