<?php
session_start();
if (!isset($_GET["subscriber"])) {
    header("Location:nordzypern-immobilien.html");
}
$subscriber_id = $_GET["subscriber"] ?? $_SESSION["subscriber"];
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTQzNDI4MTM3MjI0OTIwOTY3ODkxZTIzMDU2NzkyMjI3N2ZmYTc3MTVlZGQxZWIwNDQ0NTI4NzAwZWYwOGQ3OTU5NDNlZDA2Yzk3MGQxODAiLCJpYXQiOjE2ODg5ODg4MzAuOTA3MDU3LCJuYmYiOjE2ODg5ODg4MzAuOTA3MDU5LCJleHAiOjQ4NDQ2NjI0MzAuOTAxNjQ1LCJzdWIiOiI1MjUyNDYiLCJzY29wZXMiOltdfQ.Zv1aqc9cIDcwlzEJeGglnlcc_9TaigXPXj0-8rPBhdflW6ckdydCefAupvhZmVknMKCJY8PdeT_FaRD1z7f7CjRYP7WDzs3DW-yByESvbpjlpquQcWYYQsZWN4UZN_fsYcTiLAzmeOlrqmw0VpnjgAOFD-8ne3IwoeVi7aHQvIbhZgU6_Lo-iJFzzSOstf0tCZnM_l5VtnwW04xJkhJL-53g9fLc80-Fq9jJ_UCMX_XfrSXlB2CnEL0049oNACPeXeubnWjVHtVyCtcFX9DfmH-mNOVKR60nUt41T2wfnNeaamAsS7b8MjQkH4HEUZKuyZvamVMPav-hjo3WLYRw8vOFKrt1Pd-jU_nr1KkEyJL6GtMfMmtYOFYZwV5sb7chW6hySMM2RdTJnlS9MLgmVEPoQ-L7LtnWa2z_EOuOXFccbSy_NCT7PnylRYapZ8EGOGALH0DIkdFYWgUF5W-qnqPmgAM3LpT2SUMpqogzcuvhcEwQ50ju7Sg6sHCTnrlhYPVV0tXI2Yeu3UeQ_zZM7-2A4Z-NCWDAbJQzL9_zqjj0fXhop4LMaUYvJ_AO4aoEzDRb-nz-S6nwjzqxSoH8YRUbXUk9VIU0JtUzIX1wcPFjRtt7Qi8nwFIa5JnjVHIdzpyBBOHkDxKBK2PPlAgeCixtYIz6hMrH_I2uvmnNaXc';
$url = "https://connect.mailerlite.com/api/subscribers/".$subscriber_id;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Bearer ' . $token ));
$result = curl_exec($ch);
curl_close($ch);
$mailerlitedata = json_decode($result)->data;
if(!isset($mailerlitedata->status)) {
    header("Location:nordzypern-immobilien.html");
}
if($mailerlitedata->status !== "active" ) {
    header("Location:nordzypern-immobilien.html");
}
$correctGroup = false;
foreach($mailerlitedata->groups as $group){
    if($group->id === "95379137704756359") {
        $correctGroup = true;
    }
}
if(!$correctGroup) {
    header("Location:nordzypern-immobilien.html");
}
$_SESSION["subscriber"] = $subscriber_id;

//check if confirmed

//then check if they have started the video before:

  //  $mysqli = new mysqli('localhost', 'root', '', 'zypern_video_watchers');
    $mysqli = new mysqli('sql419.your-server.de', 'nordzyu_1', 'fCK1fvR4hsb2bCMU', 'nordzyu_db1');
if ($mysqli->connect_errno) {
    throw new RuntimeException('mysqli connection error: ' . $mysqli->connect_error);
}
$result  = $mysqli->query("SELECT UNIX_TIMESTAMP(`time_start_watch`) as time,TIMESTAMPDIFF(HOUR,`time_start_watch`,NOW()) as difference FROM `video_watchers` WHERE email = '$subscriber_id'");
if($result->num_rows === 0) {
  
        $new_query = "INSERT INTO `video_watchers` ( `subscriber_id`, `email`) VALUES ('$mailerlitedata->id', '$subscriber_id');";
        $mysqli->query($new_query);
    $result->free_result();
    $result  = $mysqli->query("SELECT UNIX_TIMESTAMP(`time_start_watch`) as time,TIMESTAMPDIFF(HOUR,`time_start_watch`,NOW()) as difference FROM `video_watchers` WHERE email = '$subscriber_id'");
}

