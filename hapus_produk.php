<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: dashboard.php'); 
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT gambar FROM produk WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: dashboard.php');
    exit;
}

$produk = $result->fetch_assoc();

if (!empty($produk['gambar']) && file_exists('img/' . $produk['gambar'])) {
    unlink('img/' . $produk['gambar']);
}

$sqlDelete = "DELETE FROM produk WHERE id = ?";
$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);
$stmtDelete->execute();

header('Location: dashboard.php');
exit;
?>
