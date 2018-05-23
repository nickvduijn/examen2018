<?php
    //config bestand en helper inladen
    require_once 'config.php';
    include 'helper.php';
    // Helper class toevoegen
    $helper = new Helper();
    // Sessie starten
    session_start();

    if(isset($_SESSION['data'])) {
        header('location: home.php');
    }

    //check of op de login button is geklikt zoja voer login method in helper.php uit.
    if(isset($_POST['login'])) {
        $result = $helper->login($mysqli, $_POST['email'], $_POST['password']);
        if(is_array($result)) {
            $_SESSION['data'] = $result;
            header('location: home.php');
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Alle CSS  bestanden en CSS CDN's -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css" type="text/css" />

        <title>GLR - Stage ervaring</title>

    </head>
    <body class="body-login">
        <div class="contrainer">
            <div class="login-container">
                <div class="login-logo">
                    <a class="navbar-brand" href="#"><img src="images/glr.gif" width="100" height="100" class="d-inline-block align-top" alt="" style="margin-right: 10px;"></a>
                </div>
                <?php if(!empty($result)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $result;?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>
                <?php if(!empty($_GET['msg'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_GET['msg'];?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="login-box">
                    <div class="login-content">
                        <h3>Welkom bij stage ervaring!</h3>
                        <p>Log hier in om stage ervaringen van leerlingen te bekijken of om zelf iets te plaatsen.</p>
                        <hr>
                        <!-- login formulier -->
                        <form method="post" action="">
                            <div class="form-group">
                                <label>E-mailadres:</label><br />
                                <input type="email" id="email "name="email" placeholder="E-mailadres..." required />
                            </div>
                            <div class="form-group">
                                <label>Wachtwoord:</label><br />
                                <input type="password" id="password" name="password" placeholder="Wachtwoord..." required />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" name="login" value="Log in" />
                            </div>
                        </form>
                        <!-- /einde login formulier -->
                        <hr>
                        <small>Lukt het niet met inloggen? Vraag naar je mentor voor jouw gegevens.</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alle JavaScript/jQuery bestanden of CDN's -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </body>
</html>