<?php include("connect.php");?>
<?
if (isset($_POST['registernow'])) {
    if (isset($_POST['firstname']) && isset($_POST['lastname']) &&
        isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['gender']) && isset($_POST['email']) &&
        isset($_POST['phoneCode']) && isset($_POST['phone'])) {
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phoneCode = $_POST['phoneCode'];
        $phone = $_POST['phone'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "test";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(firstname ,lastname ,username, password, gender, email, phoneCode, phone) values('TINA', 'MUKHERJEE', 'TinaMukherjee', '0987654321', 'female', 'tinamukherjee534@gmail.com', '+91', '9635706624')";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssii",$firstname,$lastname,$username, $password, $gender, $email, $phoneCode, $phone);
                if ($stmt->execute()) {
                    echo "sucessful.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Error";
}
?>