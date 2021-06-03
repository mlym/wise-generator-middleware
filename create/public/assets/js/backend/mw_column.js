define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mw_column/index' + location.search,
                    add_url: 'mw_column/add',
                    edit_url: 'mw_column/edit',
                    del_url: 'mw_column/del',
                    multi_url: 'mw_column/multi',
                    import_url: 'mw_column/import',
                    table: 'mw_column',
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
                        {field: 'module_id', title: __('Module_id')},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'description', title: __('Description'), operate: 'LIKE'},
                        {field: 'input_type', title: __('Input_type'), operate: 'LIKE'},
                        {field: 'output_type', title: __('Output_type'), operate: 'LIKE'},
                        {field: 'is_quick_search', title: __('Is_quick_search')},
                        {field: 'is_multiple', title: __('Is_multiple')},
                        {field: 'prompt', title: __('Prompt'), operate: 'LIKE'},
                        {field: 'placeholder', title: __('Placeholder'), operate: 'LIKE'},
                        {field: 'search_static', title: __('Search_static'), searchList: {"0":__('否'),"1":__('是')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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