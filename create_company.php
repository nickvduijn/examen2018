<?php
//config bestand en helper inladen
require_once 'config.php';
include 'helper.php';
// Helper class toevoegen
$helper = new Helper();
// Sessie starten
session_start();

if(!isset($_SESSION['data'])) {
    header('location: index.php');
}

if($_SESSION['data']['group_id'] < 2) {
    header('location: home.php');
}

if(isset($_POST['create'])) {
    if($helper->save($mysqli, 'company', $_POST)) {
        header('location: create_company.php?msg=Bedrijf toegevoegd!');
    } else {
        header('location: create_company.php?error=Bedrijfsnaam bestaat al!');
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
<body>
<nav class="navbar navbar-expand-lg navbar-main">
    <div class="container">
        <a class="navbar-brand" href="home.php"><img src="images/glr.gif" width="30" height="30" class="d-inline-block align-top" alt="" style="margin-right: 10px;">Stage ervaringen</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <?php if($_SESSION['data']['group_id'] > 1) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="companies.php">Bedrijven overzicht</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="students.php">Studenten overzicht</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create_company.php">Voeg bedrijf toe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create_student.php">Voeg leerling toe</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Uitloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<?php if(!empty($_GET['msg'])) : ?>
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_GET['msg'];?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<?php if(!empty($_GET['error'])) : ?>
    <div class="container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_GET['error'];?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<div class="container">
    <div class="big-container">
        <div class="exp-content">
            <h3>Voeg een Bedrijf toe</h3>
            <hr>
            <form method="post" action="">
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Naam bedrijf..." required>
                </div>
                <div class="form-group">
                    <label for="street">Straat</label>
                    <input type="text" name="street" class="form-control" id="street" placeholder="Straat & huisnummer..." required>
                </div>
                <div class="form-group">
                    <label for="postal">Postcode</label>
                    <input type="text" name="postal" class="form-control" id="postal" placeholder="Postcode..." required>
                </div>
                <div class="form-group">
                    <label for="city">Plaats</label>
                    <input type="text" name="city" class="form-control" id="city" placeholder="Plaats..." required>
                </div>
                <div class="form-group">
                    <label for="contact_name">Naam praktijkbegeleider</label>
                    <input type="text" name="contact_name" class="form-control" id="contact_name" placeholder="Naam praktijkbegeleider..." required>
                </div>
                <div class="form-group">
                    <label for="contact_email">E-mail praktijkbegeleider</label>
                    <input type="text" name="contact_email" class="form-control" id="contact_email" placeholder="E-mail praktijkbegeleider..." required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefoonnummer</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefoonnummer..." required>
                </div>
                <div class="form-group">
                    <label for="website">Website <small>(Niet verplicht)</small></label>
                    <input type="text" name="website" class="form-control" id="website" placeholder="(vb: http://website.nl)">
                </div>
                <input type="submit" class="btn btn-primary" name="create" value="Opslaan" />
            </form>
        </div>
    </div>
</div>

<div class="footer">Dit project is onderdeel van het examen <strong>Mediatechnologie, Applicatie en Mediaontwikkeling</strong>. Dit project is ontwikkeld door: <strong>Nick van Duijn (78408)</strong></strong></div>

<!-- Alle JavaScript/jQuery bestanden of CDN's -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>