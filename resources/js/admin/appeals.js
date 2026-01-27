var dt_table_basic = $('#appealsTable');

var instanceDtTable = dt_table_basic.DataTable({
    scrollX: true,
    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'reported name'},
        { data: 'reported content'},
        { data: 'total weight'},
        { data: 'total reports'},
        { data: 'action'},
    ],
    columnDefs: [
        {
            targets: 0, 
            searchable: false, 
            className: 'dt-center'
        },
        {
            target: '_all',
            // type: 'string',
            // className: 'dt-body-center'
        }
    ],
    language: {
        searchPlaceholder: "Search Here..."
    }
});

//setting number
instanceDtTable.on('order.dt search.dt draw.dt', function () {
  instanceDtTable
    .column(0, { search: 'applied', order: 'applied' })
    .nodes()
    .each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
});