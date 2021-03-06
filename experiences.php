<?php
//config bestand en helper inladen
require_once 'config.php';
include 'helper.php';
// Helper class toevoegen
$helper = new Helper();
// Sessie starten
session_start();
//Check of je bent ingelogd.
if(!isset($_SESSION['data'])) {
    header('location: index.php');
}
//Haalt het bedrijf op door id te halen uit de GET
$company = $helper->getCompanyById($mysqli, $_GET['id']);
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

    <?php if($_SESSION['data']['group_id'] < 2 && !empty($_SESSION['data']['company_id'])) : ?>
        <?php if(!$helper->getPostByUserId($mysqli, $_SESSION['data']['id'])) : ?>
            <div class="button-container">
                <a href="create.php"><button type="button" class="btn btn-success">Schrijf een ervaring!</button></a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <!-- Loop door alle opgehaalde geschreven ervaringen d.m.v. het bedrijfs id mee te geven aan de functie. (via helper.php) -->
    <div class="search-container">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Zoeken</span>
            </div>
            <input type="text" id="searchbar" class="form-control" placeholder="Zoek een ervaring.." aria-label="Zoeken" aria-describedby="basic-addon1">
        </div>
    </div>
    <div class="big-container extra-l">
        <div class="t-content">
            <?php $experiences = $helper->getExperienceByCompanyId($mysqli, $_GET['id']); ?>
            <?php if(!$experiences) :?>
            Geen ervaringen gevonden
            <?php else : ?>
            <table class="table table-hover">
                <tbody>
                <?php foreach($experiences as $item) : ?>
                <?php $date = new DateTime($item['created']); ?>
                <?php $user = $helper->getUserById($mysqli, $item['created_by_id']); ?>
                    <tr class='clickable-row sfilter' data-href='experience.php?id=<?php echo $item['id']; ?>'>
                        <td><strong><?php echo $item['title']; ?></strong></td>
                        <td>Gepubliceerd op: <i><?php echo $date->format('d-m-Y H:i'); ?></i></td>
                        <td>Geschreven door: <i><?php echo $user[0]['fullname']; ?></i></td>
                        <td>Cijfer: <strong><?php echo $item['rating']; ?></strong><small>/10</small></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($company[0]['name'])) : ?>
    <div class="info-container">
        <div class="info-content">
            <h3>Bedrijfsgegevens</h3>
            <hr>
            <label>Naam: </label> <strong><?php echo $company[0]['name']; ?></strong><br/>
            <label>Adres: </label> <strong><?php echo $company[0]['street']; ?>, <?php echo $company[0]['postal']; ?>, <?php echo $company[0]['city']; ?></strong><br/>
            <label>Naam praktijkbegeleider: </label> <strong><?php echo $company[0]['contact_name']; ?></strong><br/>
            <label>E-mail praktijkbegeleider: </label> <strong><?php echo $company[0]['contact_email']; ?></strong><br/>
            <label>Telefoonnummer: </label> <strong><?php echo $company[0]['phone']; ?></strong><br/>
            <?php if(!empty($company[0]['website'])) : ?><label>Website: </label> <strong><a href="<?php echo $company[0]['website']; ?>" target="_blank"><?php echo $company[0]['website']; ?></a></strong><br/><?php endif;?>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="footer">Dit project is onderdeel van het examen <strong>Mediatechnologie, Applicatie en Mediaontwikkeling</strong>. Dit project is ontwikkeld door: <strong>Nick van Duijn (78408)</strong></strong></div>

<!-- Alle JavaScript/jQuery bestanden of CDN's -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="js/main.js" type="text/javascript"></script>
</body>
</html>