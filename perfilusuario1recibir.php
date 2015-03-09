<!DOCTYPE html>
<html>
<head>
   <title>Menú con HTML y CSS</title>

  <meta charset="utf-8">
  <meta name="viewpot" content="width-device-width; initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="css/estilo.css" />
  <link rel="stylesheet" type="text/css" href="css/base.css" />
  <link rel="stylesheet" type="text/css" href="css/great.css" media="screen and (min-width=981px)" />
  <link rel="stylesheet" type="text/css" href="css/medium.css" media="screen and (min-width=481px) and (max-width=980px)" />
  <link rel="stylesheet" type="text/css" href="css/mini.css" media="screen and (max-width=480px)"/>

</head>
<body>

<?php

  function comprobar_telefono($telefono) /*que empieen por la extensión 34, o la terminación 9,6 ó 7*/
  {
    return preg_match('/^((\+?34([ \t|\-])?)?[9|6|7]((\d{1}([ \t|\-])?[0-9]{3})|(\d{2}([ \t|\-])?[0-9]{2}))([ \t|\-])?[0-9]{2}([ \t|\-])?[0-9]{2})$/', $telefono);
    /* con preg_match y la expresión que le sigue entre parentesis capturamos como válidos teléfonos en los formatos siguientes con posibilidad de capturar espacios
    o guiones como separación: +34 9XX XX XX XX 9XX XX XX XX 6XX XX XX XX 7XX-XX-XX-XX 6XXXXXXXX*/
  }

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

  /*function validar_fecha ($fecha) /*solo comprueba que el formato sea dd/mm/aaaa*//*
    {
    return preg_match('/^((\d{1,2}\/\d{1,2}\/\d{4})|(\d{4}\/\d{1,2}\/\d{1,2})|(\d{1,2}\-\d{1,2}\-\d{4})|(\d{4}\-\d{1,2}\-\d{1,2}))$/', $fecha);
    }*/

   function validar_fecha($fecha)
   {
  // Esta expresion regular valida el formato de fecha DD/MM/AA o DD/MM/AAAA
  // con el separador / o -; DD solo puede ir de 01 a 31, MM de 01 a 12
  // el valor de DD se guarda en $date[1], MM en $date[2] y AA en $date[3]
  if (ereg('^(0?[1-9]|[12][0-9]|3[01])[/|-](0?[1-9]|1[012])[/|-]([0-9]{2,4})$', $fecha, $date))
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
 }
} 



  $nombre = $_GET["nombre"]; /*podemos pone o get o post, pero en el html tambien debemos cargar en este caso post*/
  $apellido = $_GET["apellido"];
  $telefono = $_GET["telefono"];
  $usuario = $_GET["nombreusuario"];
  $email = $_GET["correoelectronico"]; 
  $contraseña=$_GET["contraseña"];
  $preguntaseguridad=$_GET["preguntadeseguridad"];
  $respuesta=$_GET["respuesta"];
  $usuariofacebook = $_GET["nombreusuariofacebook"];
  $usuariotwitter = $_GET["nombreusuariotwitter"];

  $fecha = $_GET["fechanacimiento"];
  $sexo = $_GET["sexo"];
  $profesion = $_GET["profesion"];
  $provincia = $_GET["provincia"];
  $estudios= $_GET["estudios"];
  $certificado1= $_GET["certificado1"];
  $nivel1= $_GET["nivel1"];
  $familiaprof1= $_GET["familiaprofesional1"];
  $certificado2= $_GET["certificado2"];
  $nivel2= $_GET["nivel2"];
  $familiaprof2= $_GET["familiaprofesional2"];
  $certificado3= $_GET["certificado3"];
  $nivel3= $_GET["nivel3"];
  $familiaprof3= $_GET["familiaprofesional3"];
  $idioma1= $_GET["idioma1"];
  $hablado1= $_GET["hablado1"];
  $escrito1= $_GET["escrito1"];
  $idioma2= $_GET["idioma2"];
  $hablado2= $_GET["hablado2"];
  $escrito2= $_GET["escrito2"];
  $idioma3= $_GET["idioma3"];
  $hablado3= $_GET["hablado3"];
  $escrito3= $_GET["escrito3"];
  $mascaras= $_GET["mascaras"];
  $capas= $_GET["capas"];
  $siluetear= $_GET["siluetear"];
  $fundir= $_GET["fundir"];

  if(isset($nombre) && isset($apellido) && isset($telefono) && comprobar_telefono($telefono) && isset($usuario) && isset($email) && comprobar_email($email) 
    && isset($contraseña) && isset($preguntaseguridad) && isset($respuesta) && isset($usuariofacebook) /*con la opción isset comprobamos que hay datos dentro de la casilla nombre. Con lo cual no hace falta ponerlo en la función de validar*/
    && isset($usuariotwitter) && isset($fecha) && validar_fecha($fecha) && isset($sexo) && isset($profesion) && isset($provincia)
    && isset($estudios) && isset($certificado1) && isset($nivel1) && isset($familiaprof1) 
    && isset($certificado2) && isset($nivel2) && isset($familiaprof2)&& isset($certificado3) && isset($nivel3) && isset($familiaprof3)
    && isset($idioma1) && isset($hablado1) && isset($escrito1) && isset($idioma2) && isset($hablado2) && isset($escrito2)
    && isset($idioma3) && isset($hablado3) && isset($escrito3) && isset($mascaras) && isset($capas) && isset($siluetear)
    && isset($fundir) )
  {

  $pantalla = "<h1>Datos recibidos correctamente mediante POST</h1>
            <h2>PERFIL USUARIO</h2>
      <P>Nombre: $nombre </P> 
      <P>Apellido: $apellido </P>
      <P>Teléfono: $telefono </P>
      <P>Nombre usuario: $usuario </P>
      <P>Correo electrónico: $email </P>
      <P>Contraseña: $contraseña </P>
      <P>Pregunta de seguridad: $preguntaseguridad </P>
      <P>Respuesta: $respuesta </P>
      <P>Usuario facebook:  $usuariofacebook </P>
      <P>usuario twitter: $usuariotwitter </P>
     
          <h2>DATOS COMPLEMENTARIOS</h2>     
      <P>Fecha nacimiento: $fecha </P>
      <P>Sexo: $sexo </P>
      <P>Profesión: $profesion </P>
      <P>Provincia: $provincia </P>
      <P>Nivel estudios: $estudios </P>
      <P>Certificado: $certificado1, $nivel1, $familiaprof1</P>
      <P>Certificado: $certificado2, $nivel2, $familiaprof2</P>
      <P>Certificado: $certificado3, $nivel3, $familiaprof3</P>
      <P>Idioma: $idioma1, $hablado1, $escrito1</P>
      <P>Idioma: $idioma2, $hablado2, $escrito2</P>
      <P>Idioma: $idioma3, $hablado3, $escrito3</P>

          <h2>INTERÉS POR OTROS TEMAS (0-10)</h2>
      <P>Máscaras: $mascaras</P>
      <P>Capas: $capas</P>
      <P>Siluetear: $siluetear</P>
      <P>Fundir: $fundir</P> "; /* if si los daros se reciben correctamente aparecera este mensaje*/
  }
  else
  {
  $pantalla = "<h1>Error en la recepcion</h1>
    <p>Los datos no se han recibido correctamente
    </p>"; /* else si los daros NO se reciben correctamente aparecera este mensaje*/
  }
    echo $pantalla;
 
?>