<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:84:"D:\phpstudy_pro\WWW\code\create\public/../application/admin\view\mw_column\edit.html";i:1622101554;s:74:"D:\phpstudy_pro\WWW\code\create\application\admin\view\layout\default.html";i:1617358420;s:71:"D:\phpstudy_pro\WWW\code\create\application\admin\view\common\meta.html";i:1617358420;s:73:"D:\phpstudy_pro\WWW\code\create\application\admin\view\common\script.html";i:1617358420;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">
<meta name="robots" content="noindex, nofollow">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Module_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-module_id" data-rule="required" data-source="mw_module/index" class="form-control selectpage" name="row[module_id]" type="text" value="<?php echo htmlentities($row['module_id']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" class="form-control" name="row[name]" type="text" value="<?php echo htmlentities($row['name']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-description" class="form-control" name="row[description]" type="text" value="<?php echo htmlentities($row['description']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Input_type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-input_type" class="form-control" name="row[input_type]" type="text" value="<?php echo htmlentities($row['input_type']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Output_type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-output_type" class="form-control" name="row[output_type]" type="text" value="<?php echo htmlentities($row['output_type']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Is_quick_search'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-is_quick_search" class="form-control" name="row[is_quick_search]" type="number" value="<?php echo htmlentities($row['is_quick_search']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Is_multiple'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-is_multiple" class="form-control" name="row[is_multiple]" type="number" value="<?php echo htmlentities($row['is_multiple']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Prompt'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-prompt" class="form-control" name="row[prompt]" type="text" value="<?php echo htmlentities($row['prompt']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Placeholder'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-placeholder" class="form-control" name="row[placeholder]" type="text" value="<?php echo htmlentities($row['placeholder']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Link'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-link" class="form-control " rows="5" name="row[link]" cols="50"><?php echo htmlentities($row['link']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Search_rule'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-search_rule" class="form-control " rows="5" name="row[search_rule]" cols="50"><?php echo htmlentities($row['search_rule']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Search_static'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-search_static" class="form-control selectpicker" name="row[search_static]">
                <?php if(is_array($searchStaticList) || $searchStaticList instanceof \think\Collection || $searchStaticList instanceof \think\Paginator): if( count($searchStaticList)==0 ) : echo "" ;else: foreach($searchStaticList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['search_static'])?$row['search_static']:explode(',',$row['search_static']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Option'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-option" class="form-control " rows="5" name="row[option]" cols="50"><?php echo htmlentities($row['option']); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Create_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-create_time" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[create_time]" type="text" value="<?php echo $row['create_time']?datetime($row['create_time']):''; ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
