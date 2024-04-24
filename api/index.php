<?php
require_once 'db_config.php';
include_once 'model/model_classes.php';

$request_method = $_SERVER["REQUEST_METHOD"];
if ($request_method == "GET") {
    getAllDataPerkuliahan();
} else {
    failedWithMessage('Failed get data perkuliahan. Unknown request method');
}

function failedWithMessage($message) {
    $response = array(
        'status' => 0,
        'message' => $message,
        'data' => array()
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getAllDataPerkuliahan() {
    global $mysqli;
    $query = "
        SELECT m.nim, m.nama, m.alamat, m.tanggal_lahir, mk.kode_mk, mk.nama_mk, mk.sks, p.nilai
        FROM perkuliahan as p
        JOIN mahasiswa as m ON p.nim = m.nim
        JOIN matakuliah as mk ON p.kode_mk = mk.kode_mk;
    ";
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get all data perkuliahan',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>