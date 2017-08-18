<?php
    ob_start();
    
    require("passwords/password.php");


    function connectToDB() {
        // Determine DB settings
        $localhost = array(
            '127.0.0.1',
            '::1'
        );
        if(in_array($_SERVER['REMOTE_ADDR'], $localhost)){
            $servername = "localhost";
            $dbname = "tweetpal";
            $username = "root";
            $password = "root";
        }
        else {
            // HOST CONFIG
            $servername = "localhost";
            $dbname = "DB_NAME";
            $username = "USERNAME";
            $password = "PASSWORD"; 
        }


        // Create & check connection
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        else {
            mysqli_select_db($conn, $dbname);
        }

        return $conn;
    }


    if (isset($_POST['signUp'])) {
        $conn = connectToDB();
        $fullName = $conn->real_escape_string($_POST['fullName']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $now = date("Y-m-d h:i:sa", time());


        writeToLogs("../logs/Signup.txt", "\n\nNew signup! [" . date("Y-m-d h:i:sa", time()) . "]");
        writeToLogs("../logs/Signup.txt", "\n----------------------------------------");


        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result) > 0) {
            writeToLogs("../logs/Signup.txt", "\nUser exists.");
            echo "User exists";
        }
        else {
            writeToLogs("../logs/Signup.txt", "\nUser does not exist.");

            // TODO: remove runsPerDay at end of cookie
            $jobJSON = array(
                "consumerKey" => "", 
                "consumerSecret" => "", 
                "oauthToken" => "", 
                "oauthSecret" => "", 
                "followScript" => "false", 
                "followbackScript" => "false", 
                "unfollowScript" => "false", 
                "users" => "GrowthHackers, Engadget", 
                "maxFollow" => 50, 
                "maxUnfollow" => 100, 
                "minUserFollowers" => 1000, 
                "minUserTweets" => 250, 
                "favouriteScript" => "false", 
                "searchQueryToFavourite" => "@joeytawadrous", 
                "maxTweetsToFavourite" => 10, 
                "sendReplyScript" => "false", 
                "tweetReplyMessage" => "Thanks for the share, ",
                "searchQueryToReply" => "@joeytawadrous", 
                "maxTweetsToReply" => 10,
                "sendMessageScript" => "false", 
                "directMessage" => "Focus. Make money. Achieve. I can show you how - http://www.joeyt.net/blog",
                "maxMessagesToSend" => 50
            );
            $jobJSON = json_encode($jobJSON);


            $sql = "INSERT INTO users VALUES('{$email}', '{$password}', '{$fullName}', '0', '{$jobJSON}', 'Basic', '', '', '{$now}', '{$now}', '', '{$now}', '')";
            echo $sql;
            $result = mysqli_query($conn, $sql);


            if(!$result) {
                writeToLogs("../logs/Signup.txt", "\n{$email} could not be registered at [{$now}]");
                echo "User could not be registered";
            }
            else {
                writeToLogs("../logs/Signup.txt", "\n{$email} registered at [{$now}]");

                setcookie("email", $email, time() + (86400), "/");
                setcookie("fullName", $fullName, time() + (86400), "/");
                setcookie("jobJSON", $jobJSON, time() + (86400), "/");
                setcookie("userplan", "Basic", time() + (86400), "/");
                setcookie("planExpiryDate", $now, time() + (86400), "/");

                echo "Success";
            }
        }
    }


    else if (isset($_POST['login'])) {
        $conn = connectToDB();
        writeToLogs("../logs/Login.txt", "\n\nLogging A User In! [" . date("Y-m-d h:i:sa", time()) . "]");
        writeToLogs("../logs/Login.txt", "\n----------------------------------------");


        $email = $conn->real_escape_string($_POST['email']);
        $now = date("Y-m-d h:i:sa", time());


        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result) != 1) {
            writeToLogs("../logs/Login.txt", "\n{$email} could not be logged in at [{$now}]");
            echo "Email & password combination does not exist";
        }
        else {
            while($row = mysqli_fetch_array($result)) {
                if(crypt($_POST['password'], $row['password']) == $row['password']) { // making sure bcrypt passwords match
                    writeToLogs("../logs/Login.txt", "\n{$email} logged in at [{$now}]");

                    setcookie("email", $row['email'], time() + (86400), "/"); 
                    setcookie("fullName", $row["fullName"], time() + (86400), "/");
                    setcookie("jobJSON", $row["jobJSON"], time() + (86400), "/");
                    setcookie("userplan", $row['plan'], time() + (86400), "/");
                    setcookie("planExpiryDate", $row['planExpiryDate'], time() + (86400), "/");

                    // TODO: update login amount number

                    echo "Success";
                } 
                else {
                    writeToLogs("../logs/Login.txt", "\n{$email} could not be logged in at [{$now}]");
                    echo "Email & password combination does not exist";
                } 
            }
        }
    }
    

    else if (isset($_POST['logout'])) {
        setcookie("email", "", time()-10, "/");
        setcookie("fullName", "", time()-10, "/");
        setcookie("jobJSON", "", time()-10, "/");
        setcookie("planExpiryDate", "", time()-10, "/");
        setcookie("userplan", "", time()-10, "/");
    }


    else if (isset($_POST['applyCoupon'])) {
        $conn = connectToDB();
        writeToLogs("../logs/ApplyCoupon.txt", "\n\n\nApplying a Coupon! [" . date("Y-m-d h:i:sa", time()) . "]");
        writeToLogs("../logs/ApplyCoupon.txt", "\n----------------------------------------");


        $coupon = $conn->real_escape_string($_POST['coupon']); 
        $email = $_COOKIE["email"];
        $now = date("Y-m-d h:i:sa", time());


        $sql = "SELECT * FROM coupons WHERE code = '{$coupon}'";
        $result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result) != 1) {
            writeToLogs("../logs/ApplyCoupon.txt", "\nCoupon {$coupon} not found at [{$now}]");
            echo "Failure";
        }
        else {
            writeToLogs("../logs/ApplyCoupon.txt", "\nCoupon {$coupon} found at [{$now}]. Will now delete the coupon so it cannot be reused!");


            while($row = mysqli_fetch_array($result)) {
                $source = "";
                $couponType = $row["type"];
                writeToLogs("../logs/ApplyCoupon.txt", "\nCouponType {$couponType}");


                $sql = "DELETE FROM coupons WHERE code = '{$coupon}'";
                mysqli_query($conn, $sql);


                if(trim($couponType) == "landingPageLifetime") {
                    $planExpiryDate = date("d M Y", strtotime("+36500 days"));
                    $source = "LandingPage";
                }


                $sql = "UPDATE users SET planExpiryDate = '{$planExpiryDate}', customerID = '{$source}', plan = 'Pro' WHERE email = '{$email}'";
                $result = mysqli_query($conn, $sql);


                if(!$result) {
                    writeToLogs("../logs/ApplyCoupon.txt", "\nCoupon from {$email} / {$source} could not be applied at [{$now}] . SQL = {$sql}");
                    echo "Failure";
                }
                else {
                    writeToLogs("../logs/ApplyCoupon.txt", "\nCoupon from {$email} / {$source} applied at [{$now}]");

                    setcookie("userplan", "Pro", time() + (86400), "/");
                    setcookie("planExpiryDate", $planExpiryDate, time() + (86400), "/");

                    echo "Success";
                }
            }
        }
    }


    else if (isset($_POST['saveConfig'])) {
        $conn = connectToDB();
        writeToLogs("../logs/SaveConfig.txt", "\n\nSave Config! [" . date("Y-m-d h:i:sa", time()) . "]");
        writeToLogs("../logs/SaveConfig.txt", "\n----------------------------------------");


        $type = $_POST['type']; 
        $email = $_COOKIE["email"];
        $jobJSON = json_decode($_COOKIE["jobJSON"]);
        $now = date("Y-m-d h:i:sa", time());


        if($type == "global") {
            $consumerKey = $conn->real_escape_string($_POST['consumerKey']); 
            $consumerSecret = $conn->real_escape_string($_POST['consumerSecret']); 
            $oauthToken = $conn->real_escape_string($_POST['oauthToken']); 
            $oauthSecret = $conn->real_escape_string($_POST['oauthSecret']); 
            $runsPerDay = (int)$_POST['runsPerDay'];

            $jobJSON->consumerKey = $consumerKey;
            $jobJSON->consumerSecret = $consumerSecret;
            $jobJSON->oauthToken = $oauthToken;
            $jobJSON->oauthSecret = $oauthSecret;
        }
        else if($type == "follow") {
            $followScript = $_POST['followScript'];
            $followbackScript = $_POST['followbackScript'];
            $unfollowScript = $_POST['unfollowScript'];
            $users = $conn->real_escape_string($_POST['users']); 
            $maxFollow = $conn->real_escape_string($_POST['maxFollow']); 
            $minUserFollowers = $conn->real_escape_string($_POST['minUserFollowers']); 
            $minUserTweets = $conn->real_escape_string($_POST['minUserTweets']); 

            $jobJSON->followScript = $followScript;
            $jobJSON->followbackScript = $followbackScript;
            $jobJSON->unfollowScript = $unfollowScript;
            $jobJSON->users = $users;
            $jobJSON->maxFollow = $maxFollow;
            $jobJSON->minUserFollowers = $minUserFollowers;
            $jobJSON->minUserTweets = $minUserTweets;
        }
        else if($type == "favourite") {
            $favouriteScript = $_POST['favouriteScript'];
            $searchQueryToFavourite = $conn->real_escape_string($_POST['searchQueryToFavourite']); 
            $maxTweetsToFavourite = $conn->real_escape_string($_POST['maxTweetsToFavourite']); 

            $jobJSON->favouriteScript = $favouriteScript;
            $jobJSON->searchQueryToFavourite = $searchQueryToFavourite;
            $jobJSON->maxTweetsToFavourite = $maxTweetsToFavourite;
        }
        else if($type == "reply") {
            $sendReplyScript = $_POST['sendReplyScript'];
            $tweetReplyMessage = $conn->real_escape_string($_POST['tweetReplyMessage']); 
            $searchQueryToReply = $conn->real_escape_string($_POST['searchQueryToReply']); 
            $maxTweetsToReply = $conn->real_escape_string($_POST['maxTweetsToReply']); 

            $jobJSON->sendReplyScript = $sendReplyScript;
            $jobJSON->tweetReplyMessage = $tweetReplyMessage;
            $jobJSON->searchQueryToReply = $searchQueryToReply;
            $jobJSON->maxTweetsToReply = $maxTweetsToReply;
        }
        else if($type == "sendMessage") {
            $sendMessageScript = $_POST['sendMessageScript'];
            $directMessage = $conn->real_escape_string($_POST['directMessage']); 
            $maxMessagesToSend = $conn->real_escape_string($_POST['maxMessagesToSend']); 

            $jobJSON->sendMessageScript = $sendMessageScript;
            $jobJSON->directMessage = $directMessage;
            $jobJSON->maxMessagesToSend = $maxMessagesToSend;
        }


        // update cookie  
        $jobJSON = json_encode($jobJSON);       
        setcookie("jobJSON", $jobJSON, time() + (86400), "/");


        // TODO: Chage jobJSON updateDate & times updated in DB
        $sql = "UPDATE users SET jobJSON = '{$jobJSON}' WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);


        if(!$result) {
            writeToLogs("../logs/SaveConfig.txt", "\n{$type} configuration (jobJSON) for {$email} could not be updated at [{$now}]");
            echo "Failure";
        }
        else {
            writeToLogs("../logs/SaveConfig.txt", "\n{$type} configuration (jobJSON) for {$email} updated at [{$now}]");
            

            if($type == "global") {
                $sql = "UPDATE users SET runsPerDay = '{$runsPerDay}' WHERE email = '{$email}'";
                $result = mysqli_query($conn, $sql);


                if(!$result) {
                    writeToLogs("../logs/SaveConfig.txt", "\n{$type} configuration (runsPerDay) for {$email} could not be updated at [{$now}]");
                    echo "Failure";
                }
                else {
                    writeToLogs("../logs/SaveConfig.txt", "\n{$type} configuration (runsPerDay) for {$email} updated at [{$now}]");
                    echo "Success";
                }
            }
            else {
                echo "Success";
            }
        }
    }


    function getJobJSON($email, $logLocation = "logs/GetJobJSON.txt") {
        $conn = connectToDB();
        writeToLogs($logLocation, "\n\nGetting jobs JSON! [" . date("Y-m-d h:i:sa", time()) . "]");
        writeToLogs($logLocation, "\n----------------------------------------");


        $now = date("Y-m-d h:i:sa", time());


        $sql = "SELECT jobJSON FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result) == 1) {
            writeToLogs($logLocation, "\nRetrieved jobJSON for email {$email} at [{$now}]");

            $resultData = $result->fetch_array(MYSQLI_ASSOC);
            return json_decode($resultData["jobJSON"]);
        }
        else {
            writeToLogs($logLocation, "\nCould not retrieve jobJSON for email {$email} at [{$now}]");
        }
    }

    function getRunsPerDay($email, $logLocation = "logs/GetJobJSON.txt") {
        $conn = connectToDB();
        writeToLogs($logLocation, "\n\nGetting runsPerDay! [" . date("Y-m-d h:i:sa", time()) . "]");
        writeToLogs($logLocation, "\n----------------------------------------");


        $now = date("Y-m-d h:i:sa", time());


        $sql = "SELECT runsPerDay FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);


        if(mysqli_num_rows($result) == 1) {
            writeToLogs($logLocation, "\nRetrieved runsPerDay for email {$email} at [{$now}]");

            $resultData = $result->fetch_array(MYSQLI_ASSOC);
            return json_decode($resultData["runsPerDay"]);
        }
        else {
            writeToLogs($logLocation, "\nCould not retrieve runsPerDay for email {$email} at [{$now}]");
        }
    }


    function writeToLogs($fileToWrite, $textToWrite) {
        $updatedFile = file_get_contents($fileToWrite);
        $updatedFile .= $textToWrite;
        file_put_contents($fileToWrite, $updatedFile);
    }
?>