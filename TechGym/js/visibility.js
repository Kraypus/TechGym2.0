function toggleVisibility(section, isHidden) {
    var button = document.querySelector("button[value='hide" + section + "']");
    var hiddenValue = isHidden ? 'false' : 'true';
    
    // Update the button class
    if (isHidden) {
      button.classList.remove("fa-eye");
      button.classList.add("fa-eye-slash");
    } else {
      button.classList.remove("fa-eye-slash");
      button.classList.add("fa-eye");
    }
  
    // Update the hidden value
    button.dataset.hidden = hiddenValue;
  
    // Update the database via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_hidden.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle the response if needed
      }
    };
    xhr.send("section=" + section + "&hidden=" + hiddenValue);
  }  