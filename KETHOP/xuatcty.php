<?php include ("myclass/clstmdt.php");
$p= new tmdt();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
    $p ->xuatdscty("select * from congty order by tencty asc")
?>
</body>
</html>


