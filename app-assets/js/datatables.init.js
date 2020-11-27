$(document).ready(function() {
    $("#datatable").DataTable(), $("#datatable-buttons").removeAttr('width').DataTable({
        lengthChange: !1,
//        buttons: ["copy", "excel", "pdf", "colvis"],
        "scrollX":true,
        "scrollCollapse": true,
        "paging": true,
        'columnDefs': [
            { width: 100, targets: 0 }
        ],
        'fixedColumns': true
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
});