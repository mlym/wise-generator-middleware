<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/5/26
 * Time: 16:21
 */

namespace app\admin\library;


class DbMap
{

    /**
     * 数据表结构转换映射
     * @param $data
     * @return array
     */
    public static function structureSwitch($data)
    {
        $result = [];
        if ($data){
            foreach ($data as $value){
                $item ['name']= $value['column_name'];  //字段名称
                $item ['comment']= $value['column_comment']; //字段备注
                $item ['type']= $value['data_type'];    //字段类型
                $item ['length']= strstr(substr($value['column_type'],strripos($value['column_type'],"(")+1), ')', true);//字段长度，
                $item ['default']= $value['column_default'] ? $value['column_default'] : '';//默认值，默认为空
                $item ['is_null']= $value['is_nullable'];//是否允许为空，默认为true
                if ($item ['type'] == 'float'){
                    //字段长度，包含小数点时为[10,5]
                    $item ['length'] = explode(',', $item ['length']);
                }
                array_push($result, $item);
            }
        }
        return $result;
    }

    /**
     * 关联条件转换
     * @param $data
     * @return array
     */
    public static function joinCondition($relation_list)
    {
        $result = [];
        //获取关联模块表名列表
        foreach ($relation_list as $value){
            $item['name'] = $value['table_name'];
            $relation_condition = json_decode($value['relation_condition'], 320);
            $item['join'] = $relation_condition['join_type'];
            $item['relation_type'] = $relation_condition['relation_type'];
            $item['condition']['main'] = $relation_condition['condition']['main'];
            $item['condition']['relation'] = $relation_condition['condition']['relation'];

            array_push($result, $item);
        }
        return $result;
    }

    public static function parseType($column)
    {
        $type = '';
        switch ($column) {
            case 'int':
                $type = 'int';
                break;
            case 'char':
            case 'varchar':
                $type = 'string';
                break;
            case 'enum':
                $type = 'select';
                break;
            case 'set':
                $type = 'select';
                break;
            case 'text':
                $type =  'textarea';
                break;
            case 'datetime':
            case 'timestamp':
                $type = 'datetime';
                break;
            case 'date':
                $type = 'date';
        }
        return $type;
    }
}