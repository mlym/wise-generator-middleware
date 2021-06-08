<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2021/5/26
 * Time: 15:06
 */

namespace app\admin\library;


use think\Db;

class DbLink
{
    //编码
    //表前缀

    /**
     * 自定义数据库连接
     * @param $type //数据库类型
     * @param $host // 服务器地址
     * @param $port // 数据库连接端口
     * @param $user // 数据库用户名
     * @param $password // 数据库密码
     * @param $database // 数据库名
     * @param string $charset   // 数据库编码默认采用utf8
     * @return \think\db\Connection
     * @throws \think\Exception
     */
    public static function Connect($type,$host,$port,$user,$password,$database,$charset='utf8')
    {
        $db_config = "{$type}://{$user}:{$password}@{$host}:{$port}/{$database}#{$charset}";

        return Db::connect($db_config);
    }

    /**
     * 获取数据表结构
     * @param $aconnect //连接对象
     * @param $table    //数据表名，暂时需加前缀
     * @return array
     */
    public static function getStructure($aconnect, $table)
    {
        $sql = 'select column_name,column_default,is_nullable,data_type,character_maximum_length,numeric_scale,column_comment,column_type from information_schema.columns where table_name = ? ';
        $result = $aconnect->query($sql, [$table]);

        return $result;
    }
}