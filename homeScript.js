let jsonDeceasedData = [];
let username = '';
var pages = {};

const generateDeceasedTable = (data) => {
  // Assuming jsonDeceasedData contains the data in the same format as the previous example
  let tableRows = data.map(item => {
    return `
      <tr>
        <td>${item.name}</td>
        <td>${item.lot}</td>
        <td>${item.street}</td>
        <td>${item.dateofbirth}</td>
        <td>${item.dateofdeath}</td>
        <td>${item.status}</td>
        <td>
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Delete</button>
        </td>
      </tr>
    `;
  }).join('');

  // Return the full HTML table with the populated rows
  return `
    <h2>Deceased Records</h2>
    <div class="search-container">
      <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="search-bar" placeholder="Search here" class="search-bar">
      </div>
    </div>
    <!-- Stats Section -->
    <div class="stats">
      <div class="stat-box">
        <h2>${data.length}</h2>
        <p>Total</p>
      </div>
      <div class="stat-box">
        <h2>${data.filter(item => item.status === "Buried").length}</h2>
        <p>Buried</p>
      </div>
      <div class="stat-box">
        <h2>${data.filter(item => item.status === "Pending").length}</h2>
        <p>Pending</p>
      </div>
    </div>

    <table class="deceased-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Lot</th>
          <th>Street</th>
          <th>Birth Date</th>
          <th>Death Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="deceased-table-body">
        ${tableRows}
      </tbody>
    </table>
  `;
};

async function fetchDeceasedData() {
  try {
    const response = await fetch('getDeceasedData.php');
    if (!response.ok) throw new Error('Network response was not ok');

    jsonDeceasedData = await response.json();
    console.log('jsonDeceasedData:', jsonDeceasedData);
    pages = {
          "Deceased": generateDeceasedTable(jsonDeceasedData)
        };

    // You can call another function here to use the data
    // displayDeceasedData(jsonDeceasedData);
  } catch (error) {
    console.error('Fetch error:', error);
  }
}

fetchDeceasedData();

async function fetchShortName() {
    try {
        // Fetch the PHP file that returns the short name
        const response = await fetch('getName.php'); // Make sure the path is correct
        
        // Get the plain text response (short name)
        username = await response.text();
        
        console.log('Short Name:', username);
        
        
        // Now you can use the short name in your JavaScript code
    } catch (error) {
        console.error('Error fetching short name:', error);
    }
}

// Call the function to fetch the short name
fetchShortName();



// Toggle the visibility of a dropdown menu
const toggleDropdown = (dropdown, menu, isOpen) => {
  dropdown.classList.toggle("open", isOpen);
  menu.style.height = isOpen ? `${menu.scrollHeight}px` : 0;
};

// Close all open dropdowns
const closeAllDropdowns = () => {
  document.querySelectorAll(".dropdown-container.open").forEach((openDropdown) => {
    toggleDropdown(openDropdown, openDropdown.querySelector(".dropdown-menu"), false);
  });
};

// Attach click event to all dropdown toggles
document.querySelectorAll(".dropdown-toggle").forEach((dropdownToggle) => {
  dropdownToggle.addEventListener("click", (e) => {
    e.preventDefault();

    const dropdown = dropdownToggle.closest(".dropdown-container");
    const menu = dropdown.querySelector(".dropdown-menu");
    const isOpen = dropdown.classList.contains("open");

    closeAllDropdowns(); // Close all open dropdowns
    toggleDropdown(dropdown, menu, !isOpen); // Toggle current dropdown visibility
  });
});

// Attach click event to sidebar toggle buttons
document.querySelectorAll(".sidebar-toggler, .sidebar-menu-button").forEach((button) => {
  button.addEventListener("click", () => {
    closeAllDropdowns(); // Close all open dropdowns
    document.querySelector(".sidebar").classList.toggle("collapsed"); // Toggle collapsed class on sidebar
  });
});

// Collapse sidebar by default on small screens
if (window.innerWidth <= 1024) document.querySelector(".sidebar").classList.add("collapsed");

document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".nav-link");
  const mainContent = document.getElementById("main-content");

  // Function to generate the Add New form
const generateHome = () => {
  return `
    <h2>Welcome to Himlayang Palanyag ${username}</h2>
    <div class="search-container">
            <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="search-bar" placeholder="Search here" class="search-bar">
      </div>
</div>
  `;
};

  // Function to generate the deceased table
//   const generateDeceasedTable = () => {
//     return `
  
//       <h2>Deceased Records</h2>
//      <div class="search-container">
//             <div class="search-box">
//         <i class="fas fa-search search-icon"></i>
//         <input type="text" id="search-bar" placeholder="Search here" class="search-bar">
//       </div>
// </div>
// <!-- Stats Section -->
//             <div class="stats">
//                 <div class="stat-box">
//                     <h2>0</h2>
//                     <p>Total</p>
//                 </div>
//                 <div class="stat-box">
//                     <h2>0</h2>
//                     <p>Buried</p>
//                 </div>
//                 <div class="stat-box">
//                     <h2>0</h2>
//                     <p>Pending</p>
//                 </div>
//             </div>

