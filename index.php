<?php
use Illuminate\Database\Capsule\Manager as DB;
require_once 'header.php';

$error="";

if(isset($_POST['id_servicio']))
{
    $id_servicio = $_POST['id_servicio'];
    $servicios = DB::table('servicios')->where('id_servicio', $id_servicio)->first();
    if($saldo->dinero >= $servicios->precio)
    {
        $fecha = $_POST['fecha'];

        if($fecha != "")
        {
            $cita = DB::table('citas')->insertGetId(
                ['usuarios_id_usuario'=>$id]
            );
            if($cita)
            {
                $sacar = DB::table('citas')->max('id_cita');

                $id_cita = $sacar;
                DB::table('citas_servicios')->insert(
                    ['servicios_id_servicio'=>$id_servicio, 'citas_id_cita'=>$id_cita, 'fecha'=>$fecha, 'status'=>'Pendiente']
                );

                $nuevo_saldo = $saldo->dinero - $servicios->precio;

                $actualizar = DB::table('perfil')
                    ->where('usuarios_id_usuario', $id)
                    ->update(['dinero'=>$nuevo_saldo]);

                die('<p class="center mt-6 is-size-3">CITA AÑADIDA CON ÉXITO</p>');
            }
            else
            {
                echo'upss algo ha salido mal';
            }
        }
        else
        {
            $error = "Agregar una fecha";
        }
    }
    else
    {
        die('<p class="center mt-6 is-size-3">DINERO INSUFICIENTE</p>');
    }
}

$servicios = DB::table('servicios')->get();

echo'
    <div class="container is-fluid">

        <div class="columns producto">

        ';

        foreach($servicios as $j)
        {
            echo'
            <div class="column is-4">
                <br>
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img src="img/' . $j->img . '" class="card-img-top" width="286px" height="190px" alt="Upps, no se ha encontrado la imágen">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <h5 class="card-title">' . $j->nombre . '</h5>
                            <p class="card-text">' . $j->descripcion . '</p>
                            <p style="color: green; name="price">$' . $j->precio . '</p>
                            ';
                            if($loggedin){
                                echo'
                                <form method="post" action="index.php">
                                    <div class="field">
                                        <label class="label">Fecha</label>
                                        <div class="control">
                                            <input class="input is-primary" name="fecha" type="date" placeholder="Primary input">
                                        </div>
                                        <p class="help is-danger">'.$error.'</p>
                                    </div>
                                    <input class="input" type="hidden" name="id_servicio" value="'.$j->id_servicio.'">
                                    <button type="submit" type="button" class="mt-3 button is-success">Genera tu cita ahora!</button>
                                </form>
                                ';
                            }
            echo'
                        </div>
                    </div>
                </div>
            </div>
            ';
        }

        echo'

        </div>

    </div>

    </body>
</html>
';