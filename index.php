<?php
  interface Encriptar{
    function cifrar($texto);
    function descifrar($texto);
  }
  class Cesar implements Encriptar
  {
    public $num_desplazamientos = 3;

    function cifrar($texto)
    {
      $cadena = str_split($texto);
      $resultado = "";
      foreach($cadena as $letra)
      {
        $resultado = $resultado.chr(ord($letra)+$this->num_desplazamientos);
      }

      return $resultado;
    }
    function descifrar($texto)
    {
      $cadena = str_split($texto);
      $resultado = "";
      foreach($cadena as $letra)
      {
        $resultado = $resultado.chr(ord($letra)-$this->num_desplazamientos);
      }

      return $resultado;
    }
  }
  class ROT47 implements Encriptar
  {
    private function operacion($texto)
    {
        return strtr($texto, 
        '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~', 
        'PQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNO');       
    }
    function cifrar($texto)
    {
        $cifrado = $this->operacion($texto);
        return $cifrado;
    }

    function descifrar($texto)
    {
        $descifrado = $this->operacion($texto);
        return $descifrado;
    }
  }

  $cifrado = "";
  $descifrado = "";
  $hash="";
  if ((isset($_POST["txtcifrar"]) || isset($_POST["txtdescifrar"])) && $_POST['codigo']=='cesar')
  {
    $cesar = new Cesar;
   // $cesar->num_desplazamiento = 10;

    if(isset($_POST["txtcifrar"]))
    {
      $cifrado = $cesar->cifrar($_POST["txtcifrar"]);
    }
    if(isset($_POST["txtdescifrar"]))
    {
      $descifrado = $cesar->descifrar($_POST["txtdescifrar"]);  
    }
  }
  if ((isset($_POST["txtcifrar"]) || isset($_POST["txtdescifrar"])) && $_POST['codigo']=='rot47')
  {
    $rot = new ROT47;

    if(isset($_POST["txtcifrar"]))
    {
      $cifrado = $rot->cifrar($_POST["txtcifrar"]);
    }
    if(isset($_POST["txtdescifrar"]))
    {
      $descifrado = $rot->descifrar($_POST["txtdescifrar"]);  
    }
  }
  if(isset($_POST["btn"]))
  {
    $cifrado = "";
    $descifrado = "";
    $hash="";
  }
  
?>
<!Doctype html>
<html lang="es">
  <head>
      <title>Ejemplo de cifrados Cesar y Rot 47</title>
      <link rel="stylesheet" href="./index.css">
  </head>
  <body>
    
    <section>
      <header>
        <h1>Ejemplo de cifrado/descifrado César y Rpt 47</h1>
      </header>
     <center class="cajas">
        <p>
          Cifrado
        </p>
        
        <form name="cifrar" id="cifrar" method="post" action="#">
        
       
        <p>
            <select name="codigo">
                <option value="cesar" selected>Cesar</option>
                <option value="rot47">Rot 47</option>
            </select>
        </p>
          <p>
              <textarea name="txtcifrar" id="txtcifrar"cols="20" rows="15"><?=$descifrado?></textarea>
          </p>
          <p>
            <input type="submit" value="Cifrar"/>
          </p>
          <p style="color:red">
           
            <?php $hash=sha1($descifrado);
            if ($descifrado!="") echo "El código hash es:".$hash;?>
          </p>
        </form>
    
          <p>
            Descifrado
          </p>
        
        <form name="descifrar" id="descifrar" method="post" action="#">
        
          <p>
              <select name="codigo">
                  <option value="cesar" selected>Cesar</option>
                  <option value="rot47">Rot 47</option>
              </select>
          </p>
          <p>
              <label for="txtdescifrar"></label>
              <textarea name="txtdescifrar" id="txtdescifrar" cols="20" rows="15"><?=$cifrado?></textarea>
          </p>
          <p>
            <input type="submit" value="Descifrar"/>
          </p>
          <p style="color:red">
           
            <?php
                $hash=sha1($cifrado);
                if ($cifrado!="") echo "El código hash es:".$hash;?>
          </p>
          </center>
          <p class="reset">
            <input type="submit" value="Resetear" id="btn" name="btn"/>
          </p>
        </form>
        
         
    </section>
  </body>
</html>
