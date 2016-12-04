<?php
/**
 * Created by PhpStorm.
 * User: Sean
 * Date: 03/12/2016
 * Time: 22:42
 */

//perform connection
$con=mysqli_connect("localhost","root","","students");

//check if connection is successful
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo "Success <br>";

//execute the SQL query and return records
$result = mysqli_query($con,"SELECT * FROM registration");

//fetch the data from the database
while ($row = mysqli_fetch_array($result)) {
    echo "ID:".$row{'id'}." Name:".$row{'first'}." 
   ".$row{'last'}." Age:".$row{'age'}."<br>";
}
//get max id in table
$getMax = mysqli_query($con,"SELECT MAX(id) FROM registration");
$row = mysqli_fetch_row($getMax);
$max = $row[0];

//loop inserting values into database
for ($x = 0; $x <= 10; $x++) {
    $max++;
    $sql = "INSERT INTO registration (id,first, last, age)
VALUES ($max,'Alex', 'Sui Cen', 23)";


    if ($con->query($sql) === TRUE) {
        echo "New record created successfully <br>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

}

$sql2 =mysqli_query($con, "DELETE FROM registration WHERE first = 'Zaid'");

if ($con->query($sql2) === TRUE) {
    echo "Deleted records <br>";
} else {
    echo "Error: " . $sql2 . "<br>" . $con->error;
}


$con->close();
