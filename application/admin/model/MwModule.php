<?php

namespace app\admin\model;

use think\Model;


class MwModule extends Model
{

    

    

    // 表名
    protected $name = 'mw_module';
    
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


    public function mwproject()
    {
        return $this->belongsTo('MwProject', 'project_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function mwconnection()
    {
        return $this->belongsTo('MwConnection', 'connection_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    /**
     * @param $prohect
     * @param $module
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getModeuleInfo($prohect, $module)
    {
        $where['p.code'] = $prohect;
        $where['m.name'] = $module;

        $info = $this->alias('m')
            ->join('fa_mw_project p', 'm.project_id = p.id', 'LEFT')
            ->where($where)
            ->find();

        return $info;
    }
}
