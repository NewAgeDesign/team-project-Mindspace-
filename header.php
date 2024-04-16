<?php
include 'config.php';
//Check if user was redirected here through the url

// Signup Validation
switch (isset($_POST)){
    case isset($_POST['signup']):
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $name = $_POST['name'];
        $username = $_POST['alias'];
        // Check if email, password, name and username are empty
        if(empty($email) || empty($password) || empty($name) || empty($username)){
            header("Location: index.php?reg=signup&err=sbe1");
        }
        // Check if email is valid
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: index.php?reg=signup&err=sbe2");
        }
        // Check if password is less than 8 characters or doesnt have capital letters, numbers or symbols
        elseif(strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*()]/', $password)){
            header("Location: index.php?reg=signup&err=sbe3");
        }
        // Check if username is less than 6 characters
        elseif(strlen($username) < 6){
            header("Location: index.php?reg=signup&err=sbe4");
        }
        //Check if name has capital or small letters only
        elseif(!preg_match('/[a-zA-Z]/', $name)){
            header("Location: index.php?reg=signup&err=sbe5");
        }
        // Check if email or username already exists, sanitize first
        else{
            $email = mysqli_real_escape_string($conn, $email);
            $password = mysqli_real_escape_string($conn, $password);
            $name = mysqli_real_escape_string($conn, $name);
            $username = mysqli_real_escape_string($conn, $username);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                // Replace die() with a more secure error handling mechanism
                throw new Exception('Invalid query: ' . mysqli_error($conn));
            }
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck > 0){
                header("Location: index.php?reg=signup&err=sbe6");
            }
            else{
                //Insert user details into the database
                $sql = "INSERT INTO users (email, fname, username, psw) VALUES ('$email', '$name', '$username', '$password')";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    throw new Exception('Invalid query: ' . mysqli_error($conn));
                }
                else{
                    header("Location: index.php?reg=login&err=sge");
                }
            }
        }
        break;

    case isset($_POST['login']):
        $username = $_POST['alias'];
        $password = $_POST['psw'];
        // Check if username and password are empty
        if(empty($username) || empty($password)){
            header("Location: index.php?reg=login&err=lbe1");
        }
        else{
            $username = mysqli_real_escape_string($conn, $username);
            $password = mysqli_real_escape_string($conn, $password);

            $sql = "SELECT * FROM users WHERE username = '$username' or email = '$username'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck < 1){
                header("Location: index.php?reg=login&err=lbe2");
            }
            else{
                if($row = mysqli_fetch_assoc($result)){
                    $hashedPwdCheck = password_verify($password, $row['psw']);
                    if($hashedPwdCheck == false){
                        header("Location: index.php?reg=login&err=lbe3");
                    }
                    elseif($hashedPwdCheck == true){
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['avatar'] = $row['avatar'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['name'] = $row['fname'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['reload'] = 0;
                        header("Location: index.php");
                    }
                }
            }
        }
        break;
    case isset($_POST['reset']):
        $email = $_POST['email'];
        // Check if email is empty
        if(empty($email)){
            header("Location: index.php?reg=reset&err=rbe1");
        }
        // Check if email is valid
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: index.php?reg=reset&err=rbe2");
        }
        else{
            $email = mysqli_real_escape_string($conn, $email);
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck < 1){
                header("Location: index.php?reg=reset&err=rbe3");
            }
            else{
                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);

                $url = "http://localhost/teamproject.com/index.php?reg=resetpsw&sel=" . $selector . "&val=" . bin2hex($token);
                $expires = date("U") + 1800;

                //check first if there's an existing token under that email
                $sql = "DELETE FROM pswreset WHERE remail = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: index.php?reg=reset&err=rbe4");
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                }
                $sql = "INSERT INTO pswreset (remail, rselector, rtoken, rexpire) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: index.php?reg=reset&err=rbe5");
                    exit();
                }
                else{
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
                    mysqli_stmt_execute($stmt);
                }
                
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                $to = $email;
                $subject = "Reset your password for Mindspace";
                $message .= '<h1>Welcome, Let\'s help you reset your password</h1><p>We received a password reset request. 
                The link to reset your password is below. If you did not make this request, you can ignore this email</p>';
                $message .= '<p>Here is your password reset link: <a href="' . $url . '">' . $url . '</a></p>';
                $from = "From: tawinia@kabarak.ac.ke \r\n";

                mail($to, $subject, $message, $from);
                header("Location: index.php?reg=reset&err=rge");
            }

            
        
    }
    break;
    case isset($_POST['chat']):
        $message = $_POST['message'];
        $sender = $_SESSION['id'];
        $receiver = $_POST['receiver'];
        date_default_timezone_set('Africa/Nairobi');
    
        if(empty($message)){
            exit();
        }
        else{
            // Prepare the SQL statement to insert the message
            $message = mysqli_real_escape_string($conn, $message);
            $stmt = mysqli_prepare($conn, "INSERT INTO messages (senderid, receiverid, message) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $sender, $receiver, $message); // Use $receiverId instead of $receiver
            mysqli_stmt_execute($stmt);
    
            if (!$stmt) {
                throw new Exception('Invalid query: ' . mysqli_error($conn));
            }
            else{
                mysqli_stmt_close($stmt);
                header("location: index.php");
                exit();
            }
        }
        break;
    case isset($_POST['resetpsw']):
        $selector = $_POST['selector'];
        $validator = $_POST['validator'];
        $password = $_POST['psw'];
        $currentDate = date("U");

        $sql = "SELECT * FROM pswreset WHERE rselector = ? AND rexpire >= ?";
        $stmt = mysqli_stmt_init($conn);

        if(empty($password)){
            header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe1");
        }
        elseif(strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*()]/', $password)){
            header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe2");
        }
        elseif(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe3");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)){
                header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe4");
                exit();
            }
            else{
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['rtoken']);

                if($tokenCheck === false){
                    header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe5");
                }
                elseif($tokenCheck === true){
                    $tokenEmail = $row['remail'];
                    $sql = "SELECT * FROM users WHERE email = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe6");
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if(!$row = mysqli_fetch_assoc($result)){
                            header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe7");
                            exit();
                        }
                        else{
                            $sql = "UPDATE users SET psw = ? WHERE email = ?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe8");
                                exit();
                            }
                            else{
                                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM pswreset WHERE remail = ?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    header("Location: index.php?reg=resetpsw&sel=" . $selector . "&val=" . $validator . "&err=rpbe9");
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: index.php?reg=login&err=rpge");
                                }
                            }
                        }
                    }
                }
            }
        }   
        break;
    case isset($_POST['logout']):
        session_unset();
        session_destroy();
        header("Location: index.php");
        break;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        switch(true){
            case empty($_GET):
                echo '<title>Mindspace | Home</title>';
                break;
            case isset($_GET['reg']) && $_GET['reg'] == 'signup':
                echo '<title>Mindspace | Signup</title>';
                break;
            case isset($_GET['reg']) && $_GET['reg'] == 'login':
                echo '<title>Mindspace | Login</title>';
                break;
            case isset($_GET['reg']) && $_GET['reg'] == 'reset':
                echo '<title>Mindspace | Reset</title>';
                break;
            default:
                echo '<title>Mindspace | Home</title>';
                break;
        }
        ?>
        <script src="https://unpkg.com/cropperjs/dist/cropper.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css">
        <link rel="stylesheet" href="uigod.css">
        <style>
            
