<?php

namespace app\admin\controller;

use app\admin\library\DbLink;
use app\admin\library\DbMap;
use app\admin\library\JsonAnalysis;
use app\admin\model\AdminLog;
use app\common\controller\Backend;
use think\Config;
use think\Controller;
use think\Db;
use think\Hook;
use think\Validate;

/**
 * 后台首页
 * @internal
 */
class Index extends Backend
{

    protected $noNeedLogin = ['login','middleware'];
    protected $noNeedRight = ['index', 'logout'];
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');
    }

    public function test(){
        $all = Db::connect([
            // 数据库类型
            'type'            => 'mysql',
            // 服务器地址
            'hostname'        => '127.0.0.1',
            // 数据库名
            'database'        => 'fastadmin',
            // 用户名
            'username'        => 'root',
            // 密码
            'password'        => 'root',
        ])->table('mw_project')->select();
        var_dump($all);
        return 'test';
    }


    /**
     * 后台首页
     */
    public function index()
    {
        //左侧菜单
        list($menulist, $navlist, $fixedmenu, $referermenu) = $this->auth->getSidebar([
            'dashboard' => 'hot',
            'addon'     => ['new', 'red', 'badge'],
            'auth/rule' => __('Menu'),
            'general'   => ['new', 'purple'],
        ], $this->view->site['fixedpage']);
        $action = $this->request->request('action');
        if ($this->request->isPost()) {
            if ($action == 'refreshmenu') {
                $this->success('', null, ['menulist' => $menulist, 'navlist' => $navlist]);
            }
        }
        $this->view->assign('menulist', $menulist);
        $this->view->assign('navlist', $navlist);
        $this->view->assign('fixedmenu', $fixedmenu);
        $this->view->assign('referermenu', $referermenu);
        $this->view->assign('title', __('Home'));
        return $this->view->fetch();
    }

    /**
     * 管理员登录
     */
    public function login()
    {
        $url = $this->request->get('url', 'index/index');
        if ($this->auth->isLogin()) {
            $this->success(__("You've logged in, do not login again"), $url);
        }
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $keeplogin = $this->request->post('keeplogin');
            $token = $this->request->post('__token__');
            $rule = [
                'username'  => 'require|length:3,30',
                'password'  => 'require|length:3,30',
                '__token__' => 'require|token',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                '__token__' => $token,
            ];
            if (Config::get('fastadmin.login_captcha')) {
                $rule['captcha'] = 'require|captcha';
                $data['captcha'] = $this->request->post('captcha');
            }
            $validate = new Validate($rule, [], ['username' => __('Username'), 'password' => __('Password'), 'captcha' => __('Captcha')]);
            $result = $validate->check($data);
            if (!$result) {
                $this->error($validate->getError(), $url, ['token' => $this->request->token()]);
            }
            AdminLog::setTitle(__('Login'));
            $result = $this->auth->login($username, $password, $keeplogin ? 86400 : 0);
            if ($result === true) {
                Hook::listen("admin_login_after", $this->request);
                $this->success(__('Login successful'), $url, ['url' => $url, 'id' => $this->auth->id, 'username' => $username, 'avatar' => $this->auth->avatar]);
            } else {
                $msg = $this->auth->getError();
                $msg = $msg ? $msg : __('Username or password is incorrect');
                $this->error($msg, $url, ['token' => $this->request->token()]);
            }
        }

        // 根据客户端的cookie,判断是否可以自动登录
        if ($this->auth->autologin()) {
            $this->redirect($url);
        }
        $background = Config::get('fastadmin.login_background');
        $background = $background ? (stripos($background, 'http') === 0 ? $background : config('site.cdnurl') . $background) : '';
        $this->view->assign('background', $background);
        $this->view->assign('title', __('Login'));
        Hook::listen("admin_login_init", $this->request);
        return $this->view->fetch();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        $this->auth->logout();
        Hook::listen("admin_logout_after", $this->request);
        $this->success(__('Logout successful'), 'index/login');
    }

    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function middleware()
    {
        $prohect = 'P001';
        $module = 'room';
        $data = [];
        //获取模块连接数据
        $connection_model = new \app\admin\model\MwConnection();
        $aconnect_info = $connection_model->getModuleConnection($prohect, $module);
        //数据库连接
        $aconnect = DbLink::Connect($aconnect_info['type'],$aconnect_info['host'],$aconnect_info['port'],$aconnect_info['user'],$aconnect_info['password'],$aconnect_info['database']);
        //模块
        $data['module'] = $this->module($prohect, $module, $aconnect);
        //View
        $data['view'] = $this->view($prohect, $module, $aconnect);
        //能力
        $data['capability'] = $this->capability($prohect, $module, $aconnect);

        return json_encode($data,320);
    }

    //获取Module内容

    /**
     * @param $prohect
     * @param $module
     * @param $aconnect
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function module($prohect, $module, $aconnect)
    {
        $module_model = new \app\admin\model\MwModule();
        $column_model = new \app\admin\model\MwColumn();
        $relation_model = new \app\admin\model\MwModuleRelation();

        $info = $module_model->getModeuleInfo($prohect,$module);

        $module=[];
        $module['api'] = JsonAnalysis::moduleApi($info['api']);//模块中API配置（json）解析

        $module['name'] = $info['table_name'];//主模块名称（即表名）
        $module['condition'] = [];//主模块列表页固定不变的静态查询条件   查询表中字段的默认搜索条件
        $column_condition = $column_model->getStaticCondition($info['id'], 1);
        if ($column_condition){
            $module['condition'] = JsonAnalysis::staticCondition($column_condition);
        }

        //数据表schema信息
        $schema = DbLink::getStructure($aconnect,$module['name']);
        //数据表结构转换映射
        $module['schema'] = DbMap::structureSwitch($schema);

        $module['relation'] = [];//关联模块
        //获取关联模块表名列表
        $relation_list = $relation_model->getRelationList($info['id']);
        if ($relation_list){
            $module['relation'] = DbMap::joinCondition($relation_list);
        }
        return $module;
    }
    //获取view内容

    /**
     * @param $prohect
     * @param $module
     * @param $aconnect
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function view($prohect, $module, $aconnect)
    {
        $module_model = new \app\admin\model\MwModule();
        $column_model = new \app\admin\model\MwColumn();
        $relation_model = new \app\admin\model\MwModuleRelation();
        //获取主模块信息
        $info = $module_model->getModeuleInfo($prohect,$module);
        //获取模块字段列表
        $module_column_list =$column_model->where('module_id',$info['id'])->select();
        $main_data = JsonAnalysis::viewCreate($module_column_list);

        $relation_data = [];
        //获取关联模块
        $relevance_chart = $relation_model->getRelationList($info['id']);;
        //存在关联模块则获取关联模块字段
        if (!empty($relevance_chart)){
            foreach ($relevance_chart as $value){
                $module_column_list =$column_model->where('module_id',$info['id'])->select();
                $item_data = JsonAnalysis::viewCreate($module_column_list,$value['table_name']);
                //将每个关联表字段添加到关联列表中
                array_push($relation_data,$item_data);
            }
        }
        $result = array_merge($main_data,$relation_data);

        return $result;
    }

    //获取capability内容

    /**
     * @param $prohect
     * @param $module
     * @param $aconnect
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function capability($prohect, $module, $aconnect)
    {
        //获取模块能力
        $capability_model = new \app\admin\model\MwModuleCapability();
        $module_list = $capability_model->getModuleList($prohect, $module);

        $capability = [];
        if ($module_list){
            foreach ($module_list as $value){
                $capability[$value['name']] = $value['is_switch'] ? true : false;
            }
        }
        return $capability;
    }



}
