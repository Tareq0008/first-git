<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Employee</title>
</head>
<body>
    <center> 
    <?php
        // 1. Establish the connection once at the top
        $mycon = mysqli_connect("localhost", "root", "", "basic");

        // 2. HANDLE DELETION: Check if the Delete button was submitted
        if (isset($_POST['deleteBtn'])) {
            $delete_id = $_POST['id_to_delete'];
            
            // Use prepared statements for secure deletion
            $sql = "DELETE FROM employee WHERE id = ?";
            $prepare = $mycon->prepare($sql);
            $prepare->bind_param("i", $delete_id); // "i" stands for integer
            
            if ($prepare->execute()) {
                echo "<h3 style='color: green;'>Employee ID ".htmlspecialchars($delete_id)." successfully deleted.</h3>";
            } else {
                echo "<h3 style='color: red;'>Error deleting employee.</h3>";
            }
            $prepare->close();
        }
 
        // 3. HANDLE FETCHING: Check if a search ID was provided
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $id = $_POST['search'];

            // Use prepared statements for secure searching
            $sql = "SELECT * FROM Employee WHERE id = ?";
            $stmt = $mycon->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $record = $stmt->get_result();
            $n = mysqli_num_rows($record);

            if ($n > 0) {   
                echo "<table border='1'>";
                echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Salary</th>
                    <th>Department</th>
                </tr>";
                
                while ($row = mysqli_fetch_row($record)) {
                    echo "<tr>";
                    echo "<td>".$row[0]."</td>";
                    echo "<td>".$row[1]."</td>";
                    echo "<td>".$row[2]."</td>";
                    echo "<td>".$row[3]."</td>";
                    echo "</tr>";
                }
                echo "</table><br>";

                // 4. THE FIX: The proper way to create a Delete button
                // We wrap it in a form that submits back to this same page.
                echo "<form action='fetch.php' method='post'>";
                // Hidden input holds the ID so the user doesn't see it, but PHP receives it
                echo "<input type='hidden' name='id_to_delete' value='".$id."'>";
                echo "<button type='submit' name='deleteBtn'>Delete This Employee</button>";
                echo "</form>";

            } else if (!isset($_POST['deleteBtn'])) {
                // Only show "not found" if we didn't just delete them
                echo "<h3>No employee found with that ID.</h3>";
            }
            $stmt->close();
        }
    ?>
    <br><br>
    <a href="delete.html">Go Back to Search</a>
    </center>
</body>
</html>