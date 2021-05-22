<?php
include_once("koneksi.php");
$db = new koneksiDB();
$koneksi = $db->getkoneksi();
$request = $_SERVER['REQUEST_METHOD'];
switch($request){
    case 'GET' :
        if(empty($_REQUEST['nim'])){
            get_mahasiswa();
        }else{
            $nim = $_REQUEST['nim'];
            get_mahasiswa($nim);
        }
        break;
    case 'POST' :
        insert_mahasiswa();
        break;
    
    case 'PUT' :
        $nim = $_REQUEST['nim'];
        update_mahasiswa($nim);
        break;
    case 'DELETE' :
        $nim = $_REQUEST['nim'];
        delete_mahasiswa($nim);
        break;
    default :
    header("HTTP/1.0 405 Method Tidak Terdaftar");
    break;
}

function get_mahasiswa($nim=""){
    global $koneksi;
    if(!empty($nim)){
            $query ="SELECT * FROM mahasiswa WHERE nim='$nim'";
    }else {
        $query= "SELECT * FROM mahasiswa ";
    }
    $respon = array();
    $result = mysqli_query($koneksi, $query);
    $i = 1;
    if ($result){
        $respon['kode'] = 1;
        $respon['status'] = "sukses";
        while($row=mysqli_fetch_array($result)){
            $respon['data'][$i]['NIM'] = $row['nim'];
            $respon['data'][$i]['Nama'] = $row['nama'];
            $respon['data'][$i]['angkatan'] = $row['angkatan'];
            $respon['data'][$i]['semester'] = $row['semester'];
            $respon['data'][$i]['IPK'] = $row['ipk'];
            $i ++;
        }
    }else {
        $respon['kode']=0;
        $respon['status']='gagal';

    }
    header('Content-Type: application/json');
    echo json_encode($respon);
}
function insert_mahasiswa(){
    global $koneksi;
    $data = json_decode(file_get_contents("php://input"), true);
    $nim = $data['nim'];
    $nama = $data['nama'];
    $angkatan = $data['angkatan'];
    $semester = $data['semester'];
    $ipk = $data['ipk']; 
    $query = "INSERT INTO mahasiswa set nim='$nim', nama='$nama', angkatan='$angkatan', semester='$semester', ipk='$ipk' ";

    if(mysqli_query($koneksi, $query)){
        $respon = [
            'kode' => 1,
            'status' => 'Data mahasiswa berhasil ditambah'
        ];
    } else {
        $respon = [
            'kode' => 0,
            'status' => 'Data mahasiswa gagal ditambah'
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($respon);

}

function update_mahasiswa($nim){
    global $koneksi;
    $data = json_decode(file_get_contents("php://input"), true);
    $nama = $data['nama'];
    $angkatan = $data['angkatan'];
    $semester = $data['semester'];
    $ipk = $data['ipk']; 
    $query = "UPDATE mahasiswa set nim='$nim', nama='$nama', angkatan='$angkatan', semester='$semester', ipk='$ipk' WHERE nim='$nim' ";

    if(mysqli_query($koneksi, $query)){
        $respon = [
            'kode' => 1,
            'status' => 'Data mahasiswa berhasil diupdate'
        ];
    } else {
        $respon = [
            'kode' => 0,
            'status' => 'Data mahasiswa gagal diupdate'
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($respon);
}
function delete_mahasiswa($nim){
    global $koneksi;
    $query ="DELETE FROM mahasiswa WHERE nim='$nim'";
    if(mysqli_query($koneksi, $query)){
        $respon = [
            'kode' => 1,
            'status' => 'Data mahasiswa berhasil dihapus'
        ];
    } else {
        $respon = [
            'kode' => 0,
            'status' => 'Data mahasiswa gagal dihapus'
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($respon);
    
}

?>