//       <table class="deceased-table">
//         <thead>
//           <tr>
//             <th>Name</th>
//             <th>Lot</th>
//             <th>Street</th>
//             <th>Birth Date</th>
//             <th>Death Date</th>
//             <th>Status</th>
//             <th>Action</th>
//           </tr>
//         </thead>
//         <tbody id="deceased-table-body">
//           <tr>
//             <td>Juan Dela Cruz</td>
//             <td>12</td>
//             <td>Main Street</td>
//             <td>January 1, 1950</td>
//             <td>March 5, 2020</td>
//             <td>Buried</td>
//             <td>
//               <button class="edit-btn">Edit</button>
//               <button class="delete-btn">Delete</button>
//             </td>
//           </tr>
//           <tr>
//             <td>One</td>
//             <td>1</td>
//             <td>Elm Street</td>
//             <td>January 1, 1951</td>
//             <td>March 1, 2021</td>
//             <td>Pending</td>
//             <td>
//               <button class="edit-btn">Edit</button>
//               <button class="delete-btn">Delete</button>
//             </td>
//           </tr>
//            <tr>
//             <td>Two</td>
//             <td>12</td>
//             <td>Palm Street</td>
//             <td>January 2, 1952</td>
//             <td>March 2, 2022</td>
//             <td>Buried</td>
//             <td>
//               <button class="edit-btn">Edit</button>
//               <button class="delete-btn">Delete</button>
//             </td>
//           </tr>
//            <tr>
//             <td>Three</td>
//             <td>12</td>
//             <td>Maple Street</td>
//             <td>January 3, 1953</td>
//             <td>March 3, 2023</td>
//             <td>Pending</td>
//             <td>
//               <button class="edit-btn">Edit</button>
//               <button class="delete-btn">Delete</button>
//             </td>
//           </tr>
//           <tr>
//             <td>Four</td>
//             <td>12</td>
//             <td>Main Street</td>
//             <td>January 4, 1954</td>
//             <td>March 4, 2024</td>
//             <td>Buried</td>
//             <td>
//               <button class="edit-btn">Edit</button>
//               <button class="delete-btn">Delete</button>
//             </td>
//           </tr>
//         </tbody>
//       </table>
//     `;
//   };

// Assuming jsonDeceasedData is already assigned to your JavaScript variable





  // Function to enable editing a row
  const enableEditing = (row) => {
    const cells = row.querySelectorAll("td");
    for (let i = 0; i < cells.length - 2; i++) {
      let input = document.createElement("input");
      input.type = "text";
      input.value = cells[i].textContent;
      cells[i].textContent = "";
      cells[i].appendChild(input);
    }
    row.querySelector(".edit-btn").textContent = "Save";
    row.querySelector(".edit-btn").classList.add("save-btn");
  };

  // Function to save edited row
  const saveEditedRow = (row) => {
    const inputs = row.querySelectorAll("input");
    inputs.forEach((input, index) => {
      row.cells[index].textContent = input.value;
    });
    row.querySelector(".edit-btn").textContent = "Edit";
    row.querySelector(".edit-btn").classList.remove("save-btn");
  };

   // Function to delete a row with confirmation
   const deleteRow = (row) => {
    if (confirm("Are you sure you want to delete this record?")) {
      row.remove();
    }
  };
  // Function to handle Enter key for saving
  document.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      let activeElement = document.activeElement;
      if (activeElement && activeElement.tagName === "INPUT") {
        let row = activeElement.closest("tr");
        let saveButton = row.querySelector(".save-btn");
        if (saveButton) {
          event.preventDefault(); // Prevent newline
          saveEditedRow(row);
        }
      }
    }
  });


 // Function to search deceased records
const searchRecords = () => {
  const searchTerm = document.getElementById("search-bar").value.toLowerCase();
  const rows = document.querySelectorAll("#deceased-table-body tr");

  rows.forEach(row => {
    const cells = row.querySelectorAll("td");
    let matchFound = false;

    cells.forEach((cell, index) => {
      let cellText = cell.textContent.toLowerCase();

      // Ensure we are not filtering "Edit" and "Delete" actions (assuming they are in the last column)
      if (index < cells.length - 1 && cellText.includes(searchTerm)) {
        matchFound = true;
      }
    });

    row.style.display = matchFound ? "" : "none";
  });
};

