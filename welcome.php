<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>
<header>
    <!-- <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1> -->
    <div class="container">
        <p><a href="reset-password.php" class="btn btn-warning">Reset Your Password</a></p>
        <div class="row" style="margin-top: 4%;">
            <div class="col" style="background-color: antiquewhite;">
                <h3 style="">welcome <?php echo htmlspecialchars($_SESSION["username"]); ?></h3>
            </div>
            <div class="col">
                <a href="add.php" class="btn btn-success ml-3">add Movie</a>
            </div>
            <div class=" col" style="margin-left: auto;">
                <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
            </div>
        </div>


    </div>
</header>

<body>
    <div class="container" style="font-size: 18px; margin-top:2%">
        <div class=" row" style="background-color: blanchedalmond;">
            <div class="col-1">
                ลำดับ
            </div>
            <div class="col">
                โปรเตอร์หนัง
            </div>
            <div class="col-2">
                ปีที่ฉาย
            </div>
            <div class="col">
                ชื่อเรื่อง
            </div>
            <div class="col">
                จัดการ
            </div>
        </div>
    </div>

    <?php
    // require_once "server.php";
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;

    require __DIR__ . '/vendor/autoload.php';

    $app = AppFactory::create();
    $app->setBasePath('/login_v1');

    $app->get('/welcome.php', function (Request $request, Response $response, array $args) {
        require_once "config.php";
        $sql = 'SELECT * FROM `users`';
        $resul = $link->query($sql);        //recors set
        $data = array();

        while ($row = $resul->fetch_assoc()) {
            array_push($data, $row);
            $id = $row['idmovie'];
            $poster = $row['poster'];
            $date = $row['year'];
            $namemovie = $row['namemovie'];
    ?>
            <div class="container" style="font-size: 16px;""> 
                         <div class=" center">
                <div class="row">
                    <div class="col-1">
                        <?php echo $row["idmovie"]  ?>
                    </div>
                    <div class="col">
                        <img src="<?php echo $row["poster"] ?>" width="150" height="200">
                    </div>
                    <div class="col-2">
                        <?php echo $row["year"] ?>
                    </div>
                    <div class="col">
                        <?php echo $row["namemovie"]  ?>
                    </div>
                    <div class="col">
                        <input type="button" class="btn btn-warning" name="btnConfirm" value="แก้ไข" OnClick="chkConfirm_update()">
                        <input type="button" class="btn btn-danger" name="btnConfirm" value="ลบ" OnClick="chkConfirm_delete()">

                        <script language="JavaScript">
                            function chkConfirm_delete() {
                                if (confirm('คุณต้องการจะลบภาพยนต์เรื่อง <?php echo $row["namemovie"]  ?> ใช่หรือไม่') == true) {
                                    // alert('welcome.php');
                                    // window.location = 'welcome.php';

                                    header("location: login.php");
                                }
                            }

                            function chkConfirm_update() {

                                if (confirm('คุณต้องการจะแก้ไขภาพยนต์เรื่อง <?php echo $row["namemovie"]  ?> ใช่หรือไม่') == true) {
                                    // alert('welcome.php');
                                    // window.location = 'welcome.php';
                                    header("location: login.php");
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
            </div>
    <?php
        }
        $json = json_encode($data);

        $response->getBody()->write($json);
        // return $response->withHeader('Content-Type','application/json');
        return $response;
    });
    $app->run();
    ?>
</body>

</html>