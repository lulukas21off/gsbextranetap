<!DOCTYPE html>
<html lang="fr">
<head>
    <title>GSB - extranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body background="assets/img/laboratoire.jpg">

<div class="page-content container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-wrapper">
                <div class="box">
                    <div class="content-wrap">
                        <legend>Se connecter</legend>

                        <form method="post" action="index.php?uc=connexion&action=valideConnexion">
                            <input name="login" class="form-control" type="text" placeholder="Login">
                            <input name="mdp" class="form-control" type="password" placeholder="Password">
                            <br>
                            <input type="submit" class="btn btn-primary signup" value="Se connecter">
                        </form>

                        <br>
                        <a href="index.php?uc=creation&action=demandeCreation">
                            je suis médecin, je souhaite créer un compte
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("v_footer.php"); ?>

<script src="https://code.jquery.com/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