// Ensure event listener for search button is added after content loads
document.addEventListener("input", (event) => {
  if (event.target.id === "search-bar") {
    searchRecords();
  }
});

  // Event delegation for edit and delete buttons
  document.addEventListener("click", (event) => {
    if (event.target.classList.contains("edit-btn")) {
      const row = event.target.closest("tr");
      if (event.target.classList.contains("save-btn")) {
        saveEditedRow(row);
      } else {
        enableEditing(row);
      }
    }
    if (event.target.classList.contains("delete-btn")) {
      const row = event.target.closest("tr");
      deleteRow(row);
    }
  });

  
  // Function to generate the Add New form
  const generateAddNewForm = () => {
    const currentYear = new Date().getFullYear();
    return `
      <h2>Add New Deceased Record</h2>
      <div class="formdiv">
        <form id="add-new-form">
          <div class="name-fields">
            <div class="input-group">
              <label for="fname">First Name:</label>
              <input type="text" id="fname" name="fname" required>
              <small class="error-message" id="fname-error"></small>
            </div>
            <div class="input-group">
<label for="fname">Last Name:</label>
              <input type="text" id="lname" name="lname" required>
              <small class="error-message" id="lname-error"></small>
            </div>
          </div>

          <div class="input-group">
            <label for="lot">Lot No:</label>
            <input type="text" id="lot" name="lot" required>
            <small class="error-message" id="lot-error"></small>
          </div>

          <div class="input-group">
             <label for="street">Street:</label>
            <select id="street" name="street" required>
              <option value="" disabled selected>Select Street</option>
              <option value="Main Street">Main Street</option>
              <option value="Elm Street">Elm Street</option>
              <option value="Pine Avenue">Pine Avenue</option>
              <option value="Maple Drive">Maple Drive</option>
            </select>
          </div>

          <div class="input-group">
            <label for="birthdate">Birth Date:</label>
            <input type="date" id="birthdate" name="birthdate" max="${currentYear}-12-31" required>
          </div>

          <div class="input-group">
            <label for="deathdate">Death Date:</label>
            <input type="date" id="deathdate" name="deathdate" max="${currentYear}-12-31" required>
          </div>

          <div class="input-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
              <option value="Buried">Buried</option>
              <option value="Pending">Pending</option>
            </select>
          </div>

          <button type="submit" class="submit-btn">Submit</button>
        </form>
      </div>
    `;
  };




  // Define content for each page
  pages["Home"] = generateHome();
  pages["Add New"] = generateAddNewForm();
  pages["Sign Out"] = "<h2>Signing Out...</h2><p>You have been logged out.</p>";

  // Handle navigation click events
  navLinks.forEach(link => {
    link.addEventListener("click", function (event) {
      event.preventDefault();

      // Remove active class from all links
      navLinks.forEach(item => item.classList.remove("active"));
      
      // Add active class to the clicked link
      this.classList.add("active");

      // Get the page name from the link's label
      let pageName = this.querySelector(".nav-label")?.textContent.trim();
      if (pages[pageName]) {
        mainContent.innerHTML = pages[pageName]; // Update main content dynamically

        // Add event listener for form submission
        if (pageName === "Add New") {
          document.getElementById("add-new-form").addEventListener("submit", function (e) {
            e.preventDefault();
            alert("Form submitted! (You can replace this with database integration)");
          });
          // Attach input restrictions
          addInputRestrictions();
        }
      }
    });
  });

});

//Function for Restrictions
  function addInputRestrictions() {
    // Get input elements
    const fnameInput = document.getElementById("fname");
    const lnameInput = document.getElementById("lname");
    const lotInput = document.getElementById("lot");
  
    // Function to prevent invalid input and show error message
    function restrictInput(event, regex, errorId, errorMessage) {
      const char = event.key;
      if (!regex.test(char)) {
        event.preventDefault(); // Block the input
        showError(errorId, errorMessage);
      } else {
        hideError(errorId);
      }
    }
  
    // Restrict First and Last Name to only letters and spaces
    fnameInput.addEventListener("keypress", function (event) {
      restrictInput(event, /^[a-zA-Z\s]$/, "fname-error", "Only letters and spaces allowed!");
    });
  
    lnameInput.addEventListener("keypress", function (event) {
      restrictInput(event, /^[a-zA-Z\s]$/, "lname-error", "Only letters and spaces allowed!");
    });
  
    // Restrict Lot No to only numbers
    lotInput.addEventListener("keypress", function (event) {
      restrictInput(event, /^[0-9]$/, "lot-error", "Only numbers allowed!");
    });
  }
  
  // Show error message
  function showError(id, message) {
    let errorElement = document.getElementById(id);
    if (!errorElement) {
      errorElement = document.createElement("p");
      errorElement.id = id;
      errorElement.classList.add("error-message");
      document.getElementById(id.replace("-error", "")).insertAdjacentElement("afterend", errorElement);
    }
    errorElement.textContent = message;
  }
  
  // Hide error message
  function hideError(id) {
    let errorElement = document.getElementById(id);
    if (errorElement) {
      errorElement.textContent = "";
    }
  }
  
  // Run function after DOM loads
  document.addEventListener("DOMContentLoaded", addInputRestrictions);  

  // Style of error message
const style = document.createElement("style");
style.innerHTML = `
  .error-message {
    color: red !important;
    font-size: 12px;
    margin-top: 5px;
  }
`;
document.head.appendChild(style);

