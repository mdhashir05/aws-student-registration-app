<?php
require_once '/var/www/student-app-config.php';

mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli(
    $db_host,
    $db_user,
    $db_pass,
    $db_name,
    $db_port
);

$message = '';
$messageType = '';
$students = false;

if ($conn->connect_error) {
    error_log('Student app database connection failed.');
    http_response_code(500);
    $message = 'Database connection failed. Please try again later.';
    $messageType = 'error';
} else {
    $conn->set_charset('utf8mb4');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (
            $name === '' ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            $course === ''
        ) {
            $message = 'Enter a name, valid email, and course.';
            $messageType = 'error';
        } else {
            $stmt = $conn->prepare(
                'INSERT INTO students (name, email, course, phone)
                 VALUES (?, ?, ?, ?)'
            );

            if ($stmt) {
                $stmt->bind_param(
                    'ssss',
                    $name,
                    $email,
                    $course,
                    $phone
                );

                if ($stmt->execute()) {
                    $message = 'Student registered successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Registration failed. Please try again.';
                    $messageType = 'error';
                    error_log('Student registration insert failed.');
                }

                $stmt->close();
            } else {
                $message = 'Unable to process registration right now.';
                $messageType = 'error';
                error_log(
                    'Student registration statement preparation failed.'
                );
            }
        }
    }

    $students = $conn->query(
        'SELECT id, name, email, course, phone, created_at
         FROM students
         ORDER BY id DESC
         LIMIT 50'
    );
}

function h($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Student Registration | AWS Cloud Project</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <header>
        <h1>Student Registration</h1>
        <p>
            A student registration application powered by
            AWS EC2 and Amazon RDS.
        </p>
    </header>

    <section>
        <h2>Register a Student</h2>

        <?php if ($message !== ''): ?>
            <p class="<?= h($messageType) ?>" role="status">
                <?= h($message) ?>
            </p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="name">Full Name</label>
            <input
                id="name"
                name="name"
                type="text"
                maxlength="100"
                required
            >

            <label for="email">Email Address</label>
            <input
                id="email"
                name="email"
                type="email"
                maxlength="100"
                required
            >

            <label for="course">Course</label>
            <select id="course" name="course" required>
                <option value="">Select a course</option>
                <option value="AWS Cloud Computing">
                    AWS Cloud Computing
                </option>
                <option value="Cloud Engineering">
                    Cloud Engineering
                </option>
                <option value="Web Development">
                    Web Development
                </option>
                <option value="Cybersecurity">
                    Cybersecurity
                </option>
            </select>

            <label for="phone">Phone Number (optional)</label>
            <input
                id="phone"
                name="phone"
                type="tel"
                maxlength="20"
            >

            <button type="submit">Register Student</button>
        </form>
    </section>

    <section>
        <h2>Registered Students</h2>

        <?php if ($students instanceof mysqli_result): ?>
            <?php if ($students->num_rows > 0): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while (
                                $student = $students->fetch_assoc()
                            ): ?>
                                <tr>
                                    <td><?= h($student['id']) ?></td>
                                    <td><?= h($student['name']) ?></td>
                                    <td><?= h($student['email']) ?></td>
                                    <td><?= h($student['course']) ?></td>
                                    <td><?= h($student['phone']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No student records found yet.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Student records are temporarily unavailable.</p>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
<?php
if (isset($students) && $students instanceof mysqli_result) {
    $students->free();
}

if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>