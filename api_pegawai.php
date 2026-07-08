<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = $_GET['action'] ?? '';

if ($action == 'read') {
    $result = $conn->query("SELECT * FROM pegawai");
    $data = [];
    while($row = $result->fetch_assoc()){ $data[] = $row; }
    echo json_encode($data);
}
elseif ($action == 'create') {
    $nip = $_POST['nip'];
    $nama = $_POST['namalengkap'];
    $jk = $_POST['jeniskelamin'];
    $tgl = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("INSERT INTO pegawai VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nip, $nama, $jk, $tgl, $alamat, $nohp, $email);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
elseif ($action == 'update') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        parse_str(file_get_contents("php://input"), $data);
    }
    
    $nip = $data['nip'];
    $nama = $data['namalengkap'];
    $jk = $data['jeniskelamin'];
    $tgl = $data['tanggallahir'];
    $alamat = $data['alamat'];
    $nohp = $data['nohp'];
    $email = $data['email'];
    
    $stmt = $conn->prepare("UPDATE pegawai SET namalengkap=?, jeniskelamin=?, tanggallahir=?, alamat=?, nohp=?, email=? WHERE nip=?");
    $stmt->bind_param("sssssss", $nama, $jk, $tgl, $alamat, $nohp, $email, $nip);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
elseif ($action == 'delete') {
    $nip = $_GET['nip'];
    $stmt = $conn->prepare("DELETE FROM pegawai WHERE nip=?");
    $stmt->bind_param("s", $nip);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else echo json_encode(["status"=>"error", "message"=>$conn->error]);
}
?>
