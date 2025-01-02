<?php
include '../db.php';

header('Content-Type: application/json');

// Menangani request POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Membaca data dari body request
    $data = json_decode(file_get_contents("php://input"), true);

    // Membangun query berdasarkan filter yang ada
    $whereClauses = [];
    
    if (!empty($data['company_name'])) {
        $whereClauses[] = "company_name = '" . $conn->real_escape_string($data['company_name']) . "'";
    }
    if (!empty($data['product_id'])) {
        $whereClauses[] = "product_id = " . $conn->real_escape_string($data['product_id']);
    }
    if (!empty($data['product_name'])) {
        $whereClauses[] = "product_name = '" . $conn->real_escape_string($data['product_name']) . "'";
    }
    if (!empty($data['amount'])) {
        $whereClauses[] = "amount = " . $conn->real_escape_string($data['amount']);
    }
    if (!empty($data['count'])) {
        $whereClauses[] = "count = " . $conn->real_escape_string($data['count']);
    }
    if (!empty($data['tax_value'])) {
        $whereClauses[] = "tax_value = " . $conn->real_escape_string($data['tax_value']);
    }
    if (!empty($data['service_fee_percentage'])) {
        $whereClauses[] = "service_fee_percentage = " . $conn->real_escape_string($data['service_fee_percentage']);
    }
    if (!empty($data['service_fee'])) {
        $whereClauses[] = "service_fee = " . $conn->real_escape_string($data['service_fee']);
    }
    if (!empty($data['last_trx_on'])) {
        $whereClauses[] = "last_trx_on = '" . $conn->real_escape_string($data['last_trx_on']) . "'";
    }
    if (!empty($data['id_last_trx'])) {
        $whereClauses[] = "id_last_trx = " . $conn->real_escape_string($data['id_last_trx']);
    }
    if (!empty($data['first_trx_on'])) {
        $whereClauses[] = "first_trx_on = '" . $conn->real_escape_string($data['first_trx_on']) . "'";
    }
    if (!empty($data['id_first_trx'])) {
        $whereClauses[] = "id_first_trx = " . $conn->real_escape_string($data['id_first_trx']);
    }

    // Menyiapkan query SQL dinamis
    $sql = "SELECT * FROM soal_2";
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
