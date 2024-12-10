<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$database = 'bolashop';

$db = new mysqli($server, $user, $pass, $database);

if ($db->connect_error) {
    die("Kết nối thất bại: " . $db->connect_error);
}

mysqli_query($db, "SET NAMES 'utf8'");

$mathuonghieu = '';
$tenthuonghieu = '';

if (isset($_GET['idth'])) {
    $id = $_GET['idth'];

    $sql = "SELECT * FROM thuonghieu WHERE Mathuonghieu = ?";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $mathuonghieu = $row['Mathuonghieu'];
            $tenthuonghieu = $row['tenThuonghieu'];
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mathuonghieu = $_POST['txtMakh'];
    $tenthuonghieu = $_POST['txtTenkh'];

    $sql_update = "UPDATE thuonghieu SET tenThuonghieu = ? WHERE Mathuonghieu = ?";
    $stmt_update = $db->prepare($sql_update);
    if ($stmt_update) {
        $stmt_update->bind_param('ss', $tenthuonghieu, $mathuonghieu);
        if ($stmt_update->execute()) {
            header('Location: AHome.php?chon=t&id=thuonghieu');
            exit();
        } else {
            echo 'error: ' . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        echo 'error: ' . $db->error;
    }
    $db->close();
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="../css/formthemKM.css?version=1.0" rel="stylesheet" />
    <title>Sửa thương hiệu</title>
</head>

<body>
<h2><a href="AHome.php">Trang chủ >> </a><a href="AHome.php?chon=t&id=thuonghieu">Thương hiệu >> </a>Sửa thương hiệu</h2>
    
<div class="form-km">
        <form class="formkhuyenmai" id="formkhuyenmai" method="post" action="">
            <h3>Sửa thương hiệu</h3>
            <label for="txtMakh">Mã thương hiệu</label>
            <input type="text" name="txtMakh" value="<?php echo $mathuonghieu; ?>" readonly />

            <label for="txtTenkh">Tên thương hiệu</label>
            <input type="text" name="txtTenkh" value="<?php echo $tenthuonghieu; ?>" placeholder="Nhập vào tên thương hiệu..." />

            <div class="group-btn">
                <button type="button" id="delBtn" class="delBtn" onclick="window.location.href='AHome.php?chon=t&id=thuonghieu';">Hủy</button>
                <button type="reset" id="resetBtn" class="resetBtn">Đặt lại</button>
                <button type="submit" id="submitBtn" class="submitBtn">Lưu</button>
            </div>
        </form>
    </div>
</body>

</html>