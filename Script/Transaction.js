$.extend(true, DataTable.defaults, {
  paging: false,
  scrollCollapse: true,
  scrollY: "50vh",
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
    {
      targets: 7,
      visible: false,
      searchable: true,
    },
  ],
  //hide the last column
  order: [[0, "desc"]],
});

function Ready() {
  $("#spinner").addClass("d-none");
  $("#tbback").removeClass("d-none");
}

$(document).ready(function () {
  Ready();
  $("#TransactionTBL").DataTable();
});
