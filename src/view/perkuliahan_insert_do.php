<?php
include '../utils/import_helper.php';

if (isset($_POST['submit'])) {
    $route = new Route();

    $nim = $_POST['nim'];
    $kode_mk = $_POST['kode_mk'];
    $nilai = $_POST['nilai'];

    $data = array(
        'nim' => $nim,
        'kode_mk' => $kode_mk,
        'nilai' => $nilai
    );

    $url = APIConfig::PERKULIAHAN_ENDPOINT;
    
    $jsonData = json_encode($data, true);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $res = curl_exec($curl);
    
    var_dump($res);

    if ($res === false) {
        echo "API request failed: " . curl_error($curl);
    } else {
        $json = json_decode($res, true);
        var_dump($json);
        curl_close($curl);

        if ($json !== null && isset($json["status"]) && $json["status"] == 1) {
            header("Location: main_index.php");
        } else {
            echo "Failed to insert data.";
            var_dump($json);
        }
    }
} else {
    echo "No data submitted.";
}
?>