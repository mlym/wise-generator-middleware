<?php

namespace app\admin\model;

use think\Model;


class MwModuleRelation extends Model
{

    

    

    // 表名
    protected $name = 'mw_module_relation';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'create_time_text'
    ];
    

    



    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


    public function mwmodule()
    {
        return $this->belongsTo('MwModule', 'primary_module_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function user()
    {
        return $this->belongsTo('User', 'relation_module_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    /**
     * @param $module_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRelationList($module_id)
    {
        $where['mr.primary_module_id'] = $module_id;

        $list = $this->alias('mr')
            ->join('fa_mw_module m','m.id=mr.relation_module_id','LEFT')
            ->where($where)
            ->field('m.table_name,mr.relation_condition')
            ->select();

        return $list;
    }
}
