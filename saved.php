<?php
$server   = "localhost";
$username = "root";
$password = "";
$dbname   = "student_db";

// Connect to database
$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// File upload function
function uploadFile($fileInput, $uploadDir) {
    if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] != 0) {
        return "";
    }
    $fileName = basename($_FILES[$fileInput]['name']);
    $targetPath = $uploadDir . uniqid() . "_" . $fileName;
    if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetPath)) {
        return $targetPath;
    } else {
        return "";
    }
}

// Handle form submission
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname     = $_POST['First_name'] ?? '';
    $mname     = $_POST['Middle_name'] ?? '';
    $lname     = $_POST['Last_name'] ?? '';
    $dob       = $_POST['Date_of_Birth'] ?? '';
    $Gender    = $_POST['Gender'] ?? '';
    $str       = $_POST['Stream'] ?? '';
    $mobile    = $_POST['Mobile'] ?? '';
    $email     = $_POST['Email'] ?? '';
    $pob       = $_POST['Place_of_Birth'] ?? '';
    $blood     = $_POST['Blood'] ?? '';
    $tounge    = $_POST['Mother_tounge'] ?? '';
    $religion  = $_POST['Religion'] ?? '';
    $caste_cat = $_POST['Caste_category'] ?? '';
    $caste     = $_POST['Caste'] ?? '';
    $state     = $_POST['State'] ?? '';

    // Upload files
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $photo   = uploadFile("Photo", $uploadDir);
    $aadhaar = uploadFile("Aadhaar", $uploadDir);
    $marks   = uploadFile("Marks", $uploadDir);

    // Insert query...

    // Upload files
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $photo   = uploadFile("Photo", $uploadDir);
    $aadhaar = uploadFile("Aadhaar", $uploadDir);
    $marks   = uploadFile("Marks", $uploadDir);

    // Insert new record
    $sql = "INSERT INTO students (`First_name`, `Middle_name`, `Last_name`, `Date_of_Birth`, `Gender`, `Stream`, `Mobile`, `Email`, 
    `Place_of_Birth`, `Blood`, `Mother_tounge`, `Religion`, `Caste_category`, `Caste`, `State`, `Photo`, `Aadhaar`, `Marks`)
    VALUES ('$fname','$mname','$lname','$dob','$Gender','$str','$mobile','$email',
    '$pob','$blood','$tounge','$religion','$caste_cat','$caste','$state','$photo','$aadhaar','$marks')";


    if (mysqli_query($con, $sql)) {
        echo "<p style='color:green;'>✅ New student inserted successfully.</p>";
    } else {
        echo "<p style='color:red;'>❌ Insert failed: " . mysqli_error($con) . "</p>";
    }
}
// Fetch all data
$sql = "SELECT * FROM students";
$result = mysqli_query($con, $sql);

echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%; text-align:center;'>
    <tr>
        <th>First name</th>
        <th>Middle name</th>
        <th>Last name</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Stream</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Place of Birth</th>
        <th>Blood</th>
        <th>Mother_tounge</th>
        <th>Religion</th>
        <th>Caste category</th>
        <th>Caste</th>
        <th>State</th>
        <th>Photo</th>
        <th>Aadhaar</th>
        <th>Marks</th>
    </tr>";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$row['First_name']."</td>
                <td>".$row['Middle_name']."</td>
                <td>".$row['Last_name']."</td>
                <td>".$row['Date_of_Birth']."</td>
                <td>".$row['Gender']."</td>
                <td>".$row['Stream']."</td>
                <td>".$row['Mobile']."</td>
                <td>".$row['Email']."</td>
                <td>".$row['Place_of_Birth']."</td>
                <td>".$row['Blood']."</td>
                <td>".$row['Mother_tounge']."</td>
                <td>".$row['Religion']."</td>
                <td>".$row['Caste_category']."</td>
                <td>".$row['Caste']."</td>
                <td>".$row['State']."</td>
                <td>".($row['Photo'] ? "<a href='".$row['Photo']."' target='_blank'>View</a>" : "")."</td>
                <td>".($row['Aadhaar'] ? "<a href='".$row['Aadhaar']."' target='_blank'>View</a>" : "")."</td>
                <td>".($row['Marks'] ? "<a href='".$row['Marks']."' target='_blank'>View</a>" : "")."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='18'>No records found.</td></tr>";
}
echo "</table>";

mysqli_close($con);
?>
