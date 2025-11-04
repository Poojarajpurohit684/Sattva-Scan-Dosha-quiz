<?php
include 'config.php';

$name = $email = $birthdate = $gender = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty($_POST["name"])) {
        $errors[] = "Name is required";
    } else {
        $name = trim($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors[] = "Only letters and spaces allowed in name";
        }
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $errors[] = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }

    // Validate Birthdate
    if (empty($_POST["birthdate"])) {
        $errors[] = "Birthdate is required";
    } else {
        $birthdate = $_POST["birthdate"];
    }

    // Validate Gender
    if (empty($_POST["gender"])) {
        $errors[] = "Gender is required";
    } else {
        $gender = $_POST["gender"];
    }

    // If no errors, insert into DB
    if (count($errors) == 0) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, birthdate, gender) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $birthdate, $gender);

        if ($stmt->execute()) {
            // Redirect to home.html after success
            header("Location: home.html?success=1");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Validation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f4f4f9;
            padding:20px;
        }
        .form-container {
            background:#fff;
            padding:30px;
            border-radius:12px;
            width:380px;
            margin:auto;
            margin-top:50px;
            box-shadow:0px 6px 18px rgba(0,0,0,0.1);
        }
        h2 {
            text-align:center;
            margin-bottom:20px;
            color:#333;
        }
        label {
            font-weight:bold;
            color:#444;
        }
        input, select {
            width:100%;
            padding:10px;
            margin:8px 0 18px 0;
            border:1px solid #ccc;
            border-radius:6px;
            transition:0.3s;
        }
        input:focus, select:focus {
            border-color:#28a745;
            outline:none;
            box-shadow:0 0 6px rgba(40,167,69,0.3);
        }
        button {
            background:#28a745;
            color:white;
            padding:12px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            width:100%;
            font-size:16px;
            font-weight:bold;
            transition:0.3s;
        }
        button:hover {
            background:#218838;
            transform:scale(1.02);
        }
        .error {
            color:red;
            background:#ffe6e6;
            padding:10px;
            border-radius:6px;
            margin-bottom:15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registration Form</h2>
        <?php 
        if (!empty($errors)) {
            echo "<div class='error'><ul>";
            foreach ($errors as $e) {
                echo "<li>$e</li>";
            }
            echo "</ul></div>";
        }
        ?>
        <form method="POST" action="">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">

            <label>Birthdate:</label>
            <input type="date" name="birthdate" value="<?= htmlspecialchars($birthdate) ?>">

            <label>Gender:</label>
            <select name="gender">
                <option value="">--Select--</option>
                <option value="Male" <?= $gender=='Male'?'selected':'' ?>>Male</option>
                <option value="Female" <?= $gender=='Female'?'selected':'' ?>>Female</option>
                <option value="Other" <?= $gender=='Other'?'selected':'' ?>>Other</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
