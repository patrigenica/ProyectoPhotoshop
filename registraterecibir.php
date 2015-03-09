<!DOCTYPE html>
<html>
<head>
   <title>Menú con HTML y CSS</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="css/estilo.css" />
  <link rel="stylesheet" type="text/css" href="css/base.css" />
  <link rel="stylesheet" type="text/css" href="css/great.css" media="screen and (min-width:981px)" />
  <link rel="stylesheet" type="text/css" href="css/medium.css" media="screen and (min-width:481px) and (max-width:980px)" />
  <link rel="stylesheet" type="text/css" href="css/mini.css" media="screen and (max-width:480px)"/>

</head>
<body>

<?php

function comprobar_email($email)
  {
    $mail_correcto = 0;
    
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@")
        && (substr($email,strlen($email)-1,1) != "@")) /*En el primer if compruebo que el email tiene por lo menos
      6 caracteres (el mínimo), que tiene una arroba y sólo una y que no está colocada ni al principio ni al final*/ 
    {
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) 
          && (!strstr($email,"\$")) && (!strstr($email," "))) /*En el segundo if compruebo que no tiene caracteres
        no permitidos. Y los restantes hacen comprobaciones de las distintas partes de la dirección de correo:
        que hay un punto en algún lado y que la terminación del dominio es correcta y que
        el principio de la dirección también es correcto. */
       {
          if (substr_count($email,".")>= 1) //miro si tiene el caracter punto
          {
             $term_dom = substr(strrchr ($email, '.'),1); //obtengo la terminacion del dominio
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ) //compruebo que la terminación del dominio sea correcta
             {
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); //compruebo que lo de antes del dominio sea correcto
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != ".")
                {
                   $mail_correcto = 1; /*si se cumplen todas las condiciones es válido*/
                }
             }
          }
       }
    }
    if ($mail_correcto) /*devuelve la variable utilizada para guardar la validez o no del correo.*/
       return 1; /*correcto o válido*/
    else 
       return 0; /*incorrecto*/
  } 

  /*function validarEmail($email) TAMBIEN PODEMOS VALIDAR ASI EL MAIL, COMPRUEBA si usa el formato estándar.
    {
    return preg_match("#^(((( [a-z\d]  [\.\-\+_] ?)*) [a-z0-9] )+)\@(((( [a-z\d]  [\.\-_] ?){0,62}) [a-z\d] )+)\.( [a-z\d] {2,6})$#i", $email);
    }*/

  /*function validar_fecha ($fecha) /*TAMBIEN SE PUEDE VALIDAR ASI LA FECHA PERO solo comprueba que el formato sea dd/mm/aaaa o aaaa/mm/dd*//*
    {
    return preg_match('/^((\d{1,2}\/\d{1,2}\/\d{4})|(\d{4}\/\d{1,2}\/\d{1,2})|(\d{1,2}\-\d{1,2}\-\d{4})|(\d{4}\-\d{1,2}\-\d{1,2}))$/', $fecha);
    }*/

  function validar_fecha($fecha) /* COMPRUEBA LA FECHA CON EL CALENDARIO para el formato dd/mm/aaaa y aaaa/mm/dd*/
   {

		if(substr($fecha,2,1) == "-" || substr($fecha,2,1) == "/") //para separar la fecha podemos utilizar guiones(-) o barra
		{ //dd-mm-aaaa
			$dia = substr($fecha,0,2); //para que ponga la fecha en este orden dia-mes-año. Los caracteres van de 0 a 9. decimos que la fecha del día empieza en el 0 y que va a llevar dos caracteres
			$mes = substr($fecha,3,2); // Los caracteres van de 0 a 9. decimos que la fecha del mes empieza en el 3 y que va a llevar dos caracteres
			$anyo = substr($fecha,6,4); // Los caracteres van de 0 a 9. decimos que la fecha del año empieza en el 6 y que va a llevar cuatro caracteres
		}
		else
		{//aaaa-mm-dd
			$anyo = substr($fecha,0,4); //si no la pone como el anterior, entonces la pondra como año-mes-día. Los caracteres van de 0 a 9. decimos que la fecha del año empieza en el 0 y que va a llevar cuatro caracteres
			$mes = substr($fecha,5,2); //Los caracteres van de 0 a 9. decimos que la fecha del mes empieza en el 5 y que va a llevar dos caracteres
			$dia = substr($fecha,8,2); //Los caracteres van de 0 a 9. decimos que la fecha del dia empieza en el 8 y que va a llevar dos caracteres
		}
		/*echo "dia: $dia, mes: $mes: anyo: $anyo";// solo para comprobar yo que no hay error en la fecha*/
		if(checkdate ($mes, $dia, $anyo)) //comprueba que la fecha es correcta
			return true;
		else
			return false;	
    }

  /*function validar_fecha($fecha) //TAMBIEN SE PUEDE VALIDAR ASI LA FECHA PERO SOLO comprueba que la fecha es correcta pero solo para el formato dd/mm/aaaa
  // Esta expresion regular valida el formato de fecha DD/MM/AAAA {4} el año debe llevar 4 caracteres
  // con el separador / o -; DD solo puede ir de 01 a 31, MM de 01 a 12
  // el valor de DD se guarda en $date[1], MM en $date[2] y AA en $date[3]
  if (ereg('^(0?[1-9]|[12][0-9]|3[01])[/|-](0?[1-9]|1[012])[/|-]([0-9]{4})$', $fecha, $date))
  {
  switch ($date[2])
  { // reviso los meses
    case '2' : //Validaciones para febrero
      if ($date[1] == 29 && ($date[3] % 4 != 0))
      { // no puede tener 29 dias si no es bisiesto (modulo de 4), no vale
       return FALSE;
      }
      else
        {
       if ($date[1] > 29)
       { //no puede tener 30 ni 31 dias
        return FALSE;
       }
       else
       { //para el resto de casos es fecha valida
        return TRUE;
       }
      }
      break;
    case '4' : //Validaciones para abril, junio, septiembre y noviembre
    case '6' :
    case '9' :
    case '11' :
       if ($date[1] > 30)
       { //no pueden tener 31 dias
        return FALSE;
       }
       else
       { //para el resto de casos es fecha valida
        return TRUE;
       }
      break;
      default : // El resto de meses pueden tener 31 dias
       return TRUE;
      }
     }
     else
     {
      // Mal formato de fecha
      return FALSE;
     }*/
    

	$usuario = $_POST["nombreusuario"];
	$email = $_POST["correoelectronico"];
	$correoconfirmar=$_POST["confirmarcorreo"];
	$contraseña=$_POST["contraseña"];
	$contraseñaconfirmar=$_POST["confirmarcontraseña"];
	$preguntaseguridad=$_POST["preguntadeseguridad"];
	$respuesta=$_POST["respuesta"];
	$respuestarepite=$_POST["repiterespuesta"];	
	$nombre = $_POST["nombre"]; /*podemos pone o get o post, pero en el html tambien debemos cargar en este caso post*/
	$apellido = $_POST["apellido"];
	$fecha = $_POST["fechanacimiento"];
	$sexo = $_POST["sexo"];
	$profesion = $_POST["profesion"];
	$provincia = $_POST["provincia"];
	$retoquecolor = $_POST["color"];
	$retoqueimagen = $_POST["imagen"];

	if(isset($usuario) && isset($email) && comprobar_email($email)  && isset($correoconfirmar) && isset($contraseña) && isset($contraseñaconfirmar)
		&& isset($preguntaseguridad) && isset($respuesta) && isset($respuestarepite) && isset($nombre) /*con la opción isset comprobamos que hay datos dentro de la casilla nombre. Con lo cual no hace falta ponerlo en la función de validar*/
		&& isset($apellido) && isset($fecha) && validar_fecha($fecha) && isset($sexo) && isset($profesion) && isset($provincia)
		&& isset($retoquecolor) && isset($retoqueimagen))
	{

	$pantalla = "<h1>Datos recibidos correctamente mediante POST</h1>
					<h2>Datos usuario</h2>
  		<P>Nombre usuario: $usuario </P>
  		<P>Correo electrónico: $email </P>
  		<P>Confirmar correo electrónico: $correoconfirmar </P>
  		<P>Contraseña: $contraseña </P>
  		<P>Confirmar contraseña: $contraseñaconfirmar </P>
  		<P>Pregunta de seguridad: $preguntaseguridad </P>
  		<P>Respuesta: $respuesta </P> 
  		<P>Repite respuesta: $respuestarepite </P> 
  			<h2>Datos Personales</h2>  
		<P>Nombre: $nombre </P> 
  		<P>Apellido: $apellido </P>
  		<P>Fecha: $fecha </P>
  		<P>Sexo: $sexo </P>
  		<P>Profesión: $profesion </P>
  		<P>Provincia: $provincia </P>
  			<h2>Interés por el tema (0-10)</h2> 
  		<P>Retoque color: $retoquecolor </P>
  		<P>Retoque imagen: $retoqueimagen </P>"; /* if si los daros se reciben correctamente aparecera este mensaje*/
	}
	else
	{
	$pantalla = "<h1>Error en la recepcion</h1>
		<p>Los datos no se han recibido correctamente
		</p>"; /* else si los daros NO se reciben correctamente aparecera este mensaje*/
	}
  	echo $pantalla;
 
?>

	








</body>
</html>	