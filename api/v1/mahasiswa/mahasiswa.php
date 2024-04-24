<?php
include '../../utils/import_helper.php';

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (!empty($_GET[MahasiswaModel::NIM])) {
            $nim = $_GET[MahasiswaModel::NIM];
            $nim = wrapString($nim);
            getMahasiswa($nim);
        } else {
            getAllMahasiswa();
        }
        break;
    case 'POST':
        if (!empty($_GET[MahasiswaModel::NIM])) {
            $nim = $_GET[MahasiswaModel::NIM];
            $nim = wrapString($nim);
            updateMahasiswa($nim);
        } else {
            insertMahasiswa();
        }
        
        break;

    case 'DELETE':
        if (!empty($_GET[MahasiswaModel::NIM])) {
            $nim = $_GET[MahasiswaModel::NIM];
            $nim = wrapString($nim);
            deleteMahasiswa($nim);
        } else {
            failedWithMessage('Failed delete mahasiswa, nim not found');
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

function getMahasiswa($nim) {
    global $mysqli;
    $query = "SELECT * FROM " . MahasiswaModel::TABLE . " WHERE " . MahasiswaModel::NIM . " = " . $nim;
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get mahasiswa by nim [' . $nim . ']',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getAllMahasiswa() {
    global $mysqli;
    $query = "SELECT * FROM " . MahasiswaModel::TABLE;
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get all mahasiswa',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insertMahasiswa() {
    global $mysqli;
    
    $data = (!empty($_POST[MahasiswaModel::NAMA])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $m = new MahasiswaModel();
    if ($m->countAtribute() == count(array_intersect_key($data, $m->getEmptyData()))) {
        
        $result = mysqli_query($mysqli, "INSERT INTO " . MahasiswaModel::TABLE . " SET
            " . MahasiswaModel::NIM . " = '" . $data[MahasiswaModel::NIM] . "',
            " . MahasiswaModel::NAMA . " = '" . $data[MahasiswaModel::NAMA] . "',
            " . MahasiswaModel::ALAMAT . " = '" . $data[MahasiswaModel::ALAMAT] . "',
            " . MahasiswaModel::TANGGAL_LAHIR . " = '" . $data[MahasiswaModel::TANGGAL_LAHIR] . "'"
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success insert new mahasiswa',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed insert new mahasiswa',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed insert new mahasiswa, data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
}


function updateMahasiswa($nim) {
    global $mysqli;

    $data = (!empty($_POST[MahasiswaModel::NAMA])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $m = new MahasiswaModel();
    if ($m->countAtribute() == count(array_intersect_key($data, $m->getEmptyData()))) {
        
        $result = mysqli_query($mysqli, "UPDATE " . MahasiswaModel::TABLE . " SET
            " . MahasiswaModel::NAMA . " = '" . $data[MahasiswaModel::NAMA] . "',
            " . MahasiswaModel::ALAMAT . " = '" . $data[MahasiswaModel::ALAMAT] . "',
            " . MahasiswaModel::TANGGAL_LAHIR . " = '" . $data[MahasiswaModel::TANGGAL_LAHIR] . "'
            WHERE " . MahasiswaModel::NIM . " = " . $nim);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success update mahasiswa by nim [' . $nim . ']',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed update mahasiswa by nim [' . $nim . ']',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed update mahasiswa by nim [' . $nim . '], data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
}

function deleteMahasiswa($nim) {
    global $mysqli;
    $result = mysqli_query($mysqli, "DELETE FROM " . MahasiswaModel::TABLE . " WHERE " . MahasiswaModel::NIM . " = " . $nim);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Success delete cars by nim [' . $nim . ']',
            'data' => array()
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed delete cars by nim [' . $nim . ']',
            'data' => array()
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>