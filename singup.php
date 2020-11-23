<?php
require_once 'functions.php';
use Illuminate\Database\Capsule\Manager as DB;

echo'
<body>
    <div class="container is-fluid">
';

$error = $usuario = "";

if(!$loggedin){

    if(isset($_POST['usuario']))
    {
        $usuario = sanitizeString($_POST['usuario']);
        $contraseña = sanitizeString($_POST['contraseña']);
        $Rcontraseña = sanitizeString($_POST['Rcontraseña']);

        if($contraseña == $Rcontraseña)
        {
            $users = DB::table('usuarios')->where('usuario', $usuario)->first();

            if ($users)
            {
                $error = '<p class="is-size-5">Esa cuenta ya existe</p>';
            }
            else
            {
                DB::table('usuarios')->insertGetId(
                    ['usuario' => $usuario, 'contraseña' => $contraseña]
                );

                $id_usuario = DB::table('usuarios')->max('id_usuario');

                DB::table('perfil')->insert(
                    ['usuarios_id_usuario'=>$id_usuario, 'dinero'=>0, 'rol'=>2]
                );

                die('<p class="is-size-4 center mt-6">Te haz registrado, <a href="login.php">click aquí</a> para iniciar sesión</p>
                </div></body></html>');
            }
        }
        else {
            $error = '<p class="is-size-5">Las contraseñas no son iguales</p>';
        }
    }

    echo'
        <div class="card mt-6">
            <header class="card-header">
                <p class="card-header-title">
                    Ingresa tus datos para registrarse
                </p>
                <a href="#" class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                </a>
            </header>
            <div class="card-content">
                <div class="content">
                    <form method="post" action="singup.php">
                        <div class="field">
                            '.$error.'
                            <label class="label mt-4">Usuario</label>
                            <div class="control">
                                <input class="input" type="text" maxlength="45" name="usuario" placeholder="Usuario" value="'.$usuario.'">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Contraseña</label>
                            <div class="control">
                                <input class="input" type="password" maxlength="45" name="contraseña" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Repetir contraseña</label>
                            <div class="control">
                                <input class="input" type="password" maxlength="45" name="Rcontraseña" placeholder="Contraseña">
                            </div>
                        </div>
                        <button type="submit" class="button is-link mt-3">Registrarte</button>
                        <a href="login.php" class="button is-link mt-3 ml-3">Iniciar sesión</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    ';
}
else{

    die('<p class="is-size-4 is-center mt-6">Usted ya tiene una sesión activa <a href="index.php">click aquí</a> para ir al sistema</p>
        </div></body></html>');

}

echo'
    </body>
</html>
';