<?php
include '../utils/import_helper.php';

$route = new Route();

$nim = $_GET[PerkuliahanModel::NIM];
$kode_mk = $_GET[PerkuliahanModel::KODE_MK];

$url = APIConfig::PERKULIAHAN_ENDPOINT . "?nim=" . $nim . "&kode_mk=" . $kode_mk;

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

$res = curl_exec($curl);
$res = json_decode($res, true);

curl_close($curl);

if ($res !== null && isset($res["status"]) && $res["status"] == 1) {
    header("Location: main_index.php");
} else {
    echo "Failed to delete data.";
}

?>