$timeFromDb = "1691836773";
$get_current_user ="";
$difference = "0";
while ($row = $result->fetch_assoc()) { 
    $timeFromDb =  $row["time"]; 
    $difference = $row["difference"];

}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <title>Unvergleichliches Nordzypern</title>
    <meta charset="UTF-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="description" content="Investieren in Nordzypern - mit NORDZYPERN.KAUFEN. Die Medview Homes Ltd. bietet Immobilien Investoren eine hohe, erdbebensichere Bauqualität , eine exklusive Lage in direkter Strandnähe und ein durchdachtes Vermarktungskonzept, falls Sie Ihre Immobilie nach Fertigstellung vermieten möchten; in der Summe also einen hohen Return on Investment .
    " />
    <meta name="keywords" content="Nordzypern, Investment, Nordzypern Immobilien, Seaviewtowers, Seaviewtowers Projekt, Nordzypern relocation, Nordzypern auswandern" />
    <!-- <style>body{opacity: 0;}</style> -->
    <link rel="stylesheet" href="css/style.min.css?_v=20230809143013" />
    <link rel="shortcut icon" href="favicon.ico" />
    <!-- <meta name="robots" content="noindex, nofollow"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="wrapper wrapper-watch">
        <main class="watch">
            <!-- Section with a timer -->
            <div class="watch__top top-watch">
                <div class="top-watch__container">
                    <h2 class="top-watch__title">Video-Zugang wird gesperrt in:</h2>
                    <div id="big-timer" class="top-watch__timer timer">
                        <div class="timer__circle circle-days">
                            <svg>
                                <circle id="days-circle" r="18" cx="20" cy="20"></circle>
                            </svg>
                            <div id="demo-days" data-days="3" class="timer__days"></div>
                        </div>

                        <div class="timer__circle circle-hours">
                            <svg>
                                <circle id="hours-circle" r="18" cx="20" cy="20"></circle>
                            </svg>
                            <div id="demo-hours" data-time="10" class="timer__hours"></div>
                        </div>

                        <div class="timer__circle circle-minutes">
                            <svg>
                                <circle id="minutes-circle" r="18" cx="20" cy="20"></circle>
                            </svg>
                            <div id="demo-minutes" data-time="10" class="timer__minutes"></div>
                        </div>

                        <div class="timer__circle circle-seconds">
                            <svg>
                                <circle id="seconds-circle" r="18" cx="20" cy="20"></circle>
                            </svg>
                            <div id="demo-seconds" class="timer__seconds"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Video Section -->
        <?php
        if($difference > 48) {
            ?>
                <div><p>You do no longer have access to this video.</p></div>
            <?php
        }
        else {
            ?>
        
            <section class="watch__content" id="main_watch_content">
                <h1 class="watch__title">Der einfachste Verkaufsprozess der Welt (Zum Starten ins Video klicken)</h1>
                <div class="watch__container">
                    <div class="watch__video">
                        <!-- Add video-code here below -->
                        <div class="watch__wistia wistia_embed wistia_async_t8i6dcrt4d"></div>
                        <div class="watch__cover cover-watch">
                            <div class="cover-watch__body">
                                <h2 class="cover-watch__title">Der <span>einfachste Funnel</span> der Welt</h2>

                                <div class="cover-watch__circle">
                                    <svg width="140" height="140">
                                        <circle cx="70" cy="70" r="65" stroke="#3c7c98" stroke-width="6" fill="transparent" />
                                    </svg>
                                </div>
                                <div class="cover-watch__corner">
                                    <img src="img/corner.png" alt="Corner" />
                                </div>
                                <div class="cover-watch__call-to-action">
                                    <div class="cover-watch__arrow">
                                        <img src="img/icons/arrow.svg" alt="Arrow" />
                                    </div>
                                    <div class="cover-watch__text">Hier klicken und abspielen</div>
                                </div>
                            </div>
                        </div>
                        <button class="watch__start-button player-button">
                            <div class="player-button__triangle"></div>
                        </button>
                        <button class="watch__play-button player-button">
                            <div class="player-button__triangle"></div>
                        </button>
                        <button class="watch__pause-button player-button">
                            <div class="player-button__line"></div>
                            <div class="player-button__line"></div>
                        </button>
                        <button class="watch__restart-button player-button">
                            <div class="player-button__restart"></div>
                        </button>
                    </div>
                    <a href="#" data-popup="#watch-reg" class="watch__button button">Hier Klicken</a>
                </div>
            </section>
        <?php } ?>
        </main>
        <footer class="watch__footer second-footer footer">
            <div class="footer__container">
                <ul class="footer__list list-footer">
                    <li class="list-footer__item">
                        <a href="#" class="list-footer__link">Impressum</a>
                    </li>
                    <li class="list-footer__item">
                        <a href="#" class="list-footer__link">Datenschutz</a>
                    </li>
                    <li class="list-footer__item">
                        <a href="#" class="list-footer__link">AGB</a>
                    </li>
                </ul>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js?_v=20230809143013"></script>
    <script>
        window.addEventListener("load", windowLoad);

        function windowLoad() {
            function set_timer(block, time_end, function_result) {
                let timer,
                    start,
                    end,
                    _second = 1000,
                    _minute = _second * 60,
                    _hour = _minute * 60,
                    _day = _hour * 24,
                    set_storage = () => {
                        if (!localStorage.getItem("timer_start_" + set_timer.count)) {
                            let now = new Date();

                            localStorage.setItem("timer_start_" + set_timer.count,<?php echo $timeFromDb ?>);
                        }
                    },
                    update_settings = () => {
                        start = end = <?php echo $timeFromDb ?>;

                        end = new Date(+end * 1000);
                        end.setDate(end.getDate() + time_end[0]);
                        end.setHours(end.getHours() + time_end[1]);
                        end.setMinutes(end.getMinutes() + time_end[2]);
                        end.setSeconds(end.getSeconds() + time_end[3]);
                        end = +end;
                    },
                    get_timer = function(distance) {
                        let days = Math.floor(distance / _day),
                            hours = Math.floor((distance % _day) / _hour),
                            minutes = Math.floor((distance % _hour) / _minute),
                            seconds = Math.floor((distance % _minute) / _second);
                        return [days, hours, minutes, seconds];
                    },
                    set_values = () => {
                        let now = new Date(),
                            distance = end - +now;
                        let daysDemo = document.querySelector(".timer__days");
                        let hoursDemo = document.querySelector(".timer__hours");
                        let minutesDemo = document.querySelector(".timer__minutes");
                        let secondsDemo = document.querySelector(".timer__seconds");

                        const daysCircle = document.getElementById("days-circle");
                        const hoursCircle = document.getElementById("hours-circle");
                        const minutesCircle = document.getElementById("minutes-circle");
                        const secondsCircle = document.getElementById("seconds-circle");
                       
                        if (distance <= 0) {
                            // function_result(block);
                            document.getElementById("main_watch_content").innerHTML = " <div><p>You do no longer have access to this video.</p></div>";
                            clearInterval(timer);
                            daysDemo.innerHTML = "0";
                            hoursDemo.innerHTML = "0";
                            minutesDemo.innerHTML = "0";
                            secondsDemo.innerHTML = "0";
                            
                        } else {
                            //   markup = create_markup(timer);
                            let timer = get_timer(distance);

                            daysDemo.innerHTML = timer[0];
                            hoursDemo.innerHTML = timer[1];
                            minutesDemo.innerHTML = timer[2];
                            secondsDemo.innerHTML = timer[3];

                            const daysCircle = document.getElementById("days-circle");
                            const hoursCircle = document.getElementById("hours-circle");
                            const minutesCircle = document.getElementById("minutes-circle");
                            const secondsCircle = document.getElementById("seconds-circle");

                            daysCircle.style.strokeDashoffset = 0;
                            hoursCircle.style.strokeDashoffset = 113 - (113 * timer[1]) / 24;
                            minutesCircle.style.strokeDashoffset = 113 - (113 * timer[2]) / 60;
                            secondsCircle.style.strokeDashoffset = 113 - (113 * timer[3]) / 60;
                        }

                        if (daysDemo.innerHTML == 0) {
                            daysCircle.style.strokeDashoffset = 113;
                        }
                        if (hoursDemo.innerHTML == 0) {
                            hoursCircle.style.strokeDashoffset = 113;
                        }
                        if (minutesDemo.innerHTML == 0) {
                            minutesCircle.style.strokeDashoffset = 113;
                        }
                        if (secondsDemo.innerHTML == 0) {
                            secondsCircle.style.strokeDashoffset = 113;
                        }
                    },
                    init = () => {
                        set_timer.count == undefined ? (set_timer.count = 1) : set_timer.count++;

                        set_storage();
                        update_settings();
                        timer = setInterval(set_values, 1000);

                        return timer;
                    };

                return init();
            }

            set_timer($(".block"), [2, 0, 0, 0], function(block) {});
        }
        
    </script>
    <!-- Add video-code here below -->
    <script src="https://fast.wistia.com/embed/medias/t8i6dcrt4d.jsonp?_v=20230809143013" async></script>
    <script src="https://fast.wistia.com/assets/external/E-v1.js?_v=20230809143013" async></script>
    <!-- Add video-code in this script -->
    <script>
        window.addEventListener("load", windowLoad);
