define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mw_relation_module/index' + location.search,
                    add_url: 'mw_relation_module/add',
                    edit_url: 'mw_relation_module/edit',
                    del_url: 'mw_relation_module/del',
                    multi_url: 'mw_relation_module/multi',
                    import_url: 'mw_relation_module/import',
                    table: 'mw_relation_module',
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
                        {field: 'mwprimarymodule.name', title: __('Mwprimarymodule.name'), operate: 'LIKE'},
                        // {field: 'primary_module_id', title: __('Primary_module_id')},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'table_name', title: __('Table_name'), operate: 'LIKE'},
                        {field: 'relation_condition', title: __('Relation_condition'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'mwprimarymodule.id', title: __('Mwprimarymodule.id')},
                        // {field: 'mwprimarymodule.project_id', title: __('Mwprimarymodule.project_id')},
                        // {field: 'mwprimarymodule.connection_id', title: __('Mwprimarymodule.connection_id')},
                        // {field: 'mwprimarymodule.table_name', title: __('Mwprimarymodule.table_name'), operate: 'LIKE'},
                        // {field: 'mwprimarymodule.create_time', title: __('Mwprimarymodule.create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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