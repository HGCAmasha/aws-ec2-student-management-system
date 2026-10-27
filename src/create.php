<?php
require_once 'db.php';
$error = '';
$name = '';
$email = '';
$course = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    if ($name === '' || $course === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a name, valid email address, and course.';
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO students (name, email, course) VALUES (?, ?, ?)');
        if ($stmt && mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $course) && mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: index.php');
            exit;
        }
        $error = 'Unable to save the student. Please try again.';
        if ($stmt) mysqli_stmt_close($stmt);
    }
}
function e($value) { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Student | Student Management</title>
<style>
:root{font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;color:#25304b}
*{box-sizing:border-box}
body{margin:0;min-height:100vh;background:radial-gradient(circle at 8% 8%,#b4a6ff 0,transparent 32%),radial-gradient(circle at 95% 85%,#8adcf8 0,transparent 35%),linear-gradient(135deg,#f4f1ff,#eaf6ff);display:grid;place-items:center;padding:28px 16px}
.shell{width:min(100%,530px)}
.back{display:inline-flex;align-items:center;gap:8px;color:#5546b6;text-decoration:none;font-size:14px;font-weight:700;margin-bottom:18px}
.card{background:rgba(255,255,255,.94);border:1px solid rgba(255,255,255,.8);border-radius:26px;padding:36px;box-shadow:0 24px 70px rgba(72,68,155,.16)}
.icon{width:56px;height:56px;border-radius:17px;background:linear-gradient(135deg,#6d5efc,#9b69ee);color:white;display:grid;place-items:center;font-size:27px;box-shadow:0 9px 22px rgba(109,94,252,.25)}
h1{font-size:29px;letter-spacing:-.9px;margin:19px 0 8px}
.subtitle{color:#7b8297;font-size:14px;line-height:1.6;margin:0 0 29px}
.field{margin-bottom:19px}label{display:block;font-weight:700;font-size:13px;margin-bottom:9px;color:#3a4362}
input{display:block;width:100%;padding:15px 16px;border:1.5px solid #e1e4f2;border-radius:12px;font:inherit;font-size:14px;background:#fafbff;color:#25304b;outline:none;transition:.2s}
input:focus{border-color:#7768f6;background:white;box-shadow:0 0 0 4px rgba(119,104,246,.11)}
input::placeholder{color:#a1a7b8}
button{width:100%;border:0;border-radius:13px;padding:16px;color:#fff;font:inherit;font-weight:750;cursor:pointer;background:linear-gradient(100deg,#6257ee,#8c5fe7);box-shadow:0 12px 23px rgba(98,87,238,.22);margin-top:8px;transition:transform .15s,filter .15s}
button:hover{transform:translateY(-2px);filter:brightness(1.05)}
.error{background:#fff0f1;color:#ae2c45;padding:13px 15px;border-radius:10px;font-size:13px;margin-bottom:20px}
.footer{text-align:center;color:#8c91a7;font-size:12px;margin-top:20px}
@media(max-width:480px){.card{padding:26px 21px}h1{font-size:25px}}
</style>
</head>
<body>
<main class="shell">
<a class="back" href="index.php">← Back to Dashboard</a>
<section class="card">
<div class="icon" aria-hidden="true">✦</div>
<h1>Add New Student</h1>
<p class="subtitle">Fill in the details below to add a student to your management system.</p>
<?php if ($error !== ''): ?><div class="error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form method="POST" action="create.php">
<div class="field"><label for="name">Student Name</label><input id="name" type="text" name="name" placeholder="Enter student's full name" value="<?= e($name) ?>" maxlength="100" required></div>
<div class="field"><label for="email">Email Address</label><input id="email" type="email" name="email" placeholder="student@example.com" value="<?= e($email) ?>" maxlength="100" required></div>
<div class="field"><label for="course">Course / Program</label><input id="course" type="text" name="course" placeholder="e.g. Information Technology" value="<?= e($course) ?>" maxlength="100" required></div>
<button type="submit" name="submit">＋ Save Student</button>
</form>
</section>
<p class="footer">Student Management System · AWS EC2 Project</p>
</main>
</body>
</html>
