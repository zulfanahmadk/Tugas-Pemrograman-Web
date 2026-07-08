<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = $_GET['action'] ?? '';

if ($action == 'read') {
    $query = "SELECT jp.idjp, jp.nip, p.namalengkap, jp.kodejabatan, j.namajabatan, jp.status, jp.periode 
              FROM jabatanpegawai jp 
              LEFT JOIN pegawai p ON jp.nip = p.nip 
              LEFT JOIN jabatan j ON jp.kodejabatan = j.kodejabatan";
    $result = $conn->query($query);
    $data = [];
    if($result) {
        while($row = $result->fetch_assoc()){ $data[] = $row; }
    }
    echo json_encode($data);
}
elseif ($action == 'create') {
    $nip = $_POST['nip'];
    $kode = $_POST['kodejabatan'];
    $status = $_POST['status'];
    $periode = $_POST['periode'];
    
    $stmt = $conn->prepare("INSERT INTO jabatanpegawai (nip, kodejabatan, status, periode) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nip, $kode, $status, $periode);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
elseif ($action == 'update') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        parse_str(file_get_contents("php://input"), $data);
    }
    
    $idjp = $data['idjp'];
    $nip = $data['nip'];
    $kode = $data['kodejabatan'];
    $status = $data['status'];
    $periode = $data['periode'];
    
    $stmt = $conn->prepare("UPDATE jabatanpegawai SET nip=?, kodejabatan=?, status=?, periode=? WHERE idjp=?");
    $stmt->bind_param("ssssi", $nip, $kode, $status, $periode, $idjp);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
elseif ($action == 'delete') {
    $idjp = $_GET['idjp'];
    $stmt = $conn->prepare("DELETE FROM jabatanpegawai WHERE idjp=?");
    $stmt->bind_param("i", $idjp);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
?>
