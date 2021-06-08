define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mw_module/index' + location.search,
                    add_url: 'mw_module/add',
                    edit_url: 'mw_module/edit',
                    del_url: 'mw_module/del',
                    multi_url: 'mw_module/multi',
                    import_url: 'mw_module/import',
                    table: 'mw_module',
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
                        // {field: 'project_id', title: __('Project_id')},
                        {field: 'mwproject.name', title: __('Mwproject.name'), operate: 'LIKE'},
                        // {field: 'connection_id', title: __('Connection_id')},
                        {field: 'mwconnection.name', title: __('Mwconnection.name'), operate: 'LIKE'},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'table_name', title: __('Table_name'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'mwproject.id', title: __('Mwproject.id')},
                        // {field: 'mwproject.code', title: __('Mwproject.code'), operate: 'LIKE'},
                        // {field: 'mwproject.create_time', title: __('Mwproject.create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'mwconnection.id', title: __('Mwconnection.id')},
                        // {field: 'mwconnection.type', title: __('Mwconnection.type')},
                        // {field: 'mwconnection.host', title: __('Mwconnection.host'), operate: 'LIKE'},
                        // {field: 'mwconnection.user', title: __('Mwconnection.user'), operate: 'LIKE'},
                        // {field: 'mwconnection.password', title: __('Mwconnection.password'), operate: 'LIKE'},
                        // {field: 'mwconnection.create_time', title: __('Mwconnection.create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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