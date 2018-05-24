<?php
//config bestand en helper inladen
require_once 'config.php';
include 'helper.php';
// Helper class toevoegen
$helper = new Helper();
// Sessie starten
session_start();
//Kijkt of je bent ingelod.

if(!isset($_SESSION['data'])) {
    header('location: index.php');
}
// Wanneer er op de delete knop is gedrukt wordt de data verwijderd uit de database (via de helper.php)
if(isset($_POST['delete'])) {
    if($helper->delete($mysqli, 'experience', $_GET)) {
        header('location: home.php?msg=Geschreven ervaring is verwijderd!');
    } else {
        header('location: student.php?id='.$_POST['id'] .'error=Er ging iets mis!');
    }
}
// Hier haal ik alle gegevens die ik wil weergeven, eerst haal de gegevens van het bericht op en op basis daarvan kan ik via de functies het id gemakkelijk meegeven.
$post = $helper->getExperienceById($mysqli, $_GET['id']);
$company = $helper->getCompanyById($mysqli, $post[0]['company_id']);
$user = $helper->getUserById($mysqli, $post[0]['created_by_id']);
$date = new DateTime($post[0]['created']);
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

    <div class="button-container">
        <a href="experiences.php?id=<?php echo $post[0]['company_id']; ?>"><button type="button" class="btn btn-primary"><< Terug naar het overzicht</button></a>
        <?php if($post[0]['created_by_id'] == $_SESSION['data']['id']) : ?>
        <a href="update.php?id=<?php echo $post[0]['id']; ?>"><button type="button" class="btn btn-secondary">Bewerk ervaring</button></a>
        <?php endif; ?>
    </div>

    <?php if(!$post) : ?>
    GEEN ERVARING GEVONDEN!
    <?php else : ?>

    <div class="big-container">
        <div class="exp-content">
            <h3><?php echo $post[0]['title']; ?> <small>(Cijfer: <?php echo $post[0]['rating']; ?>)</small></h3>
            <hr>
            <p>
                <?php echo $post[0]['body']; ?>
            </p>
            <?php if($_SESSION['data']['group_id'] > 1) : ?>
                <form method="post" action="">
                    <input type="submit" class="btn btn-danger" name="delete" value="Verwijder" onclick="return deleteExperience();" />
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="info-container">
        <div class="info-content">
            <h3>Informatie</h3>
            <hr>
            <label>Geschreven door: </label> <strong><?php echo $user[0]['fullname']; ?></strong><br/>
            <label>Gepubliceerd op: </label> <strong><?php echo $date->format('d-m-Y H:i'); ?></strong><br/>
            <label>Naam bedrijf: </label> <strong><?php echo $company[0]['name']; ?></strong><br/>
            <label>Adres bedrijf: </label> <strong><?php echo $company[0]['street']; ?>, <?php echo $company[0]['postal']; ?>, <?php echo $company[0]['city']; ?></strong><br/>
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