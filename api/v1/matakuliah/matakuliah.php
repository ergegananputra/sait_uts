<?php
include '../../utils/import_helper.php';


$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (!empty($_GET[MatakuliahModel::KODE_MK])) {
            $kode_mk = wrapString($_GET[MatakuliahModel::KODE_MK]);
            getMatakuliah($kode_mk);
        } else {
            getAllMatakuliah();
        }
        break;
    case 'POST':
        if (!empty($_GET[MatakuliahModel::KODE_MK])) {
            $kode_mk = wrapString($_GET[MatakuliahModel::KODE_MK]);
            updateMatakuliah($kode_mk);
        } else {
            insertMatakuliah();
        }
        
        break;

    case 'DELETE':
        if (!empty($_GET[MatakuliahModel::KODE_MK])) {
            $kode_mk = wrapString($_GET[MatakuliahModel::KODE_MK]);
            deleteMatakuliah($kode_mk);
        } else {
            failedWithMessage('Failed delete cars, kode_mk not found');
        }
        break;
    
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
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

function getMatakuliah($kode_mk) {
    global $mysqli;
    $query = "SELECT * FROM " . MatakuliahModel::TABLE . " WHERE " . MatakuliahModel::KODE_MK . " = " . $kode_mk;
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get cars by kode_mk [' . $kode_mk . ']',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getAllMatakuliah() {
    global $mysqli;
    $query = "SELECT * FROM " . MatakuliahModel::TABLE;
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get all cars',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insertMatakuliah() {
    global $mysqli;
    
    $data = (!empty($_POST[MatakuliahModel::NAMA_MK])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $m = new MatakuliahModel();
    if ($m->countAtribute() == count(array_intersect_key($data, $m->getEmptyData()))) {
        
        $result = mysqli_query($mysqli, "INSERT INTO " . MatakuliahModel::TABLE . " SET
            " . MatakuliahModel::NAMA_MK . " = '" . $data[MatakuliahModel::NAMA_MK] . "',
            " . MatakuliahModel::SKS . " = '" . $data[MatakuliahModel::SKS] . "'");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success insert new cars',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed insert new cars',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed insert new cars, data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
}


function updateMatakuliah($kode_mk) {
    global $mysqli;

    $data = (!empty($_POST[MatakuliahModel::NAMA_MK])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $m = new MatakuliahModel();
    if ($m->countAtribute() == count(array_intersect_key($data, $m->getEmptyData()))) {
        
        $result = mysqli_query($mysqli, "UPDATE " . MatakuliahModel::TABLE . " SET
            " . MatakuliahModel::NAMA_MK . " = '" . $data[MatakuliahModel::NAMA_MK] . "',
            " . MatakuliahModel::SKS . " = '" . $data[MatakuliahModel::SKS] . "'
            WHERE " . MatakuliahModel::KODE_MK . " = " . $kode_mk);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success update cars by kode_mk [' . $kode_mk . ']',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed update cars by kode_mk [' . $kode_mk . ']',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed update cars by kode_mk [' . $kode_mk . '], data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
}

function deleteMatakuliah($kode_mk) {
    global $mysqli;
    $result = mysqli_query($mysqli, "DELETE FROM " . MatakuliahModel::TABLE . " WHERE " . MatakuliahModel::KODE_MK . " = " . $kode_mk);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Success delete cars by kode_mk [' . $kode_mk . ']',
            'data' => array()
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed delete cars by kode_mk [' . $kode_mk . ']',
            'data' => array()
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>