function register_video_watch(){
    var timeofFirstView= false;
}
        function windowLoad() {
            const wistiaVideo = document.querySelector(".watch__wistia");
            const startButton = document.querySelector(".watch__start-button");
            const playButton = document.querySelector(".watch__play-button");
            const pauseButton = document.querySelector(".watch__pause-button");
            const restartButton = document.querySelector(".watch__restart-button");
            const videoCover = document.querySelector(".watch__cover");

            window._wq = window._wq || [];
            _wq.push({
                id: "t8i6dcrt4d", // add video-code in quotes
                onReady(video) {
                    video.disablePictureInPicture = true;
                    video.bind("play", function() {
                        pauseButton.classList.add("_active");
                        playButton.classList.remove("_active");
                        
                    });
                    video.bind("pause", function() {
                        pauseButton.classList.remove("_active");
                        playButton.classList.add("_active");
                    });
                    video.bind("end", function() {
                        playButton.classList.remove("_active");
                        pauseButton.classList.remove("_active");
                        restartButton.classList.add("_active");
                    });
                    video.bind("play", function() {
                        restartButton.classList.remove("_active");
                        register_video_watch();
                    });
                    startButton.addEventListener("click", function(e) {
                        e.preventDefault;
                        video.play();
                        videoCover.classList.add("_close");
                        startButton.classList.add("_close");
                    });
                    wistiaVideo.addEventListener("click", function(e) {
                        e.preventDefault;
                        video.play();
                        videoCover.classList.add("_close");
                        startButton.classList.add("_close");
                    });
                    playButton.addEventListener("click", function(e) {
                        e.preventDefault;
                        video.play();
                    });
                    pauseButton.addEventListener("click", function(e) {
                        e.preventDefault;
                        video.pause();
                    });
                    restartButton.addEventListener("click", function(e) {
                        e.preventDefault;
                        video.play();
                    });
                    
               },
            });
            
        }
    </script>
    <div id="zoom-reg" aria-hidden="true" class="popup">
        <div class="popup__wrapper">
            <div class="popup__content">
                <button data-close type="button" class="popup__close"></button>
                <h2 class="popup__title">Sichere dir das Geheim-Video kostenlos</h2>
                <form action="save-extra-data.php" class="popup__form form-zoom">
                    <label for="first-name" class="form-zoom__label form-zoom__label_name">
                        <input type="text" id="first-name" name="first-name" placeholder="Vorname" required class="form-zoom__input" />
                    </label>
                    <label for="last-name" class="form-zoom__label form-zoom__label_name">
                        <input type="text" id="last-name" name="last-name" placeholder="Nachname" required class="form-zoom__input" />
                    </label>
                    <label for="user-email" class="form-zoom__label form-zoom__label_email">
                        <input type="email" id="user-email" name="user-email" placeholder="E-mail" required class="form-zoom__input" />
                    </label>
                    <button type="submit" class="form-zoom__button button">Weiter zum Video</button>
                </form>
                <div class="popup__description">
                    <p>Nachden du dich angemeldet hast, hast du nur weing Zeit, um dir das Video anzusehen - lass dir also nicht zu viel Zeit!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-up on watch page -->
    <div id="watch-reg" aria-hidden="true" class="popup watch-popup">
        <div class="popup__wrapper">
            <div class="popup__content">
                <div class="popup__block-header block-header">
                    <div class="block-header__icon">
                        <svg width="64" height="60" viewBox="0 0 64 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M64 51.4601C64 49.9401 62.77 45.8801 61.25 45.8801C59.73 45.8801 58.5 49.9401 58.5 51.4601C58.5 52.7301 59.37 53.7801 60.53 54.1001V57.7601H55.87V1.53006C55.87 1.13006 55.55 0.810059 55.15 0.810059H26C25.6 0.810059 25.28 1.13006 25.28 1.53006V14.8801L7.97 19.0501C7.65 19.1301 7.42 19.4201 7.42 19.7501V57.7601H3.47V54.1001C4.64 53.7801 5.5 52.7301 5.5 51.4601C5.5 49.9401 4.27 45.8801 2.75 45.8801C1.23 45.8801 0 49.9401 0 51.4601C0 52.7301 0.87 53.7801 2.03 54.1001V57.7601H1.13C0.73 57.7601 0.41 58.0801 0.41 58.4801C0.41 58.8801 0.73 59.2001 1.13 59.2001H62.26C62.66 59.2001 62.98 58.8801 62.98 58.4801C62.98 58.0801 62.66 57.7601 62.26 57.7601H61.96V54.1001C63.14 53.7901 64 52.7301 64 51.4601ZM14.78 57.7601V48.5001C14.78 45.9701 16.84 43.9101 19.37 43.9101C21.9 43.9101 23.96 45.9701 23.96 48.5001V57.7601H14.78ZM25.39 57.7601V48.5001C25.39 45.1801 22.69 42.4801 19.37 42.4801C16.05 42.4801 13.35 45.1801 13.35 48.5001V57.7601H8.86V20.3101L29.88 15.2401V57.7601H25.39ZM53.35 57.7601H49.01V44.8701H41.96V57.7601H37.65V44.8701H34.42V57.7601H31.32V14.3301C31.32 14.1101 31.22 13.9001 31.05 13.7701C30.88 13.6301 30.65 13.5801 30.44 13.6401L26.73 14.5401V2.24006H54.45V57.7601H53.35Z" fill="black" />
                            <path d="M28.76 4.54004H52.39V9.29004H28.76V4.54004Z" fill="black" />
                            <path d="M33.54 12.48H52.4V17.23H33.54V12.48Z" fill="black" />
                            <path d="M33.54 20.4199H52.4V25.1699H33.54V20.4199Z" fill="black" />
                            <path d="M33.54 28.3501H52.4V33.1001H33.54V28.3501Z" fill="black" />
                            <path d="M33.54 36.29H52.4V41.04H33.54V36.29Z" fill="black" />
                            <path d="M11.03 21.5801H15.15V25.3001H11.03V21.5801Z" fill="black" />
                            <path d="M17.3101 21.5801H21.4301V25.3001H17.3101V21.5801Z" fill="black" />
                            <path d="M23.59 21.5801H27.71V25.3001H23.59V21.5801Z" fill="black" />
                            <path d="M11.03 26.9102H15.15V30.6302H11.03V26.9102Z" fill="black" />
                            <path d="M17.3101 26.9102H21.4301V30.6302H17.3101V26.9102Z" fill="black" />
                            <path d="M23.59 26.9102H27.71V30.6302H23.59V26.9102Z" fill="black" />
                            <path d="M11.03 32.2402H15.15V35.9602H11.03V32.2402Z" fill="black" />
                            <path d="M17.3101 32.2402H21.4301V35.9602H17.3101V32.2402Z" fill="black" />
                            <path d="M23.59 32.2402H27.71V35.9602H23.59V32.2402Z" fill="black" />
                            <path d="M11.03 37.5601H15.15V41.2801H11.03V37.5601Z" fill="black" />
                            <path d="M17.3101 37.5601H21.4301V41.2801H17.3101V37.5601Z" fill="black" />
                            <path d="M23.59 37.5601H27.71V41.2801H23.59V37.5601Z" fill="black" />
                            <path d="M22.1501 50.71C21.6201 50.71 21.1801 51.15 21.1801 51.68C21.1801 52.21 21.6201 52.64 22.1501 52.64C22.6801 52.64 23.1101 52.21 23.1101 51.68C23.1101 51.15 22.6801 50.71 22.1501 50.71Z" fill="black" />
                        </svg>
                    </div>
                    <h2 class="block-header__title title">Deine Angaben fur die nestmogliche Beratung</h2>
                </div>
                <button data-close type="button" class="popup__close"></button>
                <h2 class="popup__title">Wie durfen wir Kontakt zu dir aufnehmen?</h2>
                <form action="save-extra-data.php" id="extra-data-form" method="POST" class="popup__form form-zoom">
                    <label for="user-name" class="form-zoom__label form-zoom__label_name">
                        <input type="text" id="user-name" name="user-name" placeholder="Vor-und Nachname" required class="form-zoom__input" />
                    </label>
                    <label for="email" class="form-zoom__label form-zoom__label_email">
                        <input type="email" id="email" name="user-email" placeholder="Deine E-mail Adresse" required class="form-zoom__input" />
                    </label>
                    <label for="user-phone" class="form-zoom__label form-zoom__label_phone">
                        <input type="tel" id="user-phone" name="user-phone" placeholder="Deine Telefonnummer (optional)" class="form-zoom__input" />
                    </label>
                    <label for="user-whatsapp" class="form-zoom__label form-zoom__label_whatsapp">
                        <input type="tel" id="user-whatsapp" name="user-whatsapp" placeholder="Deine Whatsapp (optional)" class="form-zoom__input" />
                    </label>
                    <div class="form-zoom__line-message">
                        <textarea class="form-zoom__textarea" placeholder="Beste Erreichbarkeit (optional)" name="user-message"></textarea>
                    </div>

                    </label>
                    <div class="form-zoom__line">
                        <input type="checkbox" id="user-agree" name="user-agree" required class="form-zoom__input form-zoom__input_checkbox" />
                        <label for="user-agree" class="form-zoom__label form-zoom__label_agree">Ich akzeptiere <a href="#" target="_blank" class="form-zoom__link">Datenschutz Page</a></label>
                    </div>

                    <button type="submit" class="form-zoom__button button">Unverbindliche Infos anfordern</button>
                </form>
                <div id="sucess-message" style="display:none;
                            border: 1px solid #3c7c98;
                            border-radius: 20px;
                            padding: 1rem;
                            margin: 1rem;
                            text-align: center;"><span>Vielen Dank, wir haben Ihre Informationen erhalten und werden uns so schnell wie möglich bei Ihnen melden.</span></div>
                    </div>
                <div class="popup__description">Deine Daten werden vertraulich behandelt</div>
            </div>
        </div>
    </div>
    <script src="js/app.min.js?_v=20230809143013"></script>
    <script>
         async function postJSON() {
            try {
                var formData = new FormData(document.querySelector('#extra-data-form'))
                const data = new URLSearchParams(formData);

              const response = await fetch("save-extra-data.php", {
                method: "POST", // or 'PUT'
                headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
                },
                body: data,
              });
          
              const result = await response.json();
              console.log("Success:", result);
              document.getElementById('sucess-message').style.display ="block";
            
            document.getElementById("extra-data-form").style.display = "none"
             return result
            } catch (error) {
              console.error("Error:", error);
             return error
            }
          }

        jQuery("#extra-data-form").on("submit",function(e){
            e.stopPropagation();
            var form =   jQuery('#extra-data-form');
        // Handle the form data
        event.preventDefault();
        this.reportValidity();
        postJSON();
        });
    </script>
</body>

</html>
