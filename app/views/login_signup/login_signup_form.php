
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Log in or Sign up</title>
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .nav-link {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            margin: 5px;
        }

        .nav-link.active {
            font-weight: bold;
            color: #007bff !important;
            border-color: #007bff;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            /* Khoảng cách giữa hai nút */
        }

        .button-group .btn {
            flex: 1;
            /* Chia đều không gian cho hai nút */
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Log in or Sign up</h2>
        <div class="form-container">
            <form action="/gear_management/public/user/handleRequest" method="POST" id="login-signup-form">
                <input type="hidden" id="data-type" name="data_type" value="login">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="nav-link active" id="login-tab">Log in</div>
                    </div>
                    <div class="col-md-6">
                        <div class="nav-link" id="signup-tab">Sign up</div>
                    </div>
                </div>
                <div class="tab-content active" id="login-content">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        <label for="name">UserName</label>
                    </div>
                    <div class="form-floating mb-3 password-container">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password')"></i>
                    </div>
                    <div class="mb-3 ms-2">
                        <input type="checkbox" id="remember" name="remember" checked>
                        <label for="remember">Remember me</label>
                        <a href="#" class="ms-2 float-end">Forgot password?</a>
                    </div>
                </div>
                <div class="tab-content" id="signup-content">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="new_name" name="new_name" placeholder="Name" required>
                        <label for="new_name">UserName</label>
                    </div>
                    <div class="form-floating mb-3 password-container">
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password" required>
                        <label for="new_password">Password</label>
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('new_password')"></i>
                    </div>
                    <div class="form-floating mb-3 password-container">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                        <label for="confirm_password">Confirm password</label>
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('confirm_password')"></i>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('login-tab');
        const signupTab = document.getElementById('signup-tab');
        const loginContent = document.getElementById('login-content');
        const signupContent = document.getElementById('signup-content');

        function toggleFormControls(content, enable) {
            const inputs = content.querySelectorAll('input');
            inputs.forEach(input => {
                input.disabled = !enable;
            });
        }

        function togglePasswordVisibility(passwordFieldId) {
            const passwordField = document.getElementById(passwordFieldId);
            const toggleIcon = passwordField.nextElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        loginTab.addEventListener('click', () => {
            loginTab.classList.add('active');
            signupTab.classList.remove('active');
            loginContent.classList.add('active');
            signupContent.classList.remove('active');
            document.getElementById('data-type').value = 'login';
            toggleFormControls(signupContent, false);
            toggleFormControls(loginContent, true);
        });

        signupTab.addEventListener('click', () => {
            loginTab.classList.remove('active');
            signupTab.classList.add('active');
            loginContent.classList.remove('active');
            signupContent.classList.add('active');
            document.getElementById('data-type').value = 'signup';
            toggleFormControls(loginContent, false);
            toggleFormControls(signupContent, true);
        });

        toggleFormControls(signupContent, false);
        toggleFormControls(loginContent, true);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>