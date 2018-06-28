<?php
ob_start(); // Initiate the output buffer
?>
<!DOCTYPE html>
<html style="height:100%;" >
    <head>
        <meta charset="utf-8" />
        <base href="/street-workout-world/">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--<link rel="stylesheet" href="<?php echo chemins::BOOTSTRAP ?>css/bootstrap.min.css">-->
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo chemins::STYLES . 'style.css'; ?>" />
        <link href="<?php echo chemins::STYLES . 'styleform.css'; ?>" rel="stylesheet" type="text/css">
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <title>street-workout-world </title>
    </head>

    <!--[if IE 6 ]><body class="ie6 old_ie"><![endif]-->
    <!--[if IE 7 ]><body class="ie7 old_ie"><![endif]-->
    <!--[if IE 8 ]><body class="ie8"><![endif]-->
    <!--[if IE 9 ]><body class="ie9"><![endif]-->
    <!--[if !IE]><!--><!--<![endif]-->
    <body style="height:100%;">
        <div id="bloc_page2">
            <header>
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="home">Street Workout World</a></li>
                            <li><a href="entrainements">entrainements</a></li>
                            <li><a href="exercices">exercices</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">articles
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="articles/entrainement">Entraînement</a></li>
                                    <li><a href="articles/dietetique">Diététique</a></li>
                                    <li><a href="articles/materiel">Matériel</a></li>
                                    <li><a href="articles/competition">Compétition</a></li>
                                    <li><a href="articles/devPersonnel">Développement personnel</a></li>
                                    <li><a href="articles">Tous les articles</a></li>
                                </ul>
                            </li>
                            <li><a href="#"></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">

                            <?php if (!isset($_COOKIE['user'])) { ?>
                                <li><a href="inscription"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                                <li><a href="connexion"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

                            <?php }
                            if (isset($_COOKIE['user'])) {
                                ?>
                                <li><a href="admin">Panel d'administration</a></li>
                                <li><button class="btn btn-danger navbar-btn" onclick="location.href = 'deconnexion'">Logout</button></li>
<?php } ?>
                        </ul>
                    </div>
                </nav>
               
          
            </header>
