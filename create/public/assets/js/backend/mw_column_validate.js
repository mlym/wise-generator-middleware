define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mw_column_validate/index' + location.search,
                    add_url: 'mw_column_validate/add',
                    edit_url: 'mw_column_validate/edit',
                    del_url: 'mw_column_validate/del',
                    multi_url: 'mw_column_validate/multi',
                    import_url: 'mw_column_validate/import',
                    table: 'mw_column_validate',
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
                        // {field: 'column_id', title: __('Column_id')},
                        {field: 'mwcolumn.name', title: __('Mwcolumn.name'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), operate: 'LIKE'},
                        {field: 'trigger', title: __('Trigger'), searchList: {"blur":__('Blur'),"change":__('Change')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'mwcolumn.id', title: __('Mwcolumn.id')},
                        // {field: 'mwcolumn.module_id', title: __('Mwcolumn.module_id')},
                        // {field: 'mwcolumn.description', title: __('Mwcolumn.description'), operate: 'LIKE'},
                        // {field: 'mwcolumn.input_type', title: __('Mwcolumn.input_type'), operate: 'LIKE'},
                        // {field: 'mwcolumn.output_type', title: __('Mwcolumn.output_type'), operate: 'LIKE'},
                        // {field: 'mwcolumn.is_quick_search', title: __('Mwcolumn.is_quick_search')},
                        // {field: 'mwcolumn.is_multiple', title: __('Mwcolumn.is_multiple')},
                        // {field: 'mwcolumn.prompt', title: __('Mwcolumn.prompt'), operate: 'LIKE'},
                        // {field: 'mwcolumn.placeholder', title: __('Mwcolumn.placeholder'), operate: 'LIKE'},
                        // {field: 'mwcolumn.create_time', title: __('Mwcolumn.create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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