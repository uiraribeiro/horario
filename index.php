<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Horário 2.0</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="horario_css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos customizados para esse template -->
    <link href="sign.css" rel="stylesheet">
  
  </head>

  <body class="text-center">
  <form class="form-signin" id="loginform" method="post" action="verifica.php">

    <form class="form-signin">
      <img class="mb-4" src="horario_fotos/logo-universo.jpg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Horario 2.0</h1>
      <label for="matricula" class="sr-only">Endereço de email</label>
      <input type="text" id="matricula" name="matricula" class="form-control" placeholder="matricula" required autofocus>
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Senha" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Lembrar de mim
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>
