var dt_table_basic = $("#appealsTable");

var instanceDtTable = dt_table_basic.DataTable({
    scrollX: true,
    columns: [
        {
            data: null,
            defaultContent: '',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            },
        },
        { data: "username" },
        { data: "email" },
        { data: "gender" },
        { data: "role" },
        { data: "action" },
    ],
    columnDefs: [
        {
            targets: 0, 
            searchable: false, 
            className: 'dt-center'
        },
        {
            target: "_all",
        },
    ],
    language: {
        searchPlaceholder: "Search Here...",
    },
    order: [[0, "asc"]],
});

//setting number
instanceDtTable.on("order.dt search.dt draw.dt", function () {
    instanceDtTable
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
});