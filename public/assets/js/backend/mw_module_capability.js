define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mw_module_capability/index' + location.search,
                    add_url: 'mw_module_capability/add',
                    edit_url: 'mw_module_capability/edit',
                    del_url: 'mw_module_capability/del',
                    multi_url: 'mw_module_capability/multi',
                    import_url: 'mw_module_capability/import',
                    table: 'mw_module_capability',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        // {field: 'primary_module_id', title: __('Primary_module_id')},
                        {field: 'mwmodule.name', title: __('Mwmodule.name'), operate: 'LIKE'},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), searchList: {"base":__('Base'),"sub_module":__('Sub_module')}, formatter: Table.api.formatter.normal},
                        {field: 'is_switch', title: __('Is_switch'), table: table, formatter: Table.api.formatter.toggle},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'mwmodule.id', title: __('Mwmodule.id')},
                        // {field: 'mwmodule.project_id', title: __('Mwmodule.project_id')},
                        // {field: 'mwmodule.connection_id', title: __('Mwmodule.connection_id')},
                        // {field: 'mwmodule.table_name', title: __('Mwmodule.table_name'), operate: 'LIKE'},
                        // {field: 'mwmodule.create_time', title: __('Mwmodule.create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});