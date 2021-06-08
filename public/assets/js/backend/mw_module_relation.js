define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mw_module_relation/index' + location.search,
                    add_url: 'mw_module_relation/add',
                    edit_url: 'mw_module_relation/edit',
                    del_url: 'mw_module_relation/del',
                    multi_url: 'mw_module_relation/multi',
                    import_url: 'mw_module_relation/import',
                    table: 'mw_module_relation',
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
                        {field: 'mwmodule.name', title: __('Primary_module_id'), operate: 'LIKE'},
                        // {field: 'mwmodule.name', title: __('relation_module_id'), operate: 'LIKE'},
                        // {field: 'primary_module_id', title: __('Primary_module_id')},
                        // {field: 'relation_module_id', title: __('Relation_module_id')},
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