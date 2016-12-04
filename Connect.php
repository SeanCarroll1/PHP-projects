<?php
/**
 * Created by PhpStorm.
 * User: Sean
 * Date: 03/12/2016
 * Time: 22:42
 */
class Connection
{

    public static function getConnection($host, $username,$password,$dbName)
    {
        //mysqli connection.
        $mysqli=new mysqli($host,$username,$password,$dbName);

        //check if connection is successful
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }else
        {
            echo "Successfully Connected <br>";
        }

        //PDO connection , check if it was successful.
        try{
            $PDO = new pdo( "mysql:host=$host;dbname=$dbName", $username, $password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            //Check if
           // die(json_encode(array('outcome' => true)));
        }
        catch(PDOException $ex){
            die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
        }

        return $mysqli;
    }

    public static function printValues($con,$tableName)
    {

                //execute the SQL query and return records
                $result = mysqli_query($con,"SELECT * FROM $tableName");

                //fetch the data from the database
                while ($row = mysqli_fetch_array($result))
                {
                    echo "ID:".$row{'id'}." Name:".$row{'first'}." 
                            ".$row{'last'}." Age:".$row{'age'}."<br>";
                }


    }

    public static function InsertMultipleValues($mysqli,$firstName,$lastName,$age,$insertCount)
    {
        //get max id in table
        $getMax = mysqli_query($mysqli,"SELECT MAX(id) FROM registration");
        $row = mysqli_fetch_row($getMax);
        $max = $row[0];

        $stmt = $mysqli->prepare("INSERT INTO registration VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssd',$max, $firstName, $lastName, $age);

        //loop inserting values into database
        for ($x = 0; $x <= $insertCount; $x++)
        {
            $max++;

            //will add in values each loop from the variables above
            if ($stmt->execute())
            {
                echo "Successfully entered. Row inserted: $stmt->affected_rows <br>";
            }else
            {
                echo $stmt->error;
            }

        }

        $stmt->close();

    }

    public static function DeleteValues($con,$tableName,$value)
    {
        //Delete variable matching the value passed
        $con->query("DELETE FROM $tableName WHERE first = '$value'");
        printf("Affected rows (DELETE): %d\n", $con->affected_rows);

    }


}

$test=new Connection();
$con=$test->getConnection("localhost","root","","students");
$test ->printValues($con,"registration");
$test ->InsertMultipleValues($con,"Sean","Carroll",23,5);
$test ->DeleteValues($con,"registration","Sean");

$con->close();
