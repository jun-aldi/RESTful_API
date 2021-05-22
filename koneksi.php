<?php
class koneksiDB{
    function getkoneksi(){
        $host = "localhost";
        $username = "root";
        $pass = "";
        $db = "universitas";
        $konek = mysqli_connect($host, $username, $pass, $db)
                or die("koneksi gagal ".mysqli_connect_error());

        if(mysqli_connect_error()){
            exit();
        }
        return $konek;
    }
}
?>