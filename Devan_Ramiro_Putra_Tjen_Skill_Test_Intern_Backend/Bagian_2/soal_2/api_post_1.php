<?php
include ('../db.php');

$inputData = json_decode(file_get_contents("php://input"), true);

// Validasi data yang diterima
if (isset($inputData['product_name']) && isset($inputData['service_fee']) && isset($inputData['service_fee_percentage'])) {
    $product_name = $inputData['product_name'];
    $service_fee = $inputData['service_fee'];
    $service_fee_percentage = $inputData['service_fee_percentage'];

    // Query untuk insert data produk ke tabel
    $sql = "INSERT INTO `product` (`product_name`, `service_fee`, `service_fee_percentage`) 
            VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("sdi", $product_name, $service_fee, $service_fee_percentage);
        
        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil
            echo json_encode(['status' => 'success', 'message' => 'Product added successfully.']);
        } else {
            // Jika gagal
            echo json_encode(['status' => 'error', 'message' => 'Error executing query.']);
        }
        
        // Tutup statement
        $stmt->close();
    } else {
        // Jika query gagal disiapkan
        echo json_encode(['status' => 'error', 'message' => 'Error preparing the query.']);
    }
} else {
    // Jika data tidak lengkap
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
}

$conn->close();
?>
