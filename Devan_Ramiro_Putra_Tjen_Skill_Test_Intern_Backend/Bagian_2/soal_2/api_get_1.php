<?php
include '../db.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM customer";

// Array untuk menampung parameter query
$params = [];
$types = "";

// Check for dynamic query parameters
$conditions = [];
if (isset($_GET['id'])) {
    $conditions[] = "id = ?";
    $params[] = $_GET['id'];
    $types .= "i"; // Integer for id
}
if (isset($_GET['first_name'])) {
    $conditions[] = "first_name LIKE ?";
    $params[] = "%" . $_GET['first_name'] . "%";
    $types .= "s"; // String for first_name
}
if (isset($_GET['last_name'])) {
    $conditions[] = "last_name LIKE ?";
    $params[] = "%" . $_GET['last_name'] . "%";
    $types .= "s"; // String for last_name
}
if (isset($_GET['birth_date'])) {
    $conditions[] = "birth_date = ?";
    $params[] = $_GET['birth_date'];
    $types .= "s"; // String for birth_date
}
if (isset($_GET['email'])) {
    $conditions[] = "email LIKE ?";
    $params[] = "%" . $_GET['email'] . "%";
    $types .= "s"; // String for email
}
if (isset($_GET['phone_number'])) {
    $conditions[] = "phone_number LIKE ?";
    $params[] = "%" . $_GET['phone_number'] . "%";
    $types .= "s"; // String for phone_number
}
if (isset($_GET['address'])) {
    $conditions[] = "address LIKE ?";
    $params[] = "%" . $_GET['address'] . "%";
    $types .= "s"; // String for address
}
if (isset($_GET['gender'])) {
    $conditions[] = "gender LIKE ?";
    $params[] = "%" . $_GET['gender'] . "%";
    $types .= "s"; // String for gender
}
if (isset($_GET['company'])) {
    $conditions[] = "company = ?";
    $params[] = $_GET['company'];
    $types .= "i"; // Integer for company
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

try {
    if (count($params) > 0) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // If no parameters were given, return all customers
        $result = $conn->query($sql);
    }

    // Fetch data and prepare JSON response
    $customers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $customers
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
