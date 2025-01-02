<?php
include '../db.php';

header('Content-Type: application/json');

// Menangani request POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Membaca data dari body request
    $data = json_decode(file_get_contents("php://input"), true);

    // Membangun query berdasarkan filter yang ada
    $whereClauses = [];
    if (!empty($data['company_id'])) {
        $whereClauses[] = "company_id = " . $conn->real_escape_string($data['company_id']);
    }
    if (!empty($data['customer_id'])) {
        $whereClauses[] = "customer_id = " . $conn->real_escape_string($data['customer_id']);
    }
    if (!empty($data['company_name'])) {
        $whereClauses[] = "company_name = '" . $conn->real_escape_string($data['company_name']);
    }

    // Menyiapkan query SQL dinamis
    $sql = "SELECT * FROM soal_1";
    if (count($whereClauses) > 0) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    // Mengeksekusi query
    $result = $conn->query($sql);

    // Mengecek apakah ada data yang ditemukan
    if ($result->num_rows > 0) {
        // Menyusun hasil dalam format array
        $dataResult = [];
        while($row = $result->fetch_assoc()) {
            $dataResult[] = $row;
        }

        // Mengembalikan hasil dalam format JSON
        echo json_encode(["status" => "success", "data" => $dataResult]);
    } else {
        echo json_encode(["status" => "error", "message" => "No records found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>