<?php
	header("Content-Type: text/html; charset=UTF-8");
	header("Refresh: 10; url=../login.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Error d'accés</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .btn {
                border-radius: 20px !important;
                padding: 7px 20px 7px 20px !important;
            }
        </style>
    </head>
    <body>
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <h1 class="display-1 fw-bold">401</h1>
                <p class="fs-3"> <span class="text-danger">Oops!</span> Error d'accés. La sessió ha expirat.</p>
                <p class="lead">
					Per poder accedir a aquesta secció de l'aplicació cal tenir iniciada una sessió.
                </p>
				<p class="lead">
					No pots accedir a aquesta secció de l'aplicació sense haver iniciat un sessió amb un compte d'usuari de l'aplicació.
				</p>
                <a href="../login.php" class="btn btn-danger">Iniciar sessió</a>
            </div>
        </div>
    </body>
</html>