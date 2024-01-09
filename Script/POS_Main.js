document.addEventListener("DOMContentLoaded", function () {
  const Itempath = "../../dump/MOCK_DATA.json";
  const CustomersData = "../../dump/Customers.json";

  var SelectedReceipt = [];
  var SelectedItemID = [];
  var SelectedItemName = [];
  var SelectedItemPrice = [];
  var SelectedItemQuantity = [];
  var SelectedItems = [
    SelectedReceipt,
    SelectedItemID,
    SelectedItemName,
    SelectedItemPrice,
    SelectedItemQuantity,
  ];

  fetch(Itempath)
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          "Failed to retrieve data from the server. Please try again later."
        );
      } else if (response.headers.get("content-length") == 0) {
        throw new Error("No Items Found");
      }

      return response.json();
    })
    .then((jsonData) => {
      document.getElementById("loading").setAttribute("hidden", "true");
      jsonData.forEach(function (item) {
        // Prevent data from being null or undefined
        if (!item["id"]) {
          item["id"] = Math.floor(Math.random() * 1000000);
        }

        if (!item["category"]) {
          item["category"] = "Others";
        }

        if (!item["price"]) {
          item["price"] = 0;
        }

        if (!item["quantity"]) {
          item["quantity"] = 0;
        }

        if (!item["ml"]) {
          item["ml"] = 0;
        }

        if (!item["product_name"]) {
          item["product_name"] = "No Name";
        }

        var itemname = item["product_name"].replace(" ", "-");

        // create col div
        var col = document.createElement("div");
        col.classList.add("col", "col-item");
        col.id = "cardbox_" + itemname;
        document.getElementById("itemlist").appendChild(col);

        // create card div
        var card = document.createElement("div");
        card.classList.add(
          "card",
          "card-item",
          "h-100",
          "shadow",
          "border",
          "border-warning"
        );
        card.id = "itemcard";
        col.appendChild(card);

        // create image
        var image = document.createElement("img");
        image.classList.add("card-img-top", "p-2");
        image.src = "../../assets/TestDeter.jpg";
        image.alt = "...";
        image.style.height = "128px";
        image.style.objectFit = "contain";
        card.appendChild(image);

        // create card body
        var cardbody = document.createElement("div");
        cardbody.classList.add("card-body");
        card.appendChild(cardbody);

        // create card title
        var cardtitle = document.createElement("h5");
        cardtitle.classList.add("card-title");
        cardtitle.id = "itemname";
        cardtitle.innerText = item["product_name"];
        cardbody.appendChild(cardtitle);

        // create category
        var category = document.createElement("p");
        category.classList.add("Category", "card-text", "text-muted");
        category.id = "Category";
        category.hidden = true;
        category.innerText = item["category"];
        cardbody.appendChild(category);

        // create price
        var price = document.createElement("small");
        price.classList.add("card-text", "text-muted");
        // if item null or undefined, dont display ml
        if (!item["ml"]) {
          price.innerHTML = "&#8369; " + item["price"];
        } else {
          price.innerHTML = "&#8369; " + item["price"] + " / " + item["ml"] + "ml";
        }
        cardbody.appendChild(price);

        // create text center
        var textcenter = document.createElement("div");
        textcenter.classList.add("text-center", "mx-4");
        cardbody.appendChild(textcenter);

        // create input group
        var inputgroup = document.createElement("div");
        inputgroup.classList.add("input-group", "mb-1");
        inputgroup.id = "inputgroup_" + item["id"];
        textcenter.appendChild(inputgroup);

        // create minus button
        var minusbutton = document.createElement("button");
        minusbutton.classList.add("btn", "btn-sm", "btn-outline-warning");
        minusbutton.type = "button";
        minusbutton.id = "bminus_" + item["id"];
        minusbutton.innerHTML = "&minus;";
        inputgroup.appendChild(minusbutton);

        // create count
        var count = document.createElement("input");
        count.type = "text";
        count.id = "count_" + item["id"];
        count.classList.add("form-control", "form-control-sm");
        count.placeholder = "0";
        count.style.textAlign = "center";
        count.disabled = true;
        inputgroup.appendChild(count);

        // create plus button
        var plusbutton = document.createElement("button");
        plusbutton.classList.add("btn", "btn-sm", "btn-outline-warning");
        plusbutton.type = "button";
        plusbutton.id = "bplus_" + item["id"];
        plusbutton.innerHTML = "&plus;";
        inputgroup.appendChild(plusbutton);

        // create item button
        var itembutton = document.createElement("button");
        itembutton.classList.add("btn", "btn-sm", "btn-outline-warning");
        itembutton.type = "button";
        itembutton.id = "Item_" + item["id"];
        itembutton.title = "Add to List";
        itembutton.setAttribute("data-bs-toggle", "tooltip");
        itembutton.setAttribute("data-bs-placement", "right");
        inputgroup.appendChild(itembutton);

        // create svg
        var svg = document.createElement("svg");
        svg.innerHTML =
          '<svg class="bi pe-none" width="18" height="18" role="img" aria-label="Add to List"> <use xlink:href="#cart" /> </svg>';
        itembutton.appendChild(svg);

        // create card footer
        var cardfooter = document.createElement("div");
        cardfooter.classList.add("card-footer");
        card.appendChild(cardfooter);

        // create stock
        var stock = document.createElement("small");
        // change the color of the stock based on the level of stock
        var tempercentage = (item["CurrentStock"] / item["quantity"]) * 100;
        if (tempercentage >= 50) {
          stock.classList.add("text-dark");
        } else if (tempercentage >= 20 && tempercentage <= 49) {
          stock.classList.add("text-warning");
        } else if (tempercentage >= 0 && tempercentage <= 19) {
          stock.classList.add("text-danger");
        }
        stock.id = "stock_" + item["id"];
        stock.innerText =
          "Stocks: " + item["CurrentStock"] + " out of " + item["quantity"];
        cardfooter.appendChild(stock);

        var itemStock = item["quantity"];
        var current_stock = item["CurrentStock"];
        var lowStock = [];
        var count = 0;
        var displayed = 0;

        async function displayToasts() {
          // Populate lowStock array
          //all that have isLowStock equals to true then add it to the array
          jsonData.forEach(function (item) {
            if (item["isLowStock"] == true) {
              lowStock.push(item["product_name"]);
            }
          });

          // Display toasts sequentially
          for (const item of lowStock) {
            await displayToast(item);
          }
        }
        async function displayToast(item) {
          return new Promise((resolve) => {
            Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
              },
            }).fire({
              icon: "warning",
              title: "Low Stock",
              text: item + " is low on stock",
              didClose: () => {
                displayed++;
                if (displayed == lowStock.length) {
                  //clear the array
                  lowStock = [];
                }
                console.log(lowStock);
                resolve(); // Resolve the promise when the toast is closed
              },
            });
          });
        }

        displayToasts();

        function updateStockDisplay() {
          document.getElementById("count_" + item["id"]).value = count;
          document.getElementById("stock_" + item["id"]).innerText =
            "Stocks: " + current_stock + " out of " + itemStock;

          // if the current stock is 0, disable the plus button
          if (current_stock == 0) {
            document.getElementById("bplus_" + item["id"]).disabled = true;
          } else {
            document.getElementById("bplus_" + item["id"]).disabled = false;
          }

          // level of stock
          // 100% - 50% = muted
          // 49% - 20% = yellow
          // 19% - 0% = red
          var percentage = (current_stock / itemStock) * 100;
          if (percentage >= 50) {
            document
              .getElementById("stock_" + item["id"])
              .classList.remove("text-warning");
            document
              .getElementById("stock_" + item["id"])
              .classList.remove("text-danger");
            document
              .getElementById("stock_" + item["id"])
              .classList.add("text-dark");
          } else if (percentage >= 20 && percentage <= 49) {
            document
              .getElementById("stock_" + item["id"])
              .classList.remove("text-dark");
            document
              .getElementById("stock_" + item["id"])
              .classList.remove("text-danger");
            document
              .getElementById("stock_" + item["id"])
              .classList.add("text-warning");
          } else if (percentage >= 0 && percentage <= 19) {
            document
              .getElementById("stock_" + item["id"])
              .classList.remove("text-dark");
            document
              .getElementById("stock_" + item["id"])
              .classList.remove("text-warning");
            document
              .getElementById("stock_" + item["id"])
              .classList.add("text-danger");
          }
        }

        // add event listener to minus button
        document
          .getElementById("bminus_" + item["id"])
          .addEventListener("click", function () {
            if (count > 0) {
              count--;
              current_stock++;
              updateStockDisplay();
            }
          });

        // add event listener to plus button
        document
          .getElementById("bplus_" + item["id"])
          .addEventListener("click", function () {
            // if the current stock is 0, disable the plus button
            if (current_stock != 0) {
              count++;
              current_stock--;
              updateStockDisplay();
            }
          });

        // when page loads, focus on the search box
        document.getElementById("itemSearchbox").focus();

        if (document.getElementById("CustomerName").value == "") {
          document.getElementById("Item_" + item["id"]).disabled = true;

          // Services
          document.getElementById("BothServ").disabled = true;
          document.getElementById("WashOnly").disabled = true;
          document.getElementById("DryOnly").disabled = true;
          document.getElementById("FoldServ").disabled = true;
          document.getElementById("PickupServ").disabled = true;
          document.getElementById("DeliveryServ").disabled = true;
        } else {
          document.getElementById("Item_" + item["id"]).disabled = false;

          // Services
          document.getElementById("BothServ").disabled = false;
          document.getElementById("WashOnly").disabled = false;
          document.getElementById("DryOnly").disabled = false;
          document.getElementById("FoldServ").disabled = false;
          document.getElementById("PickupServ").disabled = false;
          document.getElementById("DeliveryServ").disabled = false;
        }

        // add event listener to item button that when clicked add the item to the receipt
        document
          .getElementById("Item_" + item["id"])
          .addEventListener("click", function () {
            if (document.getElementById("count_" + item["id"]).value == 0) {
              //make the input box red and back to normal
              document
                .getElementById("count_" + item["id"])
                .classList.add("is-invalid");
              setTimeout(function () {
                document
                  .getElementById("count_" + item["id"])
                  .classList.remove("is-invalid");
              }, 1000);
            } else {
              var Receipt = document.getElementById("receipt");
              document.getElementById("noItems").setAttribute("hidden", "true");
              var random = Math.floor(Math.random() * 1000000);

              //add to receipt
              var li = document.createElement("li");
              var receiptID = "receipt_" + item["id"] + "_" + random;
              li.classList.add(
                "list-group-item",
                "d-flex",
                "justify-content-between",
                "align-items-start",
                "bg-transparent"
              );
              li.setAttribute("title", "Click to remove item");
              li.id = receiptID;
              li.style.cursor = "pointer";
              Receipt.appendChild(li);

              // add item name
              var div = document.createElement("div");
              div.classList.add("ms-2", "me-auto", "text-truncate");
              div.id = "itemname_" + item["id"];
              div.style.textTransform = "capitalize";
              div.style.maxWidth = "215px";
              div.innerHTML =
                document.getElementById("count_" + item["id"]).value +
                " &times " +
                item["product_name"];
              li.appendChild(div);

              // add item price
              var span = document.createElement("span");
              span.id = "itemprice";
              var quan = document.getElementById("count_" + item["id"]).value;
              span.innerHTML =
                '<span class="text-muted">&#8369; <span id="priceItem">' +
                (item["price"] * quan).toFixed(2) +
                '<small hidden id="quanti">' +
                quan +
                '</small></span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
              li.appendChild(span);

              // get all itemprice and add it to the total
              var itemprice = document.querySelectorAll("#priceItem");
              var total = 0;
              itemprice.forEach(function (price) {
                total += parseFloat(price.innerText);
              });

              document.getElementById("ammount").innerHTML =
                '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
                total.toFixed(2) +
                "</span>";
              SelectedReceipt.push(receiptID);
              SelectedItemID.push("item_" + item["id"]); // add random number to the id to make it unique
              SelectedItemName.push(item["product_name"]);
              SelectedItemPrice.push(item["price"]);
              SelectedItemQuantity.push(
                document.getElementById("count_" + item["id"]).value
              );

              console.log(SelectedItems); // remove this later

              //reset the count
              document.getElementById("count_" + item["id"]).value = 0;
              count = 0;

              // add event listener to receipt item that when clicked remove the item from the receipt
              document
                .getElementById(receiptID)
                .addEventListener("click", function () {
                  var index = SelectedReceipt.indexOf(receiptID);
                  var dump =
                    SelectedItemPrice[index] * SelectedItemQuantity[index];
                  console.log(SelectedItemName[index] + " " + dump); // for debugging purposes

                  // add removed count to the current stock to the item
                  current_stock += parseInt(SelectedItemQuantity[index]);
                  updateStockDisplay();

                  var itemprice = document.querySelectorAll("#priceItem");
                  var total = 0;
                  itemprice.forEach(function (price) {
                    total += parseFloat(price.innerText);
                  });

                  var overall = document.getElementById("overall");
                  overall.innerHTML =
                    "&#8369;&nbsp;" + (total - dump).toFixed(2);

                  if (index > -1) {
                    SelectedReceipt.splice(index, 1);
                    SelectedItemID.splice(index, 1);
                    SelectedItemName.splice(index, 1);
                    SelectedItemPrice.splice(index, 1);
                    SelectedItemQuantity.splice(index, 1);
                  }
                  document.getElementById(receiptID).remove();

                  if (SelectedReceipt.length == 0) {
                    document
                      .getElementById("noItems")
                      .removeAttribute("hidden");
                  }

                  console.log(SelectedItems);
                });
            }
          });
      });
    })
    .catch((error) => {
      var JsonError = document.getElementById("jsonError");
      JsonError.removeAttribute("hidden");
      //if the error message contains the word "Error:" then remove it
      if (error.toString().includes("Error:")) {
        error = error.toString().replace("Error: ", "");
      }
      if (error.toString().includes("No Items Found")) {
        JsonError.classList.remove("text-danger");
        JsonError.classList.add("text-warning");

        //disable the search box, reset button and sort by button
        document.getElementById("itemSearchbox").disabled = true;
        document.getElementById("reset").disabled = true;
        document.getElementById("sortbybutton").disabled = true;
      }

      JsonError.innerHTML = error;

      //use this later in checkout
      /* document.getElementById('toastTitle').innerHTML = 'Error';
                document.getElementById('toastBody').innerHTML = error;
                document.getElementById('toastTime').innerHTML = new Date().toLocaleTimeString();
    
                // activate the toast
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
                toastList.forEach(toast => toast.show()); */
    });

  fetch(CustomersData)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Auto-complete failed to load");
      }

      if (response.headers.get("content-length") == 0) {
        throw new Error("Records is empty!");
      }
      return response.json();
    })
    .then((jsonData) => {
      var customerName = document.getElementById("customerNamelists");
      var customerNameList = [];
      jsonData.forEach(function (customer) {
        if (!customerNameList.includes(customer.name)) {
          var option = document.createElement("option");
          var name = customer.first_name + " " + customer.last_name;
          option.value = name;
          customerName.appendChild(option);
        }
      });

      document
        .getElementById("CustomerName")
        .addEventListener("input", function () {
          var customName = this.value.toLowerCase();
          var customerNumber = document.getElementById("CustomerNumber");
          var customerAddress = document.getElementById("CustomerAddress");
          var ExistingCustomer = document.getElementById("ExistingCustomer");

          jsonData.forEach(function (customer) {
            var name = customer.first_name + " " + customer.last_name;
            if (name.toLowerCase() == customName) {
              customerNumber.value = customer.phone_number;
              customerAddress.value = customer.address;
              ExistingCustomer.checked = true;
            }
          });
        });
    })
    .catch((error) => {
      var JsonError = document.getElementById("JsonErrorMessage");
      var ErrorContainer = document.getElementById("JsonErrorMessageDiv");
      error = error.toString().replace("Error: ", "");

      if (error.toString().includes("Auto-complete")) {
        ErrorContainer.removeAttribute("hidden");
        JsonError.classList.remove("col-form-label");
        JsonError.classList.add("text-danger");
      } else if (error.toString().includes("Record")) {
        setTimeout(function () {
          ErrorContainer.removeAttribute("hidden");
          JsonError.classList.remove("col-form-label");
          JsonError.classList.add("text-muted");
        }, 1000);
      }
      JsonError.innerHTML = error;
    });

  document.getElementById("newcustomer").addEventListener("click", function () {
    var customerName = document.getElementById("CustomerName").value;
    var customerNumber = document.getElementById("CustomerNumber").value;
    var customerAddress = document.getElementById("CustomerAddress").value;
    var ExistingCustomer = document.getElementById("ExistingCustomer");

    if (customerName != "" && customerNumber != "" && customerAddress != "") {
      localStorage.setItem("name", customerName);
      localStorage.setItem("number", customerNumber);
      localStorage.setItem("address", customerAddress);
      localStorage.setItem("ExistingCustomer", ExistingCustomer.checked);
      location.reload();
    } else {
      document.getElementById("CustomerName").classList.add("is-invalid");
      document.getElementById("CustomerNumber").classList.add("is-invalid");
      document.getElementById("CustomerAddress").classList.add("is-invalid");
      setTimeout(function () {
        document.getElementById("CustomerName").classList.remove("is-invalid");
        document
          .getElementById("CustomerNumber")
          .classList.remove("is-invalid");
        document
          .getElementById("CustomerAddress")
          .classList.remove("is-invalid");
      }, 1500);
    }
  });

  // if the page is reloaded, get the data from the local storage and put it back to the input boxes
  if (localStorage.getItem("name") != null) {
    document.getElementById("CustomerName").value =
      localStorage.getItem("name");
    document.getElementById("CustomerNumber").value =
      localStorage.getItem("number");
    document.getElementById("CustomerAddress").value =
      localStorage.getItem("address");
    document.getElementById("ExistingCustomer").checked =
      localStorage.getItem("ExistingCustomer");

    document.getElementById("Cname").innerHTML = "Customer Details";
    document.getElementById("Cname2").innerHTML = localStorage.getItem("name");
    document.getElementById("Cnumber").innerHTML =
      localStorage.getItem("number");
    document.getElementById("Caddress").innerHTML =
      localStorage.getItem("address");
    localStorage.clear();
  }

  /* 
            document.getElementById('reset-list').addEventListener('click', function () {
        
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will clear the list and cannot be undone!",
                    icon: 'warning',
                    allowOutsideClick: false,
        
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
        
                    }
                });
            }); */

  //if reset button is clicked clear the search box
  document.getElementById("reset").addEventListener("click", function () {
    document.getElementById("itemSearchbox").value = "";
    document.getElementById("itemSearchbox").dispatchEvent(new Event("input"));

    document.getElementById("Hidden-itemSearchbox").value = "";
    document
      .getElementById("Hidden-itemSearchbox")
      .dispatchEvent(new Event("input"));

    document.getElementById("sortbybutton").innerText = "Filter ";
    doc;
  });

  // Search box
  document
    .getElementById("itemSearchbox")
    .addEventListener("input", function () {
      var searchTerm = this.value.toLowerCase();

      // clear the hidden search box
      document.getElementById("Hidden-itemSearchbox").value = "";
      document.getElementById("sortbybutton").innerText = "Filter ";

      // Get all cards
      var cards = document.querySelectorAll(".card-item");
      var noResults = document.getElementById("noResults");

      // Iterate through each card and toggle its visibility based on the search term
      cards.forEach(function (card) {
        var titleElement = card.querySelector("#itemname");
        if (titleElement) {
          var title = titleElement.innerText.toLowerCase();
          var isMatch = title.includes(searchTerm);

          // Toggle hidden attribute based on the search term
          if (isMatch) {
            card.closest(".col").removeAttribute("hidden");
          } else {
            card.closest(".col").setAttribute("hidden", "true");
          }
        }
      });

      // if all cards are hidden, show no results message
      if (
        document.querySelectorAll(".col-item[hidden]").length == cards.length
      ) {
        noResults.removeAttribute("hidden");
      } else {
        noResults.setAttribute("hidden", "true");
      }
    });

  // Sort by button
  document
    .getElementById("sortbybutton")
    .addEventListener("click", function () {
      var categoryList = [];
      var sortby = document.getElementById("sortby");
      var sortbybutton = document.getElementById("sortbybutton");

      // Clear existing dropdown items
      sortby.innerHTML = "";

      // Get all category from cards and add it to the list
      var cards = document.querySelectorAll(".card-item");
      cards.forEach(function (card) {
        var categoryElement = card.querySelector("#Category");
        if (categoryElement) {
          var category = categoryElement.innerText.toLowerCase();
          if (!categoryList.includes(category)) {
            categoryList.push(category);
          }
        }
      });

      // add all category to the dropdown
      categoryList.forEach(function (category) {
        var li = document.createElement("li");
        li.classList.add("dropdown-item");
        li.style.cursor = "pointer";
        li.innerText = category;
        sortby.appendChild(li);
      });

      // add event listener to each dropdown item
      var dropdownItems = document.querySelectorAll(".dropdown-item");
      dropdownItems.forEach(function (item) {
        item.addEventListener("click", function () {
          sortbybutton.innerText = item.innerText;
          document.getElementById("Hidden-itemSearchbox").value =
            item.innerText;
          document
            .getElementById("Hidden-itemSearchbox")
            .dispatchEvent(new Event("input"));
        });
      });
    });

  // Hidden Search box
  document
    .getElementById("Hidden-itemSearchbox")
    .addEventListener("input", function () {
      var HiddenSearchTerm = this.value.toLowerCase();

      // clear the search box
      document.getElementById("itemSearchbox").value = "";
      var noResults = document.getElementById("noResults");

      // Get all cards
      var cards = document.querySelectorAll(".card-item");

      // Iterate through each card and toggle its visibility based on the search term
      cards.forEach(function (card) {
        var categoryElement = card.querySelector("#Category");
        if (categoryElement) {
          var category = categoryElement.innerText.toLowerCase();
          var isMatch = category.includes(HiddenSearchTerm);

          // Toggle hidden attribute based on the search term
          if (isMatch) {
            card.closest(".col").removeAttribute("hidden");
          } else {
            card.closest(".col").setAttribute("hidden", "true");
          }
        }
      });
      // if all cards are hidden, show no results message
      if (
        document.querySelectorAll(".col-item[hidden]").length == cards.length
      ) {
        noResults.removeAttribute("hidden");
      } else {
        noResults.setAttribute("hidden", "true");
      }
    });

  // Checkout button
  document.getElementById("checkout").addEventListener("click", function () {
    var ExistingCustomer = document.getElementById("ExistingCustomer");

    //check if their is Items in the receipt
    var receipt = document.getElementById("receipt");
    if (receipt.childElementCount == 1) {
      swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Please add an item to the list",
      });
    } else {
      if (ExistingCustomer.checked == true) {
        Swal.fire({
          title: "Item(s) will be added to the customer's account",
          text: "This is Existing Customer",
          icon: "info",
          allowOutsideClick: false,
        });
      } else {
        Swal.fire({
          title: "Item(s) will be added to the customer's account",
          text: "This is New Customer",
          icon: "info",
          allowOutsideClick: false,
        });
      }
    }
  });

  // Wash and Dry
  document.getElementById("BothServ").addEventListener("click", function () {
    if (this.checked) {
      document.getElementById("WashOnly").disabled = true;
      document.getElementById("DryOnly").disabled = true;
      document.getElementById("BothServ").disabled = true;

      var Receipt = document.getElementById("receipt");
      document.getElementById("noItems").setAttribute("hidden", "true");
      var random = Math.floor(Math.random() * 1000000);

      //add to receipt
      var li = document.createElement("li");
      var receiptID = "receipt_" + random;
      li.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-between",
        "align-items-start",
        "bg-transparent"
      );
      li.setAttribute("title", "Click to remove item");
      li.id = receiptID;
      li.style.cursor = "pointer";
      Receipt.appendChild(li);

      // add item name
      var div = document.createElement("div");
      div.classList.add("ms-2", "me-auto", "text-truncate");
      div.id = "itemname_" + random;
      div.style.textTransform = "capitalize";
      div.style.maxWidth = "215px";
      div.innerHTML = "1 &times; Wash and Dry";
      li.appendChild(div);

      // add item price
      var span = document.createElement("span");
      span.id = "itemprice";
      span.innerHTML =
        '<span class="text-muted">&#8369; <span id="priceItem">120.00</span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
      li.appendChild(span);

      // get all itemprice and add it to the total
      var itemprice = document.querySelectorAll("#priceItem");
      var total = 0;
      itemprice.forEach(function (price) {
        total += parseFloat(price.innerText);
      });

      document.getElementById("ammount").innerHTML =
        '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
        total.toFixed(2) +
        "</span>";
      SelectedReceipt.push(receiptID);
      SelectedItemID.push("item_" + random); // add random number to the id to make it unique
      SelectedItemName.push("Wash and Dry");
      SelectedItemPrice.push(120);
      SelectedItemQuantity.push(1);

      console.log(SelectedItems); // remove this later

      // add event listener to receipt item that when clicked remove the item from the receipt
      document.getElementById(receiptID).addEventListener("click", function () {
        var index = SelectedReceipt.indexOf(receiptID);

        // add removed count to the current stock to the item

        var itemprice = document.querySelectorAll("#priceItem");
        var total = 0;
        itemprice.forEach(function (price) {
          total += parseFloat(price.innerText);
        });

        var overall = document.getElementById("overall");
        overall.innerHTML = "&#8369;&nbsp;" + (total - 120).toFixed(2);

        if (index > -1) {
          SelectedReceipt.splice(index, 1);
          SelectedItemID.splice(index, 1);
          SelectedItemName.splice(index, 1);
          SelectedItemPrice.splice(index, 1);
          SelectedItemQuantity.splice(index, 1);
        }

        document.getElementById(receiptID).remove();

        if (SelectedReceipt.length == 0) {
          document.getElementById("noItems").removeAttribute("hidden");
        }

        console.log(SelectedItems);

        document.getElementById("WashOnly").disabled = false;
        document.getElementById("DryOnly").disabled = false;

        document.getElementById("BothServ").checked = false;
        document.getElementById("BothServ").disabled = false;
      });
    } else {
      document.getElementById("WashOnly").disabled = false;
      document.getElementById("DryOnly").disabled = false;
    }
  });

  // Wash Only
  document.getElementById("WashOnly").addEventListener("click", function () {
    if (this.checked) {
      document.getElementById("BothServ").disabled = true;
      document.getElementById("WashOnly").disabled = true;
      document.getElementById("DryOnly").disabled = true;

      var Receipt = document.getElementById("receipt");
      document.getElementById("noItems").setAttribute("hidden", "true");
      var random = Math.floor(Math.random() * 1000000);

      //add to receipt
      var li = document.createElement("li");
      var receiptID = "receipt_" + random;
      li.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-between",
        "align-items-start",
        "bg-transparent"
      );
      li.setAttribute("title", "Click to remove item");
      li.id = receiptID;
      li.style.cursor = "pointer";
      Receipt.appendChild(li);

      // add item name
      var div = document.createElement("div");
      div.classList.add("ms-2", "me-auto", "text-truncate");
      div.id = "itemname_" + random;
      div.style.textTransform = "capitalize";
      div.style.maxWidth = "215px";
      div.innerHTML = "1 &times; Wash Only";
      li.appendChild(div);

      // add item price
      var span = document.createElement("span");
      span.id = "itemprice";
      span.innerHTML =
        '<span class="text-muted">&#8369; <span id="priceItem">60.00</span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
      li.appendChild(span);

      // get all itemprice and add it to the total
      var itemprice = document.querySelectorAll("#priceItem");
      var total = 0;
      itemprice.forEach(function (price) {
        total += parseFloat(price.innerText);
      });

      document.getElementById("ammount").innerHTML =
        '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
        total.toFixed(2) +
        "</span>";
      SelectedReceipt.push(receiptID);
      SelectedItemID.push("item_" + random); // add random number to the id to make it unique
      SelectedItemName.push("Wash Only");
      SelectedItemPrice.push(60);
      SelectedItemQuantity.push(1);

      console.log(SelectedItems); // remove this later

      // add event listener to receipt item that when clicked remove the item from the receipt
      document.getElementById(receiptID).addEventListener("click", function () {
        var index = SelectedReceipt.indexOf(receiptID);

        // add removed count to the current stock to the item

        var itemprice = document.querySelectorAll("#priceItem");
        var total = 0;
        itemprice.forEach(function (price) {
          total += parseFloat(price.innerText);
        });

        var overall = document.getElementById("overall");
        overall.innerHTML = "&#8369;&nbsp;" + (total - 60).toFixed(2);

        if (index > -1) {
          SelectedReceipt.splice(index, 1);
          SelectedItemID.splice(index, 1);
          SelectedItemName.splice(index, 1);
          SelectedItemPrice.splice(index, 1);
          SelectedItemQuantity.splice(index, 1);
        }

        document.getElementById(receiptID).remove();

        if (SelectedReceipt.length == 0) {
          document.getElementById("noItems").removeAttribute("hidden");
        }

        console.log(SelectedItems);

        document.getElementById("BothServ").disabled = false;
        document.getElementById("DryOnly").disabled = false;

        document.getElementById("WashOnly").checked = false;
        document.getElementById("WashOnly").disabled = false;
      });
    } else {
      document.getElementById("BothServ").disabled = false;
      document.getElementById("DryOnly").disabled = false;
    }
  });

  // Dry Only
  document.getElementById("DryOnly").addEventListener("click", function () {
    if (this.checked) {
      document.getElementById("BothServ").disabled = true;
      document.getElementById("WashOnly").disabled = true;
      document.getElementById("DryOnly").disabled = true;

      var Receipt = document.getElementById("receipt");
      document.getElementById("noItems").setAttribute("hidden", "true");
      var random = Math.floor(Math.random() * 1000000);

      //add to receipt
      var li = document.createElement("li");
      var receiptID = "receipt_" + random;
      li.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-between",
        "align-items-start",
        "bg-transparent"
      );
      li.setAttribute("title", "Click to remove item");
      li.id = receiptID;
      li.style.cursor = "pointer";
      Receipt.appendChild(li);

      // add item name
      var div = document.createElement("div");
      div.classList.add("ms-2", "me-auto", "text-truncate");
      div.id = "itemname_" + random;
      div.style.textTransform = "capitalize";
      div.style.maxWidth = "215px";
      div.innerHTML = "1 &times; Dry Only";
      li.appendChild(div);

      // add item price
      var span = document.createElement("span");
      span.id = "itemprice";
      span.innerHTML =
        '<span class="text-muted">&#8369; <span id="priceItem">60.00</span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
      li.appendChild(span);

      // get all itemprice and add it to the total
      var itemprice = document.querySelectorAll("#priceItem");
      var total = 0;
      itemprice.forEach(function (price) {
        total += parseFloat(price.innerText);
      });

      document.getElementById("ammount").innerHTML =
        '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
        total.toFixed(2) +
        "</span>";
      SelectedReceipt.push(receiptID);
      SelectedItemID.push("item_" + random); // add random number to the id to make it unique
      SelectedItemName.push("Dry Only");
      SelectedItemPrice.push(60);
      SelectedItemQuantity.push(1);

      console.log(SelectedItems); // remove this later

      // add event listener to receipt item that when clicked remove the item from the receipt
      document.getElementById(receiptID).addEventListener("click", function () {
        var index = SelectedReceipt.indexOf(receiptID);

        // add removed count to the current stock to the item

        var itemprice = document.querySelectorAll("#priceItem");
        var total = 0;
        itemprice.forEach(function (price) {
          total += parseFloat(price.innerText);
        });

        var overall = document.getElementById("overall");
        overall.innerHTML = "&#8369;&nbsp;" + (total - 60).toFixed(2);

        if (index > -1) {
          SelectedReceipt.splice(index, 1);
          SelectedItemID.splice(index, 1);
          SelectedItemName.splice(index, 1);
          SelectedItemPrice.splice(index, 1);
          SelectedItemQuantity.splice(index, 1);
        }

        document.getElementById(receiptID).remove();

        if (SelectedReceipt.length == 0) {
          document.getElementById("noItems").removeAttribute("hidden");
        }

        console.log(SelectedItems);

        document.getElementById("BothServ").disabled = false;
        document.getElementById("WashOnly").disabled = false;

        document.getElementById("DryOnly").checked = false;
        document.getElementById("DryOnly").disabled = false;
      });
    } else {
      document.getElementById("BothServ").disabled = false;
      document.getElementById("WashOnly").disabled = false;
    }
  });

  // Fold Service
  document.getElementById("FoldServ").addEventListener("click", function () {
    if (this.checked) {
      document.getElementById("FoldServ").disabled = true;

      var Receipt = document.getElementById("receipt");
      document.getElementById("noItems").setAttribute("hidden", "true");
      var random = Math.floor(Math.random() * 1000000);

      //add to receipt
      var li = document.createElement("li");
      var receiptID = "receipt_" + random;
      li.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-between",
        "align-items-start",
        "bg-transparent"
      );
      li.setAttribute("title", "Click to remove item");
      li.id = receiptID;
      li.style.cursor = "pointer";
      Receipt.appendChild(li);

      // add item name
      var div = document.createElement("div");
      div.classList.add("ms-2", "me-auto", "text-truncate");
      div.id = "itemname_" + random;
      div.style.textTransform = "capitalize";
      div.style.maxWidth = "215px";
      div.innerHTML = "1 &times; Fold";
      li.appendChild(div);

      // add item price
      var span = document.createElement("span");
      span.id = "itemprice";
      span.innerHTML =
        '<span class="text-muted">&#8369; <span id="priceItem">20.00</span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
      li.appendChild(span);

      // get all itemprice and add it to the total
      var itemprice = document.querySelectorAll("#priceItem");
      var total = 0;
      itemprice.forEach(function (price) {
        total += parseFloat(price.innerText);
      });

      document.getElementById("ammount").innerHTML =
        '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
        total.toFixed(2) +
        "</span>";
      SelectedReceipt.push(receiptID);
      SelectedItemID.push("item_" + random); // add random number to the id to make it unique
      SelectedItemName.push("Fold");
      SelectedItemPrice.push(20);
      SelectedItemQuantity.push(1);

      console.log(SelectedItems); // remove this later

      // add event listener to receipt item that when clicked remove the item from the receipt
      document.getElementById(receiptID).addEventListener("click", function () {
        var index = SelectedReceipt.indexOf(receiptID);

        // add removed count to the current stock to the item

        var itemprice = document.querySelectorAll("#priceItem");
        var total = 0;
        itemprice.forEach(function (price) {
          total += parseFloat(price.innerText);
        });

        var overall = document.getElementById("overall");
        overall.innerHTML = "&#8369;&nbsp;" + (total - 20).toFixed(2);

        if (index > -1) {
          SelectedReceipt.splice(index, 1);
          SelectedItemID.splice(index, 1);
          SelectedItemName.splice(index, 1);
          SelectedItemPrice.splice(index, 1);
          SelectedItemQuantity.splice(index, 1);
        }

        document.getElementById(receiptID).remove();

        if (SelectedReceipt.length == 0) {
          document.getElementById("noItems").removeAttribute("hidden");
        }

        console.log(SelectedItems);

        document.getElementById("FoldServ").disabled = false;
        document.getElementById("FoldServ").checked = false;
      });
    } else {
      document.getElementById("FoldServ").disabled = false;
    }
  });

  // Pick Up
  document.getElementById("PickupServ").addEventListener("click", function () {
    if (this.checked) {
      document.getElementById("PickupServ").disabled = true;
      document.getElementById("DeliveryServ").disabled = true;

      var Receipt = document.getElementById("receipt");
      document.getElementById("noItems").setAttribute("hidden", "true");
      var random = Math.floor(Math.random() * 1000000);

      //add to receipt
      var li = document.createElement("li");
      var receiptID = "receipt_" + random;
      li.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-between",
        "align-items-start",
        "bg-transparent"
      );
      li.setAttribute("title", "Click to remove item");
      li.id = receiptID;
      li.style.cursor = "pointer";
      Receipt.appendChild(li);

      // add item name
      var div = document.createElement("div");
      div.classList.add("ms-2", "me-auto", "text-truncate");
      div.id = "itemname_" + random;
      div.style.textTransform = "capitalize";
      div.style.maxWidth = "215px";
      div.innerHTML = "1 &times; Pick Up";
      li.appendChild(div);

      // add item price
      var span = document.createElement("span");
      span.id = "itemprice";
      span.innerHTML =
        '<span class="text-muted">&#8369; <span id="priceItem">00.00</span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
      li.appendChild(span);

      // get all itemprice and add it to the total
      var itemprice = document.querySelectorAll("#priceItem");
      var total = 0;
      itemprice.forEach(function (price) {
        total += parseFloat(price.innerText);
      });

      document.getElementById("ammount").innerHTML =
        '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
        total.toFixed(2) +
        "</span>";
      SelectedReceipt.push(receiptID);
      SelectedItemID.push("item_" + random); // add random number to the id to make it unique
      SelectedItemName.push("Pick Up");
      SelectedItemPrice.push(0);
      SelectedItemQuantity.push(1);

      console.log(SelectedItems); // remove this later

      // add event listener to receipt item that when clicked remove the item from the receipt
      document.getElementById(receiptID).addEventListener("click", function () {
        var index = SelectedReceipt.indexOf(receiptID);

        // add removed count to the current stock to the item

        var itemprice = document.querySelectorAll("#priceItem");
        var total = 0;
        itemprice.forEach(function (price) {
          total += parseFloat(price.innerText);
        });

        var overall = document.getElementById("overall");
        overall.innerHTML = "&#8369;&nbsp;" + (total - 0).toFixed(2);

        if (index > -1) {
          SelectedReceipt.splice(index, 1);
          SelectedItemID.splice(index, 1);
          SelectedItemName.splice(index, 1);
          SelectedItemPrice.splice(index, 1);
          SelectedItemQuantity.splice(index, 1);
        }

        document.getElementById(receiptID).remove();

        if (SelectedReceipt.length == 0) {
          document.getElementById("noItems").removeAttribute("hidden");
        }

        console.log(SelectedItems);

        document.getElementById("PickupServ").disabled = false;
        document.getElementById("PickupServ").checked = false;

        document.getElementById("DeliveryServ").disabled = false;
      });
    } else {
      document.getElementById("PickupServ").disabled = false;
      document.getElementById("DeliveryServ").disabled = false;
    }
  });

  // Delivery
  document
    .getElementById("DeliveryServ")
    .addEventListener("click", function () {
      if (this.checked) {
        document.getElementById("DeliveryServ").disabled = true;
        document.getElementById("PickupServ").disabled = true;

        var Receipt = document.getElementById("receipt");
        document.getElementById("noItems").setAttribute("hidden", "true");
        var random = Math.floor(Math.random() * 1000000);

        //add to receipt
        var li = document.createElement("li");
        var receiptID = "receipt_" + random;
        li.classList.add(
          "list-group-item",
          "d-flex",
          "justify-content-between",
          "align-items-start",
          "bg-transparent"
        );
        li.setAttribute("title", "Click to remove item");
        li.id = receiptID;
        li.style.cursor = "pointer";
        Receipt.appendChild(li);

        // add item name
        var div = document.createElement("div");
        div.classList.add("ms-2", "me-auto", "text-truncate");
        div.id = "itemname_" + random;
        div.style.textTransform = "capitalize";
        div.style.maxWidth = "215px";
        div.innerHTML = "1 &times; Delivery";
        li.appendChild(div);

        // add item price
        var span = document.createElement("span");
        span.id = "itemprice";
        span.innerHTML =
          '<span class="text-muted">&#8369; <span id="priceItem">20.00</span><span class="text-danger px-2 fw-bold">&#8855;</span></span>';
        li.appendChild(span);

        // get all itemprice and add it to the total
        var itemprice = document.querySelectorAll("#priceItem");
        var total = 0;
        itemprice.forEach(function (price) {
          total += parseFloat(price.innerText);
        });

        document.getElementById("ammount").innerHTML =
          '<span class="fw-bold" id="overall">&#8369;&nbsp;' +
          total.toFixed(2) +
          "</span>";
        SelectedReceipt.push(receiptID);
        SelectedItemID.push("item_" + random); // add random number to the id to make it unique
        SelectedItemName.push("Delivery");
        SelectedItemPrice.push(20);
        SelectedItemQuantity.push(1);

        console.log(SelectedItems); // remove this later

        // add event listener to receipt item that when clicked remove the item from the receipt
        document
          .getElementById(receiptID)
          .addEventListener("click", function () {
            var index = SelectedReceipt.indexOf(receiptID);

            // add removed count to the current stock to the item

            var itemprice = document.querySelectorAll("#priceItem");
            var total = 0;
            itemprice.forEach(function (price) {
              total += parseFloat(price.innerText);
            });

            var overall = document.getElementById("overall");
            overall.innerHTML = "&#8369;&nbsp;" + (total - 20).toFixed(2);

            if (index > -1) {
              SelectedReceipt.splice(index, 1);
              SelectedItemID.splice(index, 1);
              SelectedItemName.splice(index, 1);
              SelectedItemPrice.splice(index, 1);
              SelectedItemQuantity.splice(index, 1);
            }

            document.getElementById(receiptID).remove();

            if (SelectedReceipt.length == 0) {
              document.getElementById("noItems").removeAttribute("hidden");
            }

            console.log(SelectedItems);

            document.getElementById("DeliveryServ").disabled = false;
            document.getElementById("DeliveryServ").checked = false;

            document.getElementById("PickupServ").disabled = false;
          });
      } else {
        document.getElementById("DeliveryServ").disabled = false;
        document.getElementById("PickupServ").disabled = false;
      }
    });
});
