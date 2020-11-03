<!DOCTYPE html> 
<html lang="en">
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <a href='login.php'>Go back to login page</a> <br><br>
    <h1>Create Account</h1><br>  
    <div id="failed"></div>
    
    <!-- form for filling in info -->
    <div class="container">  
        <label> <b>First Name</b> </label>    
        <br>
        <input type="text" name="first_name" id="first_name" class ="textfield" placeholder="  First Name">     
        <br>
        <label> <b>Last Name</b> </label>    
        <br>
        <input type="text" name="last_name" id="last_name" class ="textfield" placeholder="  Last Name">     
        <br>
        <label> <b>Username</b> </label>    
        <br>
        <input type="text" name="username" class ="textfield" id="username" placeholder="  username">
        <br>
        <label> <b>Password</b> </label>    
        <br>
        <input type="password" name="password" id="password" class ="textfield" placeholder="  password">     
        <br>
        <button id="create_account_btn" class="button">Create Account</button>
    </div>
    <script>
        function createAccountAjax(event) {
            const username = document.getElementById("username").value; 
            const password = document.getElementById("password").value;
            const first_name = document.getElementById("first_name").value; 
            const last_name = document.getElementById("last_name").value;
            var createdAccount = false;
            // Make a URL-encoded string for passing POST data:
            const data = { 'username': username, 'password': password, 'first_name': first_name, 'last_name': last_name };
            fetch("create_account_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(function(data){
                if(data.available) {
                    document.getElementById("failed").textContent = "Your account was successfully created!";
                }
                else {
                    document.getElementById("failed").textContent = "That username is taken.";
                }
            })
            .catch(err => console.error(err));
        }
        document.getElementById("create_account_btn").addEventListener("click", createAccountAjax, false); // Bind the AJAX call to button click
    </script>
</body>
</html>
