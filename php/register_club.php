<?php
    session_start();
    $con = mysqli_connect("localhost:3306", "root", "");
    mysqli_select_db($con, 'clubsofpdeu');

    $club = $_POST['club'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $clubexists = mysqli_query($con, "select * from authorization where Club='$club'");

    
    if(mysqli_num_rows($clubexists)!=0){
        echo '<div style="display: flex;justify-content: center;align-items: center;width: 100%;height: 100%;flex-direction: column;box-sizing: border-box;">
                <h3 style="text-align: center;box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: calc(1.3rem + .6vw);"> The club with the name '.$club.' already exists! </h3>
            </div>'; 
    }
    else{
        
        if (mysqli_query($con, "insert into authorization (Club, Email, Password) values ('$club', '$email', '$pass')")){
            echo '<div style="display: flex;justify-content: center;align-items: center;width: 100%;height: 100%;flex-direction: column;box-sizing: border-box;">
                <h3 style="text-align: center;box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: calc(1.3rem + .6vw);"> A club with the name '.$club.' has been successfully registered! </h3>
                <h4 style="text-align: center;box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;line-height: 1.2;font-size: calc(1.3rem + .6vw);"> Contact the administrator for adding the club page to the website! </h4>
            </div>';
        }
        else{
            echo '<div style="display: flex;justify-content: center;align-items: center;width: 100%;height: 100%;flex-direction: column;box-sizing: border-box;">
                <h3 style="text-align: center;box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: calc(1.3rem + .6vw);"> The club has not been registered successfully! </h3>
            </div>'; 
        }

    }

?>