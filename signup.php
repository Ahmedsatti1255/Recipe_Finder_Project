<?php 
include 'db.php'; 
include 'navbar.php';

// Process signup form - Using your simple logic
$error_message = '';
$success_message = '';

if(isset($_POST['signup'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Simple insert query as per your original logic
    $result = mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    
    if($result) {
        $success_message = "Signup successful! <a href='login.php'>Login here</a>";
    } else {
        $error_message = "Signup failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavor Finder | Create Your Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        .signup-container {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .signup-container::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff9a3c, #ff6b6b);
            top: -150px;
            right: -100px;
            opacity: 0.1;
        }
        
        .signup-container::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            bottom: -100px;
            left: -50px;
            opacity: 0.1;
        }
        
        .signup-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        
        .signup-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(to right, #ff9a3c, #ff6b6b, #4facfe);
        }
        
        .signup-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .signup-header h1 {
            font-size: 2.5rem;
            background: linear-gradient(45deg, #ff9a3c, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }
        
        .signup-header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .signup-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 1.2rem;
            z-index: 1;
        }
        
        .form-control {
            width: 100%;
            padding: 18px 20px 18px 55px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            line-height: normal;
        }
        
        .password-container {
            position: relative;
        }
        
        .password-container .form-control {
            padding-right: 55px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4facfe;
            background: white;
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.1);
        }
        
        .password-toggle {
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
            height: 46px;
            width: 50px;
            background: none;
            border: none;
            color: #888;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0 10px 10px 0;
            transition: all 0.3s ease;
            padding: 0;
        }
        
        .password-toggle i {
            position: relative;
            top: -1px;
        }
        
        .password-toggle:hover {
            color: #4facfe;
            background: rgba(79, 172, 254, 0.05);
        }
        
        .signup-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
        }
        
        .signup-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(79, 172, 254, 0.4);
        }
        
        .signup-button:active {
            transform: translateY(-1px);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }
        
        .login-link a {
            color: #4facfe;
            font-weight: 600;
            text-decoration: none;
            margin-left: 5px;
            transition: color 0.3s;
        }
        
        .login-link a:hover {
            color: #ff6b6b;
            text-decoration: underline;
        }
        
        .benefits {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            border-left: 4px solid #4facfe;
        }
        
        .benefits h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .benefits ul {
            list-style: none;
            padding-left: 5px;
        }
        
        .benefits li {
            margin-bottom: 10px;
            color: #555;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .benefits li i {
            color: #4facfe;
            margin-top: 3px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeIn 0.5s ease;
        }
        
        .alert-error {
            background: #ffeaea;
            color: #d32f2f;
            border-left: 4px solid #ff6b6b;
        }
        
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }
        
        .alert i {
            font-size: 1.2rem;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 480px) {
            .signup-card {
                padding: 30px 20px;
            }
            
            .signup-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-card">
            <div class="signup-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            
            <div class="signup-header">
                <h1>Join Flavor Finder</h1>
                <p>Create your free account to save recipes and discover delicious dishes</p>
            </div>
            
            <?php if($error_message): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $error_message; ?></span>
                </div>
            <?php endif; ?>
            
            <?php if($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo $success_message; ?></span>
                </div>
            <?php endif; ?>
            
            <form method="post" id="signupForm">
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="password-container">
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" name="signup" class="signup-button">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
            
            <div class="benefits">
                <h3><i class="fas fa-star"></i> Benefits of joining</h3>
                <ul>
                    <li><i class="fas fa-heart"></i> Save your favorite recipes</li>
                    <li><i class="fas fa-calendar-alt"></i> Create personalized meal plans</li>
                    <li><i class="fas fa-bell"></i> Get recipe recommendations</li>
                    <li><i class="fas fa-share-alt"></i> Share recipes with friends</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
        
        // Focus on first input field
        document.querySelector('input[name="name"]').focus();
    </script>
</body>
</html>