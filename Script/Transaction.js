$.extend(true, DataTable.defaults, {
  paging: false,
  scrollCollapse: true,
  scrollY: "55vh",
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search...",
    infoEmpty: "No Transactions Found",
    zeroRecords: "No Items Found",
  },
  responsive: true,
  // hide the first column
  columnDefs: [
    {
      targets: 0,
      visible: false,
      searchable: false,
    },
  ],
  order: [[5, "asc"]],
});

function tableReady() {
  $("#spinner").addClass("d-none");
  $("#TransactionTBL").removeClass("d-none");
}

$(document).ready(function () {
  tableReady();
  $("#TransactionTBL").DataTable();
});
