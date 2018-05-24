<?php
    //config bestand en helper inladen
    require_once 'config.php';
    include 'helper.php';
    // Helper class toevoegen
    $helper = new Helper();
    // Sessie starten
    session_start();
    //Kijkt of je bent ingelogd.
    if(!isset($_SESSION['data'])) {
        header('location: index.php');
    }
    //Haalt bedrijfsgegevens op door het id uit de sessie te halen.
    $company = $helper->getCompanyById($mysqli, $_SESSION['data']['company_id']);
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
            <div class="alert alert-primary" role="alert">
                <div class="alert-msg">
                    Welkom op het dashboard <strong><?php echo $_SESSION['data']['fullname']; ?></strong>!
                </div>
            </div>

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

            <?php if(empty($_SESSION['data']['company_id']) && $_SESSION['data']['group_id'] < 2) : ?>
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Je bent nog niet gekoppeld aan een bedrijf!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($_SESSION['data']['group_id'] < 2 && !empty($_SESSION['data']['company_id'])) : ?>
                <?php if(!$helper->getPostByUserId($mysqli, $_SESSION['data']['id'])) : ?>
                <div class="button-container">
                    <a href="create.php"><button type="button" class="btn btn-success">Schrijf een ervaring!</button></a>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($_SESSION['data']['group_id'] < 2 && $helper->hasExperiences($mysqli, $_SESSION['data']['id'])) : ?>

            <div class="post-container">
                <div class="t-content">
                    <?php $posts = $helper->getPostByUserId($mysqli, $_SESSION['data']['id']); ?>
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Geschreven door jou</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php foreach($posts as $item) : ?>
                            <?php $item['company'] = $helper->getCompanyById($mysqli, $item['company_id']); ?>
                            <?php $item['user'] = $helper->getUserById($mysqli, $item['created_by_id']); ?>
                            <?php $date = new DateTime($item['created']); ?>
                            <tr class='clickable-row' data-href='experience.php?id=<?php echo $item['id']; ?>'>
                                <td><?php echo $item['title']; ?></td>
                                <td><?php echo $item['company'][0]['name']; ?></td>
                                <td><small><i><?php echo $date->format('d-m-Y H:i');?></i></small></td>
                                <td><?php echo $item['rating']; ?><small>/10</small></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php endif; ?>
            <div class="search-container">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Zoeken</span>
                    </div>
                    <input type="text" id="searchbar" class="form-control" placeholder="Zoek een ervaring.." aria-label="Zoeken" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="big-container">
                <div class="t-content">
                    <?php $experiences = $helper->getAllExperiences($mysqli); ?>
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Alle gedeelde ervaringen</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php foreach($experiences as $item) : ?>
                        <?php $item['company'] = $helper->getCompanyById($mysqli, $item['company_id']); ?>
                        <?php $avarage = $helper->avarageExperienceByCompanyId($mysqli, $item['company_id']); ?>
                            <tr class='clickable-row' data-href='experiences.php?id=<?php echo $item['company_id']; ?>'>
                                <td><strong><?php echo $item['company'][0]['name']; ?></strong></td>
                                <td>Aantal geschreven ervaringen: <i><?php echo count($helper->getExperienceByCompanyId($mysqli, $item['company_id'])); ?></i></td>
                                <td>Gemiddeld cijfer: <strong><?php echo (int)$avarage[0]['avarage']; ?></strong><small>/10</small></td>
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
        <?php if($_SESSION['data']['group_id'] < 2) : ?>
            <?php if(!empty($_SESSION['data']['company_id'])) : ?>
            <div class="container">
                <div class="company-container">
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
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="footer">Dit project is onderdeel van het examen <strong>Mediatechnologie, Applicatie en Mediaontwikkeling</strong>. Dit project is ontwikkeld door: <strong>Nick van Duijn (78408)</strong></strong></div>

        <!-- Alle JavaScript/jQuery bestanden of CDN's -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="js/main.js" type="text/javascript"></script>
    </body>
</html>