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

<div class="container">

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

    <div class="big-container extra-l">
        <div class="t-content">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>Bedrijfsnaam</th>
                    <th>Praktijkbegeleider</th>
                    <th>E-mailadres</th>
                    <th>Telefoonnummer</th>
                    <th>Website</th>
                </tr>
                <?php $companies = $helper->getAllCompanies($mysqli); ?>
                <?php foreach($companies as $company) : ?>
                    <tr class="clickable-row" data-href="company.php?id=<?php echo $company['id']; ?>">
                        <td><?php echo $company['name']; ?></td>
                        <td><?php echo $company['contact_name']; ?></td>
                        <td><?php echo $company['contact_email']; ?></td>
                        <td><?php echo $company['phone']; ?></td>
                        <td><?php if(!empty($company['website'])) : ?><?php echo $company['website']; ?><?php else : ?><i>Geen website ingevoerd</i><?php endif;?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="info-container">
        <div class="info-content">
            <h3>Jouw gegevens</h3>
            <hr>
            <label>Naam: </label> <strong><?php echo $_SESSION['data']['fullname']; ?></strong><br/>
            <label>E-mailadres: </label> <strong><?php echo $_SESSION['data']['email']; ?></strong><br/>
            <label>Klas: </label> <strong><?php echo $_SESSION['data']['class']; ?></strong><br/>
        </div>
    </div>
</div>

<div class="footer">Dit project is onderdeel van het examen <strong>Mediatechnologie, Applicatie en Mediaontwikkeling</strong>. Dit project is ontwikkeld door: <strong>Nick van Duijn (78408)</strong></strong></div>

<!-- Alle JavaScript/jQuery bestanden of CDN's -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>