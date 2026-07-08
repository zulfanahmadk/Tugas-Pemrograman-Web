<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = $_GET['action'] ?? '';

if ($action == 'read') {
    $result = $conn->query("SELECT * FROM jabatan");
    $data = [];
    while($row = $result->fetch_assoc()){ $data[] = $row; }
    echo json_encode($data);
}
elseif ($action == 'create') {
    $kode = $_POST['kodejabatan'];
    $nama = $_POST['namajabatan'];
    $level = $_POST['level'];
    $gaji = $_POST['gaji'];
    
    $stmt = $conn->prepare("INSERT INTO jabatan VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $kode, $nama, $level, $gaji);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
elseif ($action == 'update') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        parse_str(file_get_contents("php://input"), $data);
    }
    
    $kode = $data['kodejabatan'];
    $nama = $data['namajabatan'];
    $level = $data['level'];
    $gaji = $data['gaji'];
    
    $stmt = $conn->prepare("UPDATE jabatan SET namajabatan=?, level=?, gaji=? WHERE kodejabatan=?");
    $stmt->bind_param("ssis", $nama, $level, $gaji, $kode);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
elseif ($action == 'delete') {
    $kode = $_GET['kode'];
    $stmt = $conn->prepare("DELETE FROM jabatan WHERE kodejabatan=?");
    $stmt->bind_param("s", $kode);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
?>
