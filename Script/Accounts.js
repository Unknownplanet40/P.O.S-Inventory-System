$.extend(true, DataTable.defaults, {
  paging: false,
  scrollCollapse: true,
  scrollY: "60vh",
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search...",
    infoEmpty: "No Products Found",
    zeroRecords: "No Items Found",
  },
  responsive: true,
  columnDefs: [
    {
      target: 0,
      visible: false,
      searchable: false,
    },
    {
      target: 3,
      visible: true,
      searchable: false,
    },
    {
      target: 5,
      visible: false,
      searchable: false,
    },
  ],
});

function tableReady() {
  $("#spinner").addClass("d-none");
  $("#AcccName").removeClass("d-none");
}

$(document).ready(function () {
  tableReady();
  $("#AcccName").DataTable();
});
