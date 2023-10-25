<!DOCTYPE html>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet" />

    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/add_remove_event.css" rel="stylesheet">

    <title>Clubs of PDEU</title>

</head>

<body>

    <?php
    session_start();
    $successful = FALSE;
    $error = "";

    if (isset($_POST['submit'])) {
        $con = mysqli_connect("localhost:3306", "root", "");
        mysqli_select_db($con, 'clubsofpdeu');

        // to set the max_allowed_packet to 10MB
        $con->query('SET @@global.max_allowed_packet = ' . 10 * 1024 * 1024);

        $event = $_POST['event-name'];
        $club = $_POST['club'];
        $date = $_POST['event-date'];
        $time = $_POST['event-time'];
        $desc = $_POST['event-description'];
        $link = $_POST['event-link'];
        $poster = addslashes(file_get_contents($_FILES['event-poster']['tmp_name']));
        $status = 'Pending';

        $password = $_POST['event-pass'];

        $clubexists = mysqli_query($con, "select * from authorization where Club='$club'");
        if (mysqli_num_rows($clubexists) == 0) {
            $error = 'The club ' . $club . ' has not been registered! <a href=#" class="alert-link">Click here to register!</a>';
        } else {

            $isauthorized = "select * from authorization where Club='$club' and Password='$password'";
            $result = mysqli_query($con, $isauthorized);

            if (mysqli_num_rows($result) == 1) {

                $ispresent = "select * from events where Name='$event'";
                $temp_result = mysqli_query($con, $ispresent);

                if (mysqli_num_rows($temp_result) != 0) {
                    $error = "An event with same name already exists!";
                } else {

                    $add_event = "insert into events (Name, Club, Date, Time, Description, Link, Poster, Status) 
                        values ('$event', '$club', '$date', '$time', '$desc', '$link', '$poster', '$status')";

                    if (mysqli_query($con, $add_event)) {
                        $successful = TRUE;

                        $to = "hansalshah100@gmail.com";
                        $subject = "Event approval for " . $event;

                        $headers = "From: hansalshah100@gmail.com\r\n";
                        $headers .= "MIME-VERSION: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";

                        $body = '
                            <!doctype html>
                            <html lang="en" style="box-sizing: border-box;">
                            <head style="box-sizing: border-box;">
                                <meta charset="utf-8" style="box-sizing: border-box;">
                                <meta name="viewport" content="width=device-width, initial-scale=1" style="box-sizing: border-box;">
                                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                            </head>
                            <body style="box-sizing: border-box;margin: 0;font-family: var(--bs-font-sans-serif);font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;background-color: #fff;-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">

                                <div class="container" style="margin: 15px;padding: 10px;background-color: rgba(0,0,0,.03);width: 100%;height: fit-content;box-sizing: border-box;padding-right: var(--bs-gutter-x,.75rem);padding-left: var(--bs-gutter-x,.75rem);margin-right: auto;margin-left: auto;">
                                    <div class="card" style="width: 85%;height: fit-content;margin: auto;display: block;box-sizing: border-box;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.125);border-radius: .25rem;">
                                    <div class="card-body" style="margin: auto;width: 100%;box-sizing: border-box;padding: 1rem 1rem;">
                                        <h3 class="card-title" style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: calc(1.3rem + .6vw);">' . $event . ' (' . $club . ')</h3><hr style="box-sizing: border-box;margin: 1rem 0;color: inherit;background-color: currentColor;border: 0;opacity: .25;height: 1px;">
                                        <p class="card-text" style="font-weight: bolder;box-sizing: border-box;margin-top: 0;margin-bottom: 0;">' . $desc . '</p>
                                    </div>
                                    <ul class="list-group list-group-flush" style="display: block;margin: auto;width: 100%;box-sizing: border-box;padding-left: 0;margin-top: 0;margin-bottom: 0;border-radius: 0;border-top: inherit;border-bottom: inherit;">
                                        <li class="list-group-item" style="box-sizing: border-box;position: relative;display: block;padding: .5rem 1rem;color: #212529;text-decoration: none;background-color: #fff;border: 1px solid rgba(0,0,0,.125);border-top-left-radius: inherit;border-top-right-radius: inherit;border-width: 0 0 1px;">
                                            <span style="font-weight: bold;font-size: 80%;box-sizing: border-box;">Date: ' . $date . '</span><br style="box-sizing: border-box;">
                                            <span style="font-weight: bold;font-size: 80%;box-sizing: border-box;">Time: ' . $time . '</span>
                                        </li>
                                        <li class="list-group-item" style="box-sizing: border-box;position: relative;display: block;padding: .5rem 1rem;color: #212529;text-decoration: none;background-color: #fff;border: 1px solid rgba(0,0,0,.125);border-bottom-right-radius: inherit;border-bottom-left-radius: inherit;border-top-width: 0;border-width: 0 0 1px;border-bottom-width: 0;">
                                        <a href="' . $link . '" class="card-link" style="box-sizing: border-box;color: #0d6efd;text-decoration: underline;">Registration Link</a>
                                        </li>
                                    </ul>
                                    <div class="card-body" style="width: 100%;box-sizing: border-box;;padding: 1rem 1rem;">
                                        <div style="margin: auto;width: fit-content;box-sizing: border-box;">
                                        <a href="localhost/Clubs of PDEU/approval.php?event=' . urlencode($event) . '&club=' . urlencode($club) . '&status=Approved" class="card-link" style="box-sizing: border-box;color: #0d6efd;text-decoration: underline;"><button type="button" class="btn btn-outline-success" style="margin: auto;box-sizing: border-box;border-radius: .25rem;font-family: inherit;font-size: 1rem;line-height: 1.5;text-transform: none;-webkit-appearance: button;display: inline-block;font-weight: 400;color: #198754;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;background-color: transparent;border: 1px solid transparent;padding: .375rem .75rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;border-color: #198754;">Accept</button></a>
                                        <a href="localhost/Clubs of PDEU/approval.php?event=' . urlencode($event) . '&club=' . urlencode($club) . '&status=Declined" class="card-link" style="box-sizing: border-box;color: #0d6efd;text-decoration: underline;margin-left: 1rem;"><button type="button" class="btn btn-outline-danger" style="margin: auto;box-sizing: border-box;border-radius: .25rem;font-family: inherit;font-size: 1rem;line-height: 1.5;text-transform: none;-webkit-appearance: button;display: inline-block;font-weight: 400;color: #dc3545;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;background-color: transparent;border: 1px solid transparent;padding: .375rem .75rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;border-color: #dc3545;">Decline</button></a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </body>
                            </html>';

                        ini_set("SMTP", "tls://smtp.gmail.com");
                        ini_set("smtp_port", "587");
                        if (!mail($to, $subject, $body, $headers)) {
                            // echo '<h2>Email has been successfully sent!</h2></div>';
                            $error = "Email has failed to be sent!";
                        }
                    } else {
                        $error = "" . mysqli_error($con);
                    }
                }
            } else {
                $error = "The name of the club and secret key do not match!";
            }
        }
    }
    ?>

    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand navigation-bar" href="../index.html">
                <img src="../media/navigation bar/PDEU Logo.png" alt="" width="50" height="50" class="d-inline-block align-text-top">
                <h4 style="margin: 0px;">Clubs of PDEU</h4>
            </a>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav navigation-options">
                    <li class="nav-item upcoming-link">
                        <a class="nav-link active" aria-current="page" href="upcoming_events.php">Upcoming Events</a>
                        <i class="fas fa-fire-alt hot"></i>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link remove-event-link" href="../remove_event.html">Remove Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link register-club-link" href="../register_club.html">Register Club</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Clubs
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Science & Technical</a></li>
                            <li><a class="dropdown-item" href="#">Social & Cultural</a></li>
                            <li><a class="dropdown-item" href="#">Student Chapters</a></li>
                            <li><a class="dropdown-item" href="#">Sports Committee</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex nav-option-right">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <section class="about-section" id="about-section" >
            <h1 style="margin-top: 30px">Add an Event</h1>
            <hr class="line">
        </section>

        <div class="container generation">
            <div id="update" class="alert hide"></div>
            <div class="container" style="display: flex; flex-direction: row; justify-content: center; align-items: center; height: fit-content;">
                <div class="event-info-card form" style="width: fit-content;">
                    <h4 class="card-header">Event Information</h4>
                    <div class="card-body" style="height: fit-content;">
                        <form action="" id="event-form" method="post" enctype="multipart/form-data">

                            <div class="data-field">
                                <label for="club" class="field">Organizing club</label><br>
                                <div style="display: flex; flex-direction: row;">
                                    <input class="input" type="text" name="club" id="club" value="<?php
                                        if ($successful === FALSE && isset($_POST['club'])) {
                                            echo htmlentities($_POST['club']);
                                        }
                                        ?>" required><br>
                                    <div class="hide invalid" id="club-error"></div>
                                    <div class="hide valid" id="club-ok">&#10003</div>
                                </div>
                            </div>

                            <div class="data-field">
                                <label for="event-name" class="field">Event name</label><br>
                                <div style="display: flex; flex-direction: row;">
                                    <input class="input" type="text" name="event-name" id="event-name" value="<?php
                                        if ($successful === FALSE && isset($_POST['event-name'])) {
                                            echo htmlentities($_POST['event-name']);
                                        }
                                        ?>" required><br>
                                    <div class="hide invalid" id="event-error"></div>
                                    <div class="hide valid" id="event-ok">&#10003</div>
                                </div>
                            </div>

                            <div class="data-field">
                                <label for="event-date" class="field">Event date</label><br>
                                <div style="display: flex; flex-direction: row;">
                                    <input class="input" type="date" name="event-date" id="event-date" value="<?php
                                        if ($successful === FALSE && isset($_POST['event-date'])) {
                                            echo htmlentities($_POST['event-date']);
                                        }
                                        ?>" required><br>
                                    <div class="hide invalid" id="date-error"></div>
                                    <div class="hide valid" id="date-ok">&#10003</div>
                                </div>
                            </div>

                            <div class="data-field">
                                <label for="event-time" class="field">Event time</label><br>
                                <div style="display: flex; flex-direction: row;">
                                    <input class="input" type="time" name="event-time" id="event-time" value="<?php
                                        if ($successful === FALSE && isset($_POST['event-time'])) {
                                            echo htmlentities($_POST['event-time']);
                                        }
                                        ?>" required><br>
                                    <div class="hide invalid" id="time-error"></div>
                                    <div class="hide valid" id="time-ok">&#10003</div>
                                </div>
                            </div>

                            <div class="data-field">
                                <label for="event-desc" class="field">Description</label><br>
                                <div style="display: flex; flex-direction: column;">
                                    <textarea class="input" id="event-desc" name="event-description" rows="7" cols="55" style="margin-bottom: 10px;" placeholder="Enter event's description here" required><?php if ($successful === FALSE && isset($_POST['event-description'])) {
                                        echo htmlentities($_POST['event-description']);
                                    } ?></textarea>
                                    <div class="hide invalid" id="desc-error"></div>
                                    <div class="hide valid" id="desc-ok">&#10003</div>
                                </div>
                            </div>

                            <div class="data-field">
                                <label for="event-link" class="field">Registration Link</label><br>
                                <div style="display: flex; flex-direction: row;">
                                    <input class="input" type="text" id="event-link" name="event-link" placeholder="Registration form link" value="<?php
                                        if ($successful === FALSE && isset($_POST['event-link'])) {
                                            echo htmlentities($_POST['event-link']);
                                        }
                                        ?>" required><br>
                                    <div class="hide invalid" id="link-error"></div>
                                    <div class="hide valid" id="link-ok">&#10003</div>
                                </div>
                            </div>

                            <div class="data-field">
                                <label for="event-poster" class="field">Event Poster</label><br>
                                <input type="file" name="event-poster" id="event-poster" value="<?php
                                    if ($successful === FALSE && isset($_POST['event-poster'])) {
                                        echo htmlentities($_POST['event-poster']);
                                    }
                                    ?>" required><br><br>
                            </div>

                            <div class="data-field">
                                <label for="event-desc" class="field">Secret Key</label><br>
                                <input type="password" id="event-pass" name="event-pass" required><br>
                            </div>

                            <div class="submit-button">
                                <input id="submit" class="btn btn-dark form-button" type="submit" name="submit" value=Add>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="more-info"></div>
    </div>



    <footer>
        <div class="my-5" style="margin-bottom: 0px !important;">
            <!-- Footer -->
            <footer class="text-center text-lg-start text-white" style="background-color:#212529">
                <!-- Grid container -->
                <div class="container p-4 pb-0">
                    <!-- Section: Links -->
                    <section class="">
                        <!--Grid row-->
                        <div class="row">
                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                                <h6 class="text-uppercase mb-4 font-weight-bold">
                                    Pandit Deendayal Energy University
                                </h6>
                                <p>
                                    Knowledge Corridor, Raisan Village, PDPU Rd, Sector 7, Gandhinagar, Gujarat 382007
                                </p>
                            </div>
                            <!-- Grid column -->

                            <hr class="w-100 clearfix d-md-none" />

                            <!-- Grid column -->
                            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                                <h6 class="text-uppercase mb-4 font-weight-bold">Clubs</h6>
                                <p>
                                    <a class="text-white">Science & Technical</a>
                                </p>
                                <p>
                                    <a class="text-white">Social & Cultural</a>
                                </p>
                                <p>
                                    <a class="text-white">Sports</a>
                                </p>
                                <p>
                                    <a class="text-white">Student Chapters</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <hr class="w-100 clearfix d-md-none" />

                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                                <h6 class="text-uppercase mb-4 font-weight-bold">
                                    Useful links
                                </h6>
                                <p>
                                    <a class="text-white" href="upcoming_events.php">Upcoming Events</a>
                                </p>
                                <p>
                                    <a class="text-white" href="../remove_event.html">Remove Events</a>
                                </p>
                                <p>
                                    <a class="text-white" href="../register_club.html">Club Registration</a>
                                </p>
                            </div>

                            <!-- Grid column -->
                            <hr class="w-100 clearfix d-md-none" />

                            <!-- Grid column -->
                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                                <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
                                <p><i class="fas fa-home mr-3"></i> Gandhinagar, IND</p>
                                <p><i class="fas fa-envelope mr-3"></i> support@pdeu.com</p>
                                <p><i class="fas fa-phone mr-3"></i> +91 704 3535 939</p>
                                <p><i class="fas fa-print mr-3"></i> +91 997 4056 801</p>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!--Grid row-->
                    </section>
                    <!-- Section: Links -->

                    <hr class="my-3">

                    <!-- Section: Copyright -->
                    <section class="p-3 pt-0">
                        <div class="row d-flex align-items-center">
                            <!-- Grid column -->
                            <div class="col-md-7 col-lg-8 text-center text-md-start">
                                <!-- Copyright -->
                                <div class="p-3">
                                    © 2022 Copyright
                                </div>
                                <!-- Copyright -->
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                                <!-- Facebook -->
                                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="fab fa-facebook-f"></i></a>

                                <!-- Twitter -->
                                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="fab fa-twitter"></i></a>

                                <!-- Google -->
                                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="fab fa-google"></i></a>

                                <!-- Instagram -->
                                <a class="btn btn-outline-light btn-floating m-1" class="text-white" role="button"><i class="fab fa-instagram"></i></a>
                            </div>
                            <!-- Grid column -->
                        </div>
                    </section>
                    <!-- Section: Copyright -->
                </div>
                <!-- Grid container -->
            </footer>
            <!-- Footer -->
        </div>
        <!-- End of .container -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
    
    <?php
        if ($successful===TRUE){
            ?>
                <script>
                    update = document.getElementById('update');
                    update.innerHTML=`The event has been added successfully and it is under approval! <br> 
                    <a href="upcoming_events.php" class="alert-link">Click here to view all the approved events!</a>`;
                    update.classList.remove('hide');
                    update.className += " alert-success show";
                </script>
            <?php
        }
        else if(isset($_POST['submit'])){
            ?>
                <script>
                    update = document.getElementById('update');
                    update.innerHTML=`<?= $error ?>`;
                    update.classList.remove('hide');
                    update.className += " alert-danger show";
                </script>
          <?php
        }
    ?>

    <!-- Script for validating the form -->
    <script>
        var elements = {
            club: 0,
            event: 1,
            date: 2,
            time: 3,
            desc: 4,
            link: 5,
        }

        var formInputs = [
            document.getElementById('club'),
            document.getElementById('event-name'),
            document.getElementById('event-date'),
            document.getElementById('event-time'),
            document.getElementById('event-desc'),
            document.getElementById('event-link')    
        ];

        var formInvalids = [
            document.getElementById('club-error'),
            document.getElementById('event-error'),
            document.getElementById('date-error'),
            document.getElementById('time-error'),
            document.getElementById('desc-error'),
            document.getElementById('link-error')
        ];

        var formValids = [
            document.getElementById('club-ok'),
            document.getElementById('event-ok'),
            document.getElementById('date-ok'),
            document.getElementById('time-ok'),
            document.getElementById('desc-ok'),
            document.getElementById('link-ok')
        ];
        
        var errors = {
            club: false,
            event: false,
            date: false,
            time:false,
            desc: false,
            link: false,
        };

        var valids = {
            club: false,
            event: false,
            date: false,
            time:false,
            desc: false,
            link: false,
        };

        // Validation for club name

        formInputs[elements['club']].addEventListener("focusout", () => {
            var regex = /^[a-zA-Z]{1}[a-zA-Z ]{2,30}$/;
            var text = formInputs[elements['club']].value;
            
            if(!regex.test(text)){
                formInvalids[elements['club']].innerText = 'The club name is invalid!';
                if (!errors['club']){
                    if (valids['club']){
                        formInvalids[elements['club']].classList.toggle('hide');
                        formValids[elements['club']].classList.toggle('hide');
                    }
                    else{
                        formInvalids[elements['club']].classList.toggle('hide');
                    }
                    errors['club'] = true;
                    valids['club']= false;
                }
            }
            else {  
                if (errors['club']){
                    formInvalids[elements['club']].classList.toggle('hide');
                    formValids[elements['club']].classList.toggle('hide');
                }
                else{
                    if (!valids['club']){
                        formValids[elements['club']].classList.toggle('hide');
                    }
                }
                errors['club']=false;
                valids['club']= true;
            }
        });

        // Validation for event name

        formInputs[elements['event']].addEventListener("focusout", () => {
            var regex = /^[a-zA-Z]{1}[a-zA-Z 0-9_-]{2,50}$/;
            var text = formInputs[elements['event']].value;
            
            if(!regex.test(text)){
                formInvalids[elements['event']].innerText = 'The event name is invalid!';
                if (!errors['event']){
                    if (valids['event']){
                        formInvalids[elements['event']].classList.toggle('hide');
                        formValids[elements['event']].classList.toggle('hide');
                    }
                    else{
                        formInvalids[elements['event']].classList.toggle('hide');
                    }
                    errors['event'] = true;
                    valids['event']= false;
                }
            }
            else {  
                if (errors['event']){
                    formInvalids[elements['event']].classList.toggle('hide');
                    formValids[elements['event']].classList.toggle('hide');
                }
                else{
                    if (!valids['event']){
                        formValids[elements['event']].classList.toggle('hide');
                    }
                }
                errors['event']=false;
                valids['event']= true;
            }
        });

        // Validation for event date and time

        formInputs[elements['date']].addEventListener("focusout", () => {
            if (document.getElementById('event-time').value != ""){
                
                let date = String(formInputs[elements['date']].value).split('-');
                let time = String(document.getElementById('event-time').value).split(':');
                var eventDate = new Date(date[0], date[1]-1, date[2], time[0], time[1], 0, 0);
                var today = new Date();
                var millisecond_diff = eventDate.getTime()-today.getTime();

                if(millisecond_diff<0){
                    formInvalids[elements['time']].innerText = 'The event has to be in the future!';
                    if (!errors['time']){
                        if (valids['time']){
                            formInvalids[elements['time']].classList.toggle('hide');
                            formValids[elements['time']].classList.toggle('hide');
                            formValids[elements['date']].classList.toggle('hide');
                        }
                        else{
                            formInvalids[elements['time']].classList.toggle('hide');
                        }
                        errors['time'] = true;
                        valids['time']= false;
                        valids['date'] = false;
                    }
                }
                else {  
                    if (errors['time']){
                        formInvalids[elements['time']].classList.toggle('hide');
                        formValids[elements['time']].classList.toggle('hide');
                        formValids[elements['date']].classList.toggle('hide');
                    }
                    else{
                        if (!valids['date']){
                            formValids[elements['time']].classList.toggle('hide');
                            formValids[elements['date']].classList.toggle('hide');
                        }
                    }
                    errors['tine']=false;
                    valids['time']= true;
                    valids['date'] = true;
                }
            }
        });


        formInputs[elements['time']].addEventListener("focusout", () => {
            if (document.getElementById('event-date').value != ""){
                
                let date = String(formInputs[elements['date']].value).split('-');
                let time = String(document.getElementById('event-time').value).split(':');
                var eventDate = new Date(date[0], date[1]-1, date[2], time[0], time[1], 0, 0);
                var today = new Date();
                var millisecond_diff = eventDate.getTime()-today.getTime();

                if(millisecond_diff<0){
                    formInvalids[elements['time']].innerText = 'The event has to be in the future!';
                    if (!errors['time']){
                        if (valids['time']){
                            formInvalids[elements['time']].classList.toggle('hide');
                            formValids[elements['time']].classList.toggle('hide');
                            formValids[elements['date']].classList.toggle('hide');
                        }
                        else{
                            formInvalids[elements['time']].classList.toggle('hide');
                        }
                        errors['time'] = true;
                        valids['time']= false;
                        valids['date'] = false;
                    }
                }
                else {  
                    if (errors['time']){
                        formInvalids[elements['time']].classList.toggle('hide');
                        formValids[elements['time']].classList.toggle('hide');
                        formValids[elements['date']].classList.toggle('hide');
                    }
                    else{
                        if (!valids['date']){
                            formValids[elements['time']].classList.toggle('hide');
                            formValids[elements['date']].classList.toggle('hide');
                        }
                    }
                    errors['tine']=false;
                    valids['time']= true;
                    valids['date'] = true;
                }
            }
        });

        // Validation for event description

        formInputs[elements['desc']].addEventListener("focusout", () => {
            var regex = /^[a-zA-Z]{1}[a-zA-Z ,!.;-]{2,249}$/;
            var text = formInputs[elements['desc']].value;
            
            if(!regex.test(text)){
                formInvalids[elements['desc']].innerText = 'The event description is invalid! (Max. 250 characters)!';
                if (!errors['desc']){
                    if (valids['desc']){
                        formInvalids[elements['desc']].classList.toggle('hide');
                        formValids[elements['desc']].classList.toggle('hide');
                    }
                    else{
                        formInvalids[elements['desc']].classList.toggle('hide');
                    }
                    errors['desc'] = true;
                    valids['desc']= false;
                }
            }
            else {  
                if (errors['desc']){
                    formInvalids[elements['desc']].classList.toggle('hide');
                    formValids[elements['desc']].classList.toggle('hide');
                }
                else{
                    if (!valids['desc']){
                        formValids[elements['desc']].classList.toggle('hide');
                    }
                }
                errors['desc']=false;
                valids['desc']= true;
            }
        });

        // Validation for event link

        formInputs[elements['link']].addEventListener("focusout", () => {
            var regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
            var text = formInputs[elements['link']].value;
            
            if(!regex.test(text)){
                formInvalids[elements['link']].innerText = 'This is not a valid link!';
                if (!errors['link']){
                    if (valids['link']){
                        formInvalids[elements['link']].classList.toggle('hide');
                        formValids[elements['link']].classList.toggle('hide');
                    }
                    else{
                        formInvalids[elements['link']].classList.toggle('hide');
                    }
                    errors['link'] = true;
                    valids['link']= false;
                }
            }
            else {  
                if (errors['link']){
                    formInvalids[elements['link']].classList.toggle('hide');
                    formValids[elements['link']].classList.toggle('hide');
                }
                else{
                    if (!valids['link']){
                        formValids[elements['link']].classList.toggle('hide');
                    }
                }
                errors['link']=false;
                valids['link']= true;
            }
        });
        
        document.getElementById('event-form').addEventListener('submit', (e) => {
            var allok = true;
            for (let ele in valids){
                if (valids[ele]==false){
                    allok=false;
                    break;
                }
            }
            if (allok){
                e.returnValue = true;
                return true;
            }
            else {
                <?php
                    $error = "The data in the form is not valid!";    
                ?>
                e.returnValue = false;
                return false;
            }
        })
        
    </script>

</body>

</html>