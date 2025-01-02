<?php
include '../db.php'; // Pastikan file ini mengarah ke file koneksi Anda

header('Content-Type: application/json');

$customer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($customer_id <= 0) {
    http_response_code(400); 
    echo json_encode(["message" => "Invalid customer ID"]);
    exit();
}

try {
    // Query untuk mengambil detail pelanggan
    $customer_query = "SELECT id, first_name, last_name, email FROM customer WHERE id = ?";
    $stmt = $conn->prepare($customer_query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $customer_result = $stmt->get_result();
    $customer = $customer_result->fetch_assoc();

    if (!$customer) {
        // Jika pelanggan tidak ditemukan
        http_response_code(404); // Not Found
        echo json_encode(["message" => "Customer not found"]);
        exit();
    }

    // Query untuk mengambil transaksi pelanggan
    $transaction_query = "
        SELECT 
            t.id, 
            t.transaction_type, 
            t.amount, 
            t.transaction_datetime, 
            t.payment_status,
            p.id AS product_id,
            p.product_name,
            p.service_fee
        FROM transaction t
        LEFT JOIN product p ON t.product_id = p.id
        WHERE t.customer_id = ?
    ";
    $stmt = $conn->prepare($transaction_query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $transaction_result = $stmt->get_result();

    // Mengumpulkan data transaksi
    $transaction = [];
    while ($row = $transaction_result->fetch_assoc()) {
        $transaction[] = $row;
    }

    // Format respons
    $response = [
        "customer" => $customer,
        "transaction" => $transaction
    ];

    // Berikan respons dalam format JSON
    http_response_code(200); // OK
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["message" => "Error retrieving data", "error" => $e->getMessage()]);
}
?>
