$.extend(true, DataTable.defaults, {
  paging: false,
  scrollCollapse: true,
  scrollY: "64vh",
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search...",
    infoEmpty: "No Products Found",
    zeroRecords: "No Items Found",
  },
  columnDefs: [
    {
      width: "15%",
      targets: 2,
    },
    {
      width: "30%",
      targets: 3,
    },
    {
      className: "text-center",
      width: "15%",
      targets: 4,
    },
    {
      target: 0,
      visible: false,
      searchable: false,
    },
  ],
  dom: "Bfrtip",
  buttons: [
    {
      extend: "excel",
      className: "btn btn-outline-primary btn-sm",
      exportOptions: {
        columns: [1, 2, 3],
      },
      init: function (api, node, config) {
        $(node).hide();
      },
    },
    {
      extend: "pdf",
      className: "btn btn-outline-primary btn-sm",
      exportOptions: {
        columns: [1, 2, 3],
      },
      init: function (api, node, config) {
        $(node).hide();
      },
    },
    {
      extend: "print",
      className: "btn btn-outline-primary btn-sm",
      exportOptions: {
        columns: [1, 2, 3],
      },
      init: function (api, node, config) {
        $(node).hide();
      },
    },
  ],
});

$("#btn-excel").on("click", function () {
  $("#example").DataTable().button(".buttons-excel").trigger();
});

$("#btn-pdf").on("click", function () {
  $("#example").DataTable().button(".buttons-pdf").trigger();
});

$("#btn-print").on("click", function () {
  $("#example").DataTable().button(".buttons-print").trigger();
});

function tableReady() {
  $("#spinner").addClass("d-none");
  $("#main").removeClass("d-none");
}

$(document).ready(function () {
  tableReady();
  $("#example").DataTable();
});
