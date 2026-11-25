<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

session_start();

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $email = trim($_POST['email'] ?? ''); 
    $password = $_POST['password'] ?? ''; 
 
    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email = ? LIMIT 1"
    ); 
    
    $stmt->execute([$email]); 
    $user = $stmt->fetch(); 
 
    if (!$user) { 
        $error = 'Email not found'; 
        
    } elseif (!password_verify($password, $user['password'])) { 
        $error = 'Password does not match'; 
        
    } else { 
        $_SESSION['admin_id'] = (int)$user['id']; 
        $_SESSION['admin_name'] = $user['name']; 
 
        header('Location: dashboard.php'); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Tourist Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="login-card bg-white p-4 p-lg-5">
        <div class="text-center mb-4">
            <div class="brand-mark mx-auto mb-2">LP</div>
            <h2 class="fw-bold">Admin Login</h2>
            <p class="text-muted">Manage Tourist Attraction Data</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control mb-3" required>

            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control mb-4" required>

            <button class="btn btn-green w-100 btn-lg">Login</button>
        </form>

        <a href="../index.php" class="d-block text-center mt-4 text-success">← Back to website</a>
    </div>
</div>
</body>
</html>
