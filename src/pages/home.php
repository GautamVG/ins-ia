<?php include_once(dirname(__DIR__) . "/bootstrap.php") ?>

<?php 
    include_once(PROJECT_ROOT . "lib/db.php");
    include_once(PROJECT_ROOT . "lib/redirect.php");
?>

<?php 
    session_start();
    if (!(isset($_SESSION) && isset($_SESSION['svvid']))) Redirect\toLoginPage();
?>

<?php 
    $db = DB\connect();
    try {
        $slots = [];
        $date = date("Y:m:d");
        $query = "SELECT `start_time`, `end_time`, `user`.`name` as `name`, `ground`.`name` as `ground_name` FROM `booking`, `user`, `ground` WHERE `svvid` = `user_svvid` AND `booking`.`ground` = `ground`.`id` AND `date` = '$date';";
        $results = $db->query($query);
        if ($results) $slots = $results->fetchAll();
    } catch (Exception $err) {
        Redirect\toErrorPage($err->getMessage());
    }

    function formatTimeInstant($timeStr) {
        return date("H:i", strtotime($timeStr));
    }

    function formatTimePeriod($timeStr) {
        return strtoupper(date("a", strtotime($timeStr)));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <style>
        <?php 
            include_once(PROJECT_ROOT . "styles/base.css");
            include_once(PROJECT_ROOT . "styles/home.css");
        ?>
    </style>
    <title>Home | ZSchedule</title>
</head>
<body>
    <div class="app-bar">
        <div class="container">
            <i class="ph-user-circle"></i>
            <h3 class="app-bar-title">
                <?php 
                    echo $_SESSION['svvid']
                ?>
            </h3>
            <a href="./logout.php" class="logout">
                <i class="ph-sign-out"></i>
            </a>
        </div>
    </div>
    <main class="container">
        <h1>Today's schedule</h1>
        <div class="slots">
            <?php 
                if (count($slots) == 0) {
                    ?>
                        <h2>No slots booked</h2>
                    <?php
                } else {
                    foreach ($slots as $slot) {
                        ?> 
                            <div class="slot">
                                <div class="top">
                                    <div class="time-details">
                                        <i class="ph-clock"></i>
                                        <div class="start time">
                                            <h3 class="instant">
                                                <?php echo formatTimeInstant($slot['start_time']) ?>
                                            </h3>
                                            <h4 class="period">
                                                <?php echo formatTimePeriod($slot['start_time']) ?>
                                            </h4>
                                        </div>
                                        <div class="end time">
                                            <h3 class="instant">
                                                <?php echo formatTimeInstant($slot['end_time']) ?>
                                            </h3>
                                            <h4 class="period">
                                                <?php echo formatTimePeriod($slot['end_time']) ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="booking-details">
                                        <p>Booked by</p>
                                        <h3>
                                            <?php echo $slot['name'] ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <div class="ground-name">
                                        <i class="ph-map-pin"></i>
                                        <p>
                                            <?php echo $slot['ground_name'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>
        </div>
        <a href="./book.php" class="book-btn">Book a slot</a>
    </main>
</body>
</html>