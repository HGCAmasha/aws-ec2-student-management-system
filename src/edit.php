<?php
require_once 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    exit('Invalid student ID.');
}

$error = '';
$stmt = mysqli_prepare($conn, 'SELECT id, name, email, course FROM students WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$student) {
    http_response_code(404);
    exit('Student not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $student['name'] = $name;
    $student['email'] = $email;
    $student['course'] = $course;

    if ($name === '' || $course === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a name, valid email, and course.';
    } else {
        $stmt = mysqli_prepare($conn, 'UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $course, $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: index.php');
            exit;
        }
        $error = 'Unable to update student. Please try again.';
        mysqli_stmt_close($stmt);
    }
}
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Student | Student Management</title>
<style>
*{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:Inter,system-ui,-apple-system,'Segoe UI',sans-serif;color:#18233d;background:radial-gradient(circle at 15% 15%,#d7d7ff 0,transparent 35%),radial-gradient(circle at 90% 85%,#b9ecff 0,transparent 38%),#f4f6ff;display:grid;place-items:center;padding:28px 16px}.shell{width:min(100%,520px)}.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;gap:12px}.brand{font-weight:800;color:#5146b7;letter-spacing:.2px}.back{text-decoration:none;color:#5b55a8;font-size:14px;font-weight:650}.card{background:rgba(255,255,255,.95);border:1px solid #e8e8fa;border-radius:25px;box-shadow:0 20px 65px rgba(62,57,142,.12);padding:clamp(24px,6vw,42px)}.icon{width:58px;height:58px;border-radius:18px;display:grid;place-items:center;font-size:27px;color:#fff;background:linear-gradient(135deg,#7355ec,#28a6e8);box-shadow:0 9px 24px #7461db44}h1{font-size:29px;margin:20px 0 8px;letter-spacing:-.8px}.sub{color:#71809b;margin:0 0 26px;font-size:14px;line-height:1.6}.field{margin-bottom:19px}label{display:block;font-size:13px;font-weight:750;color:#364461;margin-bottom:8px}input{width:100%;border:1.5px solid #dce1f0;border-radius:12px;background:#fafbff;padding:14px 15px;font:inherit;font-size:15px;outline:none;transition:.2s}input:focus{border-color:#7866ed;background:#fff;box-shadow:0 0 0 4px #7866ed1c}.actions{display:flex;gap:12px;margin-top:26px}.save{flex:1;border:0;border-radius:13px;background:linear-gradient(100deg,#7654ed,#368fe9);color:white;padding:15px;font-size:15px;font-weight:750;cursor:pointer;box-shadow:0 10px 22px #635de333}.cancel{border:1px solid #dce1f0;border-radius:13px;padding:15px 19px;text-decoration:none;color:#5c6680;font-weight:700;background:#fff}.error{background:#fff0f1;border:1px solid #ffccd2;color:#a5213d;padding:12px 14px;border-radius:11px;margin-bottom:18px;font-size:14px}.foot{text-align:center;color:#8b94aa;font-size:12px;margin-top:18px}@media(max-width:400px){.actions{flex-direction:column}.cancel{text-align:center}}
</style>
</head>
<body>
<main class="shell">
<div class="top"><span class="brand">✦ StudentHub</span><a class="back" href="index.php">← Dashboard</a></div>
<section class="card">
<div class="icon">✎</div>
<h1>Edit Student</h1>
<p class="sub">Update the details for student #<?= e($id) ?>. Your changes will be saved to the database.</p>
<?php if ($error): ?><div class="error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post" action="edit.php?id=<?= e($id) ?>">
<div class="field"><label for="name">Full Name</label><input id="name" name="name" type="text" maxlength="100" required value="<?= e($student['name']) ?>" placeholder="Enter student name"></div>
<div class="field"><label for="email">Email Address</label><input id="email" name="email" type="email" maxlength="100" required value="<?= e($student['email']) ?>" placeholder="student@example.com"></div>
<div class="field"><label for="course">Course</label><input id="course" name="course" type="text" maxlength="100" required value="<?= e($student['course']) ?>" placeholder="Enter course"></div>
<div class="actions"><a class="cancel" href="index.php">Cancel</a><button class="save" type="submit" name="update">✓ Save Changes</button></div>
</form>
</section>
<p class="foot">Student Management System · PHP + MySQL</p>
</main>
</body>
</html>
