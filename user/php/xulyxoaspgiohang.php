<?php
session_start();
$maKH = $_SESSION['user_id'];

// Kết nối đến cơ sở dữ liệu
$server ='localhost';
$user ='root';
$pass = '';
$database = 'bolashop';

$db = new mysqli($server, $user, $pass,$database);

if($db)
{
    mysqli_query($db,"SET NAMES 'utf8' ");
}
else
{
    echo 'ket noi that bai';
}

// Lấy id từ yêu cầu POST
if(isset($_POST['id'])) {
    $idsp = $_POST['id'];
    
    // Xóa dòng dữ liệu từ bảng giohang
    $sql = "DELETE FROM giohang WHERE Manguoidung = '$maKH' AND Masp = '$idsp'";

    if ($db->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Lỗi: " . $db->error;
    } 
}

// Đóng kết nối với cơ sở dữ liệu
$db->close();

?>
