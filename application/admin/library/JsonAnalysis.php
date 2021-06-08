<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/5/28
 * Time: 14:21
 */

namespace app\admin\library;


class JsonAnalysis
{

    /**
     * 解析json获取模块api地址
     * @param string $json
     * @return array|mixed
     */
    public static function moduleApi($json='')
    {
        $data = [];
        if ($json){
            $data = json_decode($json,true);
            if ($data){
                $data = $data['path'];
            }
        }
        return $data;
    }

    /**
     * 解析获取模块列表静态查询条件
     * @param $data
     * @return array
     */
    public static function staticCondition($data)
    {
        $result = [];
        foreach ($data as $value){
            $item = [];
            $json_data = json_decode($value['search_rule'],true);
            if ($json_data){
                $item['name'] = $value['name'];
                $item['option'] = $json_data['rule'];
                $item['value'] = $json_data['value'];
            }

            array_push($result,$item);
        }
        return $result;
    }

    public static function viewCreate($column, $table_name = '')
    {
        if (is_array($column)){
            foreach ($column as $value){
                if (!empty($table_name)){
                    $result['module'] = $table_name;
                }
                $result['name'] = $value['name'];
                $result['description'] = $value['description'];
                $result['type'] = DbMap::parseType($value['input_type']);
                $result['multiple'] = !empty($value['is_multiple']) ? true : false;
                $result['search'] = !empty($value['search_rule']) ? true : false;
                if ($result['search']){//存在搜索项则提取搜索规则
                    $search_rule = json_decode($value['search_rule'],320);
                    $result['rule'] = $search_rule['rule'];
                    if (!empty($search_rule['option'])){
                        $result['option'] = self::optionData($search_rule['option']);
                    }
                }

            }
        }

        return $result;
    }

    public static function optionData($option)
    {
        $resule = [];
        switch ($option['type']) {
            case 'api':
                $resule['type'] = 'api';
                $resule['url'] = $option['url'];

            case 'static':
                $resule['type'] = 'static';
                $resule['data'] = $option['data'];
        }
        return $resule;
    }
}