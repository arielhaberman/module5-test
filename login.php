<!DOCTYPE html> 
<html lang="en">
<head>
    <title>Log in</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1>Login Page</h1><br>   
    <!-- error message will be displayed if login failed -->
    <div id="loginFailed"></div>
    <div class="container">    
        <label> <b>Username</b> </label>    
        <br>
        <input type="text" name="username" id="username" class ="textfield" placeholder="  username">     
        <br>
        <label> <b>Password</b> </label>    
        <br>
        <input type="password" id="password" name="password" class ="textfield" placeholder="  password">     
        <br>
        <button id="login_btn" class="button">Log In</button>
        <br><br>
        <!-- Create Account button -->
        <form action="http://ec2-18-219-3-104.us-east-2.compute.amazonaws.com/~arielhaberman/module5-test/newUser.php">
            <input type="submit" class="button" value="Create Account" />
        </form>
        <br><br>
        <!-- Guest signin button -->
        <form action="http://ec2-18-219-3-104.us-east-2.compute.amazonaws.com/~arielhaberman/module5-test/mainpage.php">
            <input type="submit" class="button" value="Sign in as Guest" />
        </form>
    </div>
    
    <script>
        function loginAjax(event) {
            const username = document.getElementById("username").value; // Get the username from the form
            const password = document.getElementById("password").value; // Get the password from the form
            var loginSuccess = false;
            // Make a URL-encoded string for passing POST data:
            const data = { 'username': username, 'password': password };
            fetch("login_ajax.php", {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
            })
            .then(response => response.json())
            .then(function(data){
                if(data.success) {
                    window.location.href = "http://ec2-18-219-3-104.us-east-2.compute.amazonaws.com/~arielhaberman/module5-test/mainpage.php";
                    exit;
                }
                else {
                    document.getElementById("loginFailed").textContent = "Invalid username or password.";
                }
            })
            .catch(err => console.error(err));
        }
        document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click
    </script>
</body>
</html>
