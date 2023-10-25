<?php
session_start();
$con = mysqli_connect("localhost:3306", "root", "");
mysqli_select_db($con, 'clubsofpdeu');

$results = mysqli_query($con, "select * from events order by Date");
$records = mysqli_num_rows($results);

$data = array();
$columns = array("Name", "Club", "Date", "Time", "Description", "Link");

while ($row = mysqli_fetch_array($results)) {
    $temp = array();
    foreach ($columns as $column) {
        array_push($temp, $row[$column]);
    }
    $p = '<img src=\"data:image/jpeg;base64,' . base64_encode($row['Poster']) . '\" width=\"100%\" />';
    array_push($temp, $p);
    array_push($temp, $row['Status']);
    array_push($data, $temp);
}
?>

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
    <link href="../css/upcoming_events.css" rel="stylesheet">

    <title>Clubs of PDEU</title>

</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand navigation-bar" href="../index.html">
                <img src="../media/navigation bar/PDEU Logo.png" alt="" width="50" height="50" class="d-inline-block align-text-top">
                <h4 style="margin: 0px;">Clubs of PDEU</h4>
            </a>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav navigation-options">
                    <li class="nav-item ">
                        <a class="nav-link active add-event-link" href="add_event.php" >Add Event</a>
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
        <section class="about-section" id="about-section">
            <h1 style="margin-top: 30px">Upcoming Events</h1>
            <hr class="line">
        </section>
        <div class="container generation">
            <div id="event-cards"></div>
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
                                    <a class="text-white" href="add_event.php">Add Events</a>
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

    <script type="text/javascript">
        var json_data = '<?php echo json_encode($data, JSON_FORCE_OBJECT); ?>';
        var rows = <?= $records ?>;
        json_data = JSON.parse(json_data);
        console.log(json_data);

        infoCard = 0
        async function run(evt) {

            var club = evt[1];
            var event = evt[0];
            var date = evt[2].split('-');
            var time = evt[3].split(':');
            var desc = evt[4];
            var link = evt[5];

            var eventDate = new Date(date[0], date[1] - 1, date[2], time[0], time[1], 0, 0)
            var today = new Date()
            var millisecond_diff = eventDate.getTime() - today.getTime()

            var millisecond_diff = eventDate.getTime() - today.getTime()
            var days = Math.floor(millisecond_diff / 86400000)
            millisecond_diff -= days * 86400000

            var hours = Math.floor(millisecond_diff / 3600000)
            millisecond_diff -= hours * 3600000

            var minutes = Math.floor(millisecond_diff / 60000)
            millisecond_diff -= minutes * 60000

            var cardId = "card" + String(infoCard)
            infoCard += 1

            console.log("Time difference: " + days + " Days " + hours + " Hours " + minutes + " Minutes ")

            var card = document.createElement('div')
            card.classList.add('card')

            card.innerHTML = evt[6] + `<hr style="margin: 0px; height: 2px; background-color: black;">
                <div class="club-name">
                    <h6 style="margin: 0px;">` + club + `</h6>` +
                `</div>
                <div class="event-name">
                    <h5 style="margin: 0px; text-align: center;">` + event + `</h5>` +
                `<svg id="` + cardId + `" class="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                </div>
                <hr style="margin: 0px; height: 2px; background-color: black;">
                <div class="timer">
                    <h6 style="margin: 0px; font-family:monospace; font-size: smaller; width: 100%; text-align: center;">STARTS IN</h6>
                    <div class="countdown">
                        <div class="days-reamining digits">
                            <h5 style="margin: 0px; text-align: center;">` + days + `</h5>` +
                `<h6 class="countdown-parameter">Days</h6>
                        </div>
                        <div class="hours-reamining digits">
                            <h5 style="margin: 0px; text-align: center;">` + hours + `</h5>` +
                `<h6 class="countdown-parameter">Hours</h6>
                        </div>
                        <div class="minutes-reamining digits">
                            <h5 style="margin: 0px; text-align: center;">` + minutes + `</h5>` +
                `<h6 class="countdown-parameter">Minutes</h6>
                        </div>
                    </div>  
                </div>
                <div class="registration-link">
                    <a href="` + link + `" ><button type="button" class="btn btn-dark register">Register Here!</button></a>
                </div>`

            function addCard() {
                var cardSection = document.getElementById('event-cards');
                cardSection.append(card);
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve('resolved');
                    }, 500);
                });
            }

            function addDesc() {
                // console.log(document.getElementById(cardId))
                document.getElementById(cardId).addEventListener("click", () => {
                    document.getElementById('more-info').style.display = 'flex';
                    document.getElementById('more-info').innerHTML =
                        `<div class="card description">
                        <h3 class="card-header"><span>` +
                        event + `
                            </span>
                            <div id="close"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                            </svg></div>
                        </h3>

                        <div class="card-body">
                        <h5 class="card-title">About the event</h5>
                        <p class="card-text">` + desc + `</p>
                        <a href="`+link+`" class="btn btn-light">Register</a>
                        </div>
                    </div>`

                    setTimeout(() => {
                        document.getElementById('close').addEventListener("click", () => {
                            document.getElementById('more-info').style.display = 'none';
                            var descriptionBox = document.getElementById('more-info');
                            descriptionBox.innerHTML = ``;
                        })
                    }, 500)
                })

                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve('resolved');
                    }, 1000);
                });
            }

            await addCard();
            await addDesc();

        }

        for (var i = 0; i < rows; i++) {
            if (json_data[i][7] == "Approved") {
                run(json_data[i]);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>


</body>

</html>