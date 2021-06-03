<?php

namespace app\admin\model;

use think\Model;


class MwModuleCapability extends Model
{

    

    

    // 表名
    protected $name = 'mw_module_capability';
    
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
        return ['base' => __('Base'), 'sub_module' => __('Sub_module')];
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


    public function mwmodule()
    {
        return $this->belongsTo('MwModule', 'primary_module_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    /**
     * @param $prohect
     * @param $module
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getModuleList($prohect, $module)
    {
        $where['p.code'] = $prohect;
        $where['m.name'] = $module;

        $list = $this->alias('mc')
            ->join('fa_mw_module m','m.id=mc.primary_module_id','LEFT')
            ->join('fa_mw_project p','p.id=m.project_id','LEFT')
            ->where($where)
            ->field('mc.name,mc.is_switch')
            ->select();

        return $list;
    }


}
