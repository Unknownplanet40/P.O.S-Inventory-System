$.extend(true, DataTable.defaults, {
  paging: false,
  scrollCollapse: true,
  scrollY: "40vh",
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search...",
    infoEmpty: "No Products Found",
    zeroRecords: "No Items Found",
  },
  columnDefs: [{ orderable: false, targets: -1 }],
  order: [[2, "desc"]],
  responsive: true,
});

function tableReady() {
  $("#spinner").addClass("d-none");
  $("#productTable").removeClass("d-none");
}

$(document).ready(function () {
  tableReady();
  $("#productTable").DataTable();
});
