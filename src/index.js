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

// Load the active tab when the page is fully loaded
window.addEventListener('load', loadActiveTab);