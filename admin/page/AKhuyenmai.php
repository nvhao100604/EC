<?php
require_once("../../db_connect.php");
require_once("../../role_check.php");

$connn = new Database();

$userAuth = new userAuth($connn);
$userAuth->checkReadPermission("CN010");

$isCreate = $userAuth->checkCreatePermission("CN010");
$isUpdate = $userAuth->checkUpdatePermission("CN010");
$isDelete = $userAuth->checkDeletePermission("CN010");

$role = $connn->query("SELECT * FROM quyen");

$connn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Danh sách khuyến mãi</title>

    <link rel="stylesheet" href="../css/phieuxuat.css?version=1.0">
    <link rel="stylesheet" href="../css/chitiethoadon.css?version=1.0">
    <link rel="stylesheet" href="../css/dsnv.css?version=1.0">
    <!-- <link rel="stylesheet" href="style.css?version=1.0"> -->

    <style>

    </style>
</head>

<body>
    <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div class="title">Khuyến mãi</div>
        <div class="btn-ThemNV <?= $isCreate ? "" : "hidden" ?>" onclick="redirectToForm()"> + Thêm khuyến mãi</div>
        <div style="clear: both;"></div>
        <input class="search" type="text" name="txtTimKiem" placeholder="Tìm kiếm...">
        <div><br></div>
        <div style="display: flex; justify-content: center;">
            <div class="table">
                <div class="table-title">
                    <div style="width: 30%; font-weight: bold;">Mã khuyến mãi</div>
                    <div style="width: 30%; font-weight: bold;">Tên khuyến mãi</div>
                    <div style="width: 20%; font-weight: bold;">Mức giảm</div>
                    <div style="width: 20%; font-weight: bold;">Thao tác</div>

                </div>
                <div><br></div>
                <div><br></div>
                <div style="overflow-y: scroll;overflow-x: hidden;">

                    <?php
                    $servername = "localhost";
                    $user = "root";
                    $password = "";
                    $dbname = "bolashop";

                    $conn = new mysqli($servername, $user, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT Magiamgia, tenGiamgia, Mucgiam FROM giamgia";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $textupd = "";
                            $textdel = "";
                            if (!$isUpdate) {
                                $textupd = "hidden";
                            }
                            if (!$isDelete) {
                                $textdel = "hidden";
                            }
                            echo '<div class="table-items">';
                            echo '<div style="width: 30%;">' . $row["Magiamgia"] . '</div>';
                            echo '<div style="width: 30%;">' . $row["tenGiamgia"] . '</div>';
                            echo '<div style="width: 20%;">' . $row["Mucgiam"] . '</div>';
                            echo '<div style="width: 20%;">';
                            echo '<button type="button" class="' . $textupd . '"   style="background-color: white; border: solid 0.5px #D61EAD; color: black;" onclick="window.location.href=\'AHome.php?chon=t&id=khuyenmai&loai=sua&Magiamgia=' . $row["Magiamgia"] . '\'">Sửa</button>';
                            echo '<input type="hidden" name="Magiamgia" value="' . $row["Magiamgia"] . '">';
                            echo '<button type="button" class="delete-btn ' . $textdel . '" onclick="deleteItem(\'' . $row["Magiamgia"] . '\')">Xóa</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "trống!!!";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteItem(maKhuyenMai) {
            console.log('Xóa mã khuyến mãi:', maKhuyenMai); // Kiểm tra giá trị maKhuyenMai
            if (confirm('Bạn có chắc chắn muốn xóa mã khuyến mãi này?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'xulyxoakhuyenmai.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    console.log('Trạng thái:', xhr.status); // Kiểm tra trạng thái HTTP
                    console.log('Phản hồi:', xhr.responseText); // Kiểm tra phản hồi từ PHP
                    if (xhr.status === 200 && xhr.responseText.trim() === 'Xóa thành công') {
                        alert('Xóa mã khuyến mãi thành công!');
                        window.location.href = "AHome.php?chon=t&id=khuyenmai";
                        var element = document.getElementById('item-' + maKhuyenMai);
                        if (element) {
                            element.parentNode.removeChild(element);
                        }
                    } else {
                        alert('Đã xảy ra lỗi khi xóa mã khuyến mãi: ' + xhr.responseText);
                    }
                };
                xhr.onerror = function() {
                    console.error('Đã xảy ra lỗi khi gửi yêu cầu AJAX');
                };
                xhr.send('Magiamgia=' + maKhuyenMai);
            }
        }
    </script>
    <script>
        function redirectToForm() {
            window.location.href = "AHome.php?chon=t&id=khuyenmai&loai=them";
        }
    </script>


</body>

</html>