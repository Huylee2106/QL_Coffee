<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../login_staff_manager/login.css">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        
            <div class="login">

                <h3><span class="choose"><a href="../login_staff_manager/login_staff.php">Staff</a></span> | <span class="choose active"><a href="../login_staff_manager/login_manager.php">Manager</a></span></h3>

                <div class="input">
                    <input type="text" class="name" id="user" placeholder="username" required>
                </div>

                <div class="input">
                    <input type="password" class="password" id="password" placeholder="password" required>
                </div>

                <div class="remember-forget">
                    <label for=""><input type="checkbox">Remember password</label>
                    <a href="../login_staff_manager/forgot_pass.php">Forgot password?</a>
                </div>

                <button type="submit" class="btn" name="submit">Login</button>
            </div>
    </body>
</html>