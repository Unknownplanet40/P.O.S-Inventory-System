$.extend(true, DataTable.defaults, {
  scrollCollapse: true,
    autoWidth: false,
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search...",
    infoEmpty: "No Products Found",
    zeroRecords: "No Items Found",
  },
  responsive: true,
  columnDefs: [
    {
      width: "30%",
      targets: 3,
    },
    {
      target: 0,
      visible: false,
      searchable: false,
    },
  ],
});

$(document).ready(function () {
  $("#example").DataTable();
});
