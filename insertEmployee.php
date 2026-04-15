<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert</title>
</head>
<body>
    <center>  
    <form action="insertEmployee.php" method="post">
        id: <input type="text" name="id"><br>
        name: <input type="text" name="name"><br>
        salary: <input type="text" name="salary"><br>
        department: <input type="text" name="department"><br>
        <input type="submit" value="submit" name="btnSubmit">
    </form>
    <?php
        if(isset($_POST['btnSubmit'])){
            $id = $_POST['id'];
            $empName = $_POST['name'];
            $salary = $_POST['salary'];
            $dept = $_POST['department'];

            $mycon = mysqli_connect("localhost","root","","basic");
            echo"connected to database";

            $sql = "insert into employee values(?,?,?,?)";
            $prepar = $mycon->prepare($sql);
            $prepar->bind_param("isis",$id,$empName,$salary,$dept);
            $prepar->execute();
            echo"<br>data inserted successfully";
        }
    ?>
    </center>
</body>
</html>