<?php
session_start();

$host = 'localhost';  // Change to your DB host
$dbname = 'aplikasiarsip';   // Change to your DB name
$dbuser = 'root';     // Change to your DB user
$dbpass = '';         // Change to your DB password
$loginSuccess = false;

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = trim($_POST['username'] ?? '');
    $input_password = $_POST['password'] ?? '';

    if (!$input_username || !$input_password) {
        $login_error = "Please enter both username and password.";
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username");
            $stmt->execute(['username' => $input_username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($input_password, $user['password_hash'])) {
                $_SESSION['id_user'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $loginSuccess = true;
                header('Location: index.php');
                exit;
            } else {
                $login_error = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $login_error = "Database connection failed: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>E- Arsip | XI PPLG 1</title>

<link rel="icon" href="logoarsip.png" type="image/png">
<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: sans-serif;
    background: #f5f7fa;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Full viewport height */
    flex-direction: column;
  }

  .navbar {
    background-color: #ffff;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 1rem;
    height: 56px;
    width: 100%;
    max-width: 100vw;
    user-select: none;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1100;
  }

  .navbar .brand {
    cursor: default;
    display: flex;
    align-items: center;
  }

  .navbar .brand img {
    height: 100px;
    width: auto;
  }

  .navbar ul {
    list-style: none;
    display: flex;
    margin: 0;
  }

  .navbar ul li {
    margin-left: 1.5rem;
  }

  .navbar ul li a {
    color: #1d1d42;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .navbar ul li a:hover,
  .navbar ul li a:focus {
    color: #ff9f43;
    outline: none;
  }

  .navbar .menu-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
  }

  .navbar .menu-toggle span {
    background: white;
    height: 3px;
    width: 25px;
    margin: 4px 0;
    border-radius: 2px;
    transition: 0.3s;
  }

  @media (max-width: 600px) {
    .navbar {
      padding: 0.5rem 1rem;
      height: 50px;
    }

    .navbar ul {
      position: fixed;
      top: 50px;
      right: 0;
      background: #34495e;
      width: 200px;
      height: calc(100vh - 50px);
      flex-direction: column;
      padding-top: 1rem;
      display: none;
      box-shadow: -3px 0 5px rgba(0,0,0,0.2);
      z-index: 1000;
      transition: transform 0.3s ease;
      transform: translateX(100%);
    }

    .navbar ul.active {
      display: flex;
      transform: translateX(0);
    }

    .navbar ul li {
      margin: 1rem 0;
      text-align: right;
      margin-right: 1.5rem;
    }

    .navbar .menu-toggle {
      display: flex;
    }
  }

  .container {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    width: 350px;
    margin-top: 80px; /* account for fixed navbar height + some spacing */
  }

  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #333;
  }

  label {
    display: block;
    margin-bottom: 0.3rem;
    color: #555;
  }

  input[type="text"], input[type="password"] {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
  }

  input[type="text"]:focus, input[type="password"]:focus {
    border-color: #ff9f43;
    outline: none;
  }

  button {
    width: 100%;
    padding: 0.6rem;
    background-color: #1d1d42;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  button:hover {
    background-color: #ff9f43;
  }

  .error-message {
    color: #cc0000;
    margin-bottom: 1rem;
    text-align: center;
  }

  .register-link {
    text-align: center;
    margin-top: 1rem;
  }

  .register-link a {
    color: #ff9f43;
    text-decoration: none;
  }

  .register-link a:hover {
    text-decoration: underline;
  }

  #toast {
    visibility: hidden;
    min-width: 250px;
    max-width: 90vw;
    margin-left: -125px;
    background-color: #4BB543; /* green */
    color: white;
    text-align: center;
    border-radius: 10px;
    padding: 1rem 1.5rem;
    position: fixed;
    z-index: 1000;
    left: 50%;
    bottom: 30px;
    font-size: 1rem;
    box-shadow: 0 8px 15px rgba(0,0,0,0.25);
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.4s ease, transform 0.4s ease;
  }

  #toast.show {
    visibility: visible;
    opacity: 1;
    transform: translateY(0);
  }
</style>
</head>
<body>

<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="brand" tabindex="0">
    <img src="logo00.png" alt="Logo" />
  </div>
  <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
  <ul id="primary-menu" class="nav-links">
    <li><a href="#home" tabindex="0">Home</a></li>
    <li><a href="#about" tabindex="0">About</a></li>
    <li><a href="#services" tabindex="0">Services</a></li>
    <li><a href="#contact" tabindex="0">Contact</a></li>
  </ul>
</nav>

<div class="container">
  <h2>Login</h2>
  <?php if ($login_error): ?>
    <div class="error-message"><?php echo htmlspecialchars($login_error); ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required autofocus maxlength="50" />

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required />

    <button type="submit">Log In</button>
  </form>
  <div class="register-link">Don't have an account? <a href="register.php">Register here</a>.</div>
</div>

<div id="toast">Login Successful!</div>

<script>
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');

  menuToggle.addEventListener('click', () => {
    const expanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
    menuToggle.setAttribute('aria-expanded', !expanded);
    navLinks.classList.toggle('active');
  });

  // Close menu on link click (mobile)
  navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      if(navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', false);
      }
    });
  });

  (function(){
    var loginSuccess = <?= json_encode($loginSuccess); ?>;
    var toast = document.getElementById('toast');

    if (loginSuccess) {
      toast.classList.add('show');
      setTimeout(function(){
        toast.classList.remove('show');
      }, 3000);
    }
  })();
</script>

</body>
</html>

