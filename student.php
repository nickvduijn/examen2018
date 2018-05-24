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
//Check of je wel in de juiste groep zit.
if($_SESSION['data']['group_id'] < 2) {
    header('location: home.php');
}
// Wanneer er op de wijzig knop wordt gedrukt zal de save() functie de data opslaan.
if(isset($_POST['create'])) {
    if($helper->save($mysqli, 'student_update', $_POST)) {
        header('location: students.php?msg=Student succesvol aangepast!');
    } else {
        header('location: student.php?id='.$_POST['id'] .'error=E-mailadres is al in gebruik!');
    }
}
//Wanneer er op de verwijder knop wordt gedrukt zal het een melding sturen en vervolgens verwijderen uit de database.
if(isset($_POST['delete'])) {
    if($helper->delete($mysqli, 'student', $_POST)) {
        header('location: home.php?msg=De geschreven ervaring is verwijderd');
    } else {
        header('location: experience.php?id='.$_POST['id'] .'error=Er ging iets mis!');
    }
}

$user = $helper->getUserById($mysqli, $_GET['id']);
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
            <h3>Pas <?php echo $user[0]['fullname']; ?> aan </h3>
            <hr>
            <form method="post" action="">
                <div class="form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?php echo $user[0]['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="fullname">Volledige naam</label>
                    <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo $user[0]['fullname']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="class">Klas</label>
                    <input type="text" name="class" class="form-control" id="class" value="<?php echo $user[0]['class']; ?>" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Bedrijf</label>
                    </div>
                    <select name="company_id" class="custom-select" id="company_id">
                        <option value=''>Selecteer een bedrijf..</option>
                        <?php
                        $result=mysqli_query($mysqli,'SELECT id,name FROM companies');
                        while($row=mysqli_fetch_assoc($result)) : ?>
                            <option value='<?php echo $row['id']; ?>' <?php if($row['id'] == $user[0]['company_id']) : ?>selected<?php endif;?>><?php echo $row['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <input type="hidden" name="id" value="<?php echo $user[0]['id']; ?>"/>
                <input type="submit" class="btn btn-success" name="create" value="Wijzig" />
                <input type="submit" class="btn btn-danger" name="delete" value="Verwijder" onclick="return deleteStudent();" />
            </form>
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