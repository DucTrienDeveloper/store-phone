<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "mobile", "3307") or die();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM billday WHERE status = 2";
if (isset($_SESSION['USER_NAME'])) {
    $Username = $_SESSION['USER_NAME'];
    echo $Username;
}
if(isset($_POST['input'])){
    $a = $_POST['input'];
    class sanpham
        {
            public $ten;
            public $gia;
            public $img;
        }
        $sanphams = array();
        $keyword = array();
    $query = "SELECT * FROM `sanpham` INNER JOIN searchproduct ON sanpham.idsp = searchproduct.productid INNER JOIN search ON searchproduct.searchid = search.id WHERE search.keyword LIKE '%$a%' OR sanpham.tensp LIKE '%$a%' GROUP BY idsp;";
    $result = mysqli_query($conn,$query);
    
        if (!$result) {
            die("Query Failed.");
        }
        if($nums = mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result)){
            $sanpham = new sanpham();
            $sanpham->ten = $row['tensp'];
            $sanpham->gia = $row['gia'];
            $sanpham->img = $row['img'];
            $sanphams[] = $sanpham;
        }
    }
    
        // mysqli_close($connection);
        // echo json_encode($sanphams);
        $query1 = "SELECT keyword FROM `search` WHERE keyword LIKE '%$a%'";
        $result1 = mysqli_query($conn,$query1); 
        if($num = mysqli_num_rows($result1)>0){
            while($rows = mysqli_fetch_array($result1)){
                 $keyword[] = $rows['keyword'];
            }
        }
       $end = array("sanpham" =>$sanphams ,"key" =>$keyword);
        echo json_encode($end); 
    
}          
//     if(mysqli_num_rows($result) > 0){
//         echo $a;
//     }else{
//         echo "khong có sản phẩm";
//     }
// }else{
//     echo "không nhận được data";
// }

?>