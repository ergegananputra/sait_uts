<?php
include '../../utils/import_helper.php';

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (!empty($_GET[PerkuliahanModel::ID_PERKULIAHAN])) {
            $id_perkuliahan = intval($_GET[PerkuliahanModel::ID_PERKULIAHAN]);
            getPerkuliahan($id_perkuliahan);
        } else {
            getAllPerkuliahan();
        }
        break;
    case 'POST':
        if (!empty($_GET[PerkuliahanModel::ID_PERKULIAHAN])) {
            $id_perkuliahan = intval($_GET[PerkuliahanModel::ID_PERKULIAHAN]);
            updatePerkuliahan($id_perkuliahan);
        } else if (!empty($_GET[PerkuliahanModel::NIM]) && !empty($_GET[PerkuliahanModel::KODE_MK])) {
            $nim = wrapString($_GET[PerkuliahanModel::NIM]);
            $kode_mk = wrapString($_GET[PerkuliahanModel::KODE_MK]);
            UpdatePerkuliahanByNimKodeMK($nim, $kode_mk);

        }else {
            insertPerkuliahan();
        }
        
        break;

    case 'DELETE':
        if (!empty($_GET[PerkuliahanModel::ID_PERKULIAHAN])) {
            $id_perkuliahan = intval($_GET[PerkuliahanModel::ID_PERKULIAHAN]);
            deletePerkuliahan($id_perkuliahan);
        } else if (!empty($_GET[PerkuliahanModel::NIM]) && !empty($_GET[PerkuliahanModel::KODE_MK])) {
            $nim = wrapString($_GET[PerkuliahanModel::NIM]);
            $kode_mk = wrapString($_GET[PerkuliahanModel::KODE_MK]);
            deletePerkuliahanByNimAndKodeMK($nim, $kode_mk);
        }  else {
            failedWithMessage('Failed delete perkuliahan, id_perkuliahan not found');
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

function getPerkuliahan($id_perkuliahan) {
    global $mysqli;
    $query = "SELECT * FROM " . PerkuliahanModel::TABLE . " WHERE " . PerkuliahanModel::ID_PERKULIAHAN . " = " . $id_perkuliahan;
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get perkuliahan by id_perkuliahan [' . $id_perkuliahan . ']',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getAllPerkuliahan() {
    global $mysqli;
    $query = "SELECT * FROM " . PerkuliahanModel::TABLE;
    $data = array();
    $result = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success get all perkuliahan',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insertPerkuliahan() {
    global $mysqli;
    
    $data = (!empty($_POST[PerkuliahanModel::NILAI])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $m = new PerkuliahanModel();
    if ($m->countAtribute() == count(array_intersect_key($data, $m->getEmptyData()))) {
        
        $result = mysqli_query($mysqli, "INSERT INTO " . PerkuliahanModel::TABLE . " SET
            " . PerkuliahanModel::NIM . " = '" . $data[PerkuliahanModel::NIM] . "',
            " . PerkuliahanModel::KODE_MK . " = '" . $data[PerkuliahanModel::KODE_MK] . "',
            " . PerkuliahanModel::NILAI . " = '" . $data[PerkuliahanModel::NILAI] . "'"
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success insert new perkuliahan',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed insert new perkuliahan',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed insert new perkuliahan, data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
}

function UpdatePerkuliahanByNimKodeMK($nim, $kode_mk) {
    global $mysqli;

    $data = (!empty($_POST[PerkuliahanModel::NILAI])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $nilai = $data[PerkuliahanModel::NILAI];
    if ($nilai != null) {
        
        $result = mysqli_query($mysqli, "UPDATE " . PerkuliahanModel::TABLE . " SET
            " . PerkuliahanModel::NILAI . " = '" . $data[PerkuliahanModel::NILAI] . "'
            WHERE " . PerkuliahanModel::NIM . " = " . $nim . " AND " . PerkuliahanModel::KODE_MK . " = " . $kode_mk
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success update perkuliahan by nim [' . $nim . '] and kode_mk [' . $kode_mk . ']',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed update perkuliahan by nim [' . $nim . '] and kode_mk [' . $kode_mk . ']',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed update perkuliahan by nim [' . $nim . '] and kode_mk [' . $kode_mk . '], data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function updatePerkuliahan($id_perkuliahan) {
    global $mysqli;

    $data = (!empty($_POST[PerkuliahanModel::NILAI])) ? $_POST : json_decode(file_get_contents('php://input'), true) ;
    
    $m = new PerkuliahanModel();
    if ($m->countAtribute() == count(array_intersect_key($data, $m->getEmptyData()))) {
        
        $result = mysqli_query($mysqli, "UPDATE " . PerkuliahanModel::TABLE . " SET
            " . PerkuliahanModel::NIM . " = '" . $data[PerkuliahanModel::NIM] . "',
            " . PerkuliahanModel::KODE_MK . " = '" . $data[PerkuliahanModel::KODE_MK] . "',
            " . PerkuliahanModel::NILAI . " = '" . $data[PerkuliahanModel::NILAI] . "'
            WHERE " . PerkuliahanModel::ID_PERKULIAHAN . " = " . $id_perkuliahan
        );

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Success update perkuliahan by id_perkuliahan [' . $id_perkuliahan . ']',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Failed update perkuliahan by id_perkuliahan [' . $id_perkuliahan . ']',
                'data' => $data
            );
        }

    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed update perkuliahan by id_perkuliahan [' . $id_perkuliahan . '], data not complete',
            'data' => $data
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
}

function deletePerkuliahanByNimAndKodeMK($nim, $kode_mk) {
    global $mysqli;
    $result = mysqli_query($mysqli, "DELETE FROM " . PerkuliahanModel::TABLE . " WHERE " . PerkuliahanModel::NIM . " = " . $nim . " AND " . PerkuliahanModel::KODE_MK . " = " . $kode_mk);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Success delete perkuliahan by nim [' . $nim . '] and kode_mk [' . $kode_mk . ']',
            'data' => array()
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed delete perkuliahan by nim [' . $nim . '] and kode_mk [' . $kode_mk . ']',
            'data' => array()
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);

}

function deletePerkuliahan($id_perkuliahan) {
    global $mysqli;
    $result = mysqli_query($mysqli, "DELETE FROM " . PerkuliahanModel::TABLE . " WHERE " . PerkuliahanModel::ID_PERKULIAHAN . " = " . $id_perkuliahan);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Success delete perkuliahan by id_perkuliahan [' . $id_perkuliahan . ']',
            'data' => array()
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Failed delete perkuliahan by id_perkuliahan [' . $id_perkuliahan . ']',
            'data' => array()
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>