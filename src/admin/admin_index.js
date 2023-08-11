function openTab(tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(tabName).style.display = "block";
  document.querySelector("[onclick=\"openTab('" + tabName + "')\"]");
}

function logout() {
  window.location.href = "../login/logout.php";
}


// Function to convert table cell to input field for editing
function editProduct(id) {
  const tr = $(`tr[data-id="${id}"]`);
  tr.find(".editable").each(function () {
    const input = $("<input>").attr("type", "text").val($(this).text());
    $(this).html(input);
  });
  tr.find(".edit-btn").text("Save").attr("onclick", `saveProduct(${id})`);
}

// Function to convert input field back to table cell after saving
function saveProduct(id) {
  const tr = $(`tr[data-id="${id}"]`);
  const data = {
    name: tr.find(".name").find("input").val(),
    price: tr.find(".price").find("input").val(),
    available: tr.find(".available").find("input").val(),
    description: tr.find(".description").find("input").val(),
    cost_price: tr.find(".cost_price").find("input").val(),
    discount: tr.find(".discount").find("input").val(),
    return_policy: tr.find(".return_policy").find("input").val(),
  };

  if (
    !data.name ||
    !data.price ||
    !data.available ||
    !data.description ||
    !data.return_policy ||
    !data.cost_price
  ) {
    alert("Error: Required field cannot be empty");
    return;
  }

  // check price
  if (data.price.startsWith("$")) {
    data.price = data.price.slice(1); // Remove the dollar sign
  }
  if (Number(data.price) < 0) {
    alert("Error: Price can not be negative.");
    return;
  }
  // check cost price
  if (data.cost_price.startsWith("$")) {
    data.cost_price = data.cost_price.slice(1); // Remove the dollar sign
  }
  if (Number(data.cost_price) < 0) {
    alert("Error: Cost Price can not be negative.");
    return;
  }

  //check discount
  if (data.discount.endsWith("%")) {
    data.discount = data.discount.slice(0, -1);
  }
  const discountNumber = parseFloat(data.discount);
  if (discountNumber < 0 || discountNumber > 100 || isNaN(discountNumber)) {
    alert("Invalid discount. Discount must be a number between 0 and 100.");
    return;
  }
  console.log(data,id);
  $.post(`../products/update_product.php?id=${id}`, data, function (response) {
    console.log(response);
    tr.find(".editable").each(function () {
      const input = $(this).find("input");
      const value = input.val();
      const isPrice = $(this).hasClass("price");
      const isDiscount = $(this).hasClass("discount");
      const isCostPrice = $(this).hasClass("cost_price");

      if (isPrice && value && !value.startsWith("$")) {
        input.val("$" + value);
      }

      if (isCostPrice && value && !value.startsWith("$")) {
        input.val("$" + value);
      }

      if (isDiscount && value && value.endsWith("%")) {
        input.val(value.slice(0, -1));
      }

      $(this).html(input.val());
    });
    tr.find(".edit-btn").text("Edit").attr("onclick", `editProduct(${id})`);
  }).done(function () {
    // location.reload();
  });
}

// function to handle the product deletion
function deleteProduct(id) {
  if (confirm("Are you sure you want to delete this product?")) {
    $.post(
      `../products/delete_product.php`,
      { product_id: id },
      function (response) {
        const tr = $(`tr[data-id="${id}"]`);
        tr.remove();
      }
    )
      .done(function () {
        location.reload();
      })
      .fail(function () {
        alert("An error occurred while deleting the product.");
      });
  }
}

// function to handle the product archive
function processArchive(id, archive) {
  var confirm_message = "";
  if (archive) {
    confirm_message = confirm("Are you sure you want to archive this product?");
  } else {
    confirm_message = confirm(
      "Are you sure you want to move this product back to?"
    );
  }
  if (confirm_message) {
    $.post(
      `../products/process_archive.php`,
      { product_id: id, archive: archive },
      function (response) {
        const tr = $(`tr[data-id="${id}"]`);
        tr.remove();
      }
    )
      .done(function () {
        location.reload();
      })
      .fail(function () {
        alert("An error occurred while archiving the product.");
      });
  }
}

function handleCheckboxClick(checkbox, purchase_id) {
  if (
    confirm(
      "Please confirm to ship this product. You cannot cancel this action."
    )
  ) {
    $.post(`../products/ship_product.php`, { purchase_id: purchase_id })
      .done(function () {
        checkbox.checked = true;
        checkbox.disabled = true;
        location.reload();
      })
      .fail(function () {
        alert("An error occurred while updating the product.");
      });
  } else {
    checkbox.checked = false;
  }
}

// Function to save the current active tab to local storage
function saveActiveTab(tabName) {
  localStorage.setItem('activeTab', tabName);
}

// Function to load the saved active tab from local storage and open it
function loadActiveTab() {
  const activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    document.getElementById(activeTab).click();
  } else {
    document.getElementById('defaultOpen').click();
  }
}

// Add an event listener to save the active tab when a tab is clicked
document.querySelectorAll('.tablink').forEach(tab => {
  tab.addEventListener('click', function() {
    saveActiveTab(this.id);
  });
});

// add function to cancel a purchase
function cancelPurchase(purchase_id) {
  if (confirm("Are you sure you want to cancel this order?")) {
    $.post(
      `../purchases/cancel_purchase.php`,
      { purchase_id: purchase_id },
      function (response) {
        const tr = $(`tr[data-id="${purchase_id}"]`);
        tr.remove();
      }
    )
      .done(function () {
        location.reload();
      })
      .fail(function () {
        alert("An error occurred while cancelling the purchase.");
      });
  }
}

// Load the active tab when the page is fully loaded
window.addEventListener('load', loadActiveTab);