.posts{
    background-color: #00000000;
    max-height: 100dvh - 65pt;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    display: flex;
    width: 100%;
}
.posts .post{
    max-height: calc(100dvh - 170pt);
    flex-direction: column-reverse;
    min-width: calc(100% - 10pt);
    height: calc(100dvh - 170pt);
    width: calc(100dvw - 470pt);
    border-radius: 4pt;
    overflow-y: scroll; 
    padding: 10pt;
    display: flex;
    margin: 5pt;
}
.profile{
    position: relative;
}
.profile .image{
    box-shadow: 0 0 0 8pt var(--secondary);
    background-color: var(--tertiary);
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    position: absolute;
    display: flex;
    height: 25pt;
    right: 25pt;
    width: 25pt;
    top: 125pt;
}
button[name="logout"]{
    background-color: var(--secondary);
    text-decoration: none;
    display: inline-block;
    border-radius: 6pt;
    text-align: center;
    padding: 10px 20px;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
    color: white;
}

.modal {
    display: flex; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
    background-color: var(--secondary);
    justify-content: center;
    flex-direction: column;
    align-items: center;
    border-radius: 10px;
    height: fit-content;
    margin: 15% auto; 
    display: flex;
    padding: 20px;
    width: 80%; 
}

.close {
    color: var(--tertiary);
    align-self: flex-end;
    font-weight: bold;
    font-size: 28px;
    float: right;
}

.close:hover,
.close:focus {
    text-decoration: none;
    cursor: pointer;
    color: black;
}

#drop-zone {
    background-color: var(--secondary);
    border: 2px dashed #9cb87754;
    justify-content: center;
    align-items: center;
    border-radius: 8pt;
    text-align: center;
    display: flex;
    height: 200px;
    width: 100%;
}

#drop-zone.drop {
    border-color: var(--tertiary);
}

#crop-zone {
    display: none;
    width: 100%;
    height: 200px;
}
#file{
    background-color: var(--tertiary);
    display: none;
}
label[for="file"]{
    background-color: var(--tertiary);
    border-radius: 6pt;
    text-align: center;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
    color: var(--primary);
}
#image {
    max-height: 100%;
    max-width: 100%;
}
#upload{
    background-color: var(--tertiary);
    color: var(--primary);
    border-radius: 6pt;
    text-align: center;
    padding: 10px 20px;
    font-weight: 600;
    margin: 10pt 2px;
    font-size: 16px;
    cursor: pointer;
    border: none;
}
.info .status{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: calc(100% - 40pt);
}
.info .status .role{
    background-color: #9cb87754;
    color: var(--accent);
    border-radius: 4pt;
    text-align: center;
    padding: 5px 10px;
    font-weight: 600;
    font-size: 10pt;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
}
.info .status .sname{
    align-self: center;
    position: relative;
    font-size: 12pt;
    margin: 0;
}
        </style>
    </head>
    <body>
    <?php

    if (isset($_SESSION['id'])){
        echo "
        <header>
        <div class=\"left\">
            <b class=\"logo\"><i><a href=\"\">MindSpace</a></i></b>
            <nav>
                <input type=\"checkbox\" id=\"ham\">
                <label for=\"ham\">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <menu>
                    <span><b class=\"logo\"><i><a href=\"#\">MindSpace</a></i></b></span>
                    <form action=\"header.php\" method=\"post\" id=\"logout\">
                        <button type=\"submit\" name=\"logout\">Logout</button>
                    </form>
                </menu>
            </nav>
        </div>
        <div class=\"right\">
        <b>Welcome ".words($_SESSION['name'],1)."</b>
            "?><?php
            if(isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                echo "<img src=\"{$_SESSION['avatar']}\" alt=\"{$_SESSION['name']}\">";
            }else{
                echo "no image found";
            }?><?php
            echo "
        </div>
                
        </header>
        ";
    }
    ?>