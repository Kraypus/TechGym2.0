//Log in form validation
const login = new JustValidate("#log-in", {
    errorLabelStyle: {
      display: "block",
      color: "red",
      marginTop: "5px",
      fontWeight: "",
      fontSize: "16px",
    }
  });
  
login
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("log-in").submit();
    });

//Registration form validation
const validationregister = new JustValidate("#signup", {
    errorLabelStyle: {
      display: "block",
      color: "red",
      marginTop: "5px",
      fontWeight: "",
      fontSize: "16px",
    }
  });
  
validationregister
    .addField("#username", [
        {
            rule: "required"
        }
    ])

    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(json) {
                            return json.available;
                        });
            },
            errorMessage: "Email already taken"
        }
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#confirm_password", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });

/*Account info - email*/
const email = new JustValidate("#update-email", {
    errorLabelStyle: {
      display: "block",
      color: "red",
      marginTop: "5px",
      fontWeight: "",
      fontSize: "16px",
    }
  });

email
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                       .then(function(response) {
                           return response.json();
                       })
                       .then(function(json) {
                           return json.available;
                       });
            },
            errorMessage: "Email already taken"
        }
    ])
    .addField("#confirm_email", [
        {
            validator: (value, fields) => {
                return value === fields["#email"].elem.value;
            },
            errorMessage: "Emails should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("update-email").submit();
    });

/*Account info - password*/
const password = new JustValidate("#update-password", {
    errorLabelStyle: {
      display: "block",
      color: "red",
      marginTop: "5px",
      fontWeight: "",
      fontSize: "16px",
    }
  });
  
password
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#confirm_password", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("update-password").submit();
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
