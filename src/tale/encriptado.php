<?php
    namespace App;
    use Defuse\Crypto\Crypto;
    use Defuse\Crypto\Key;
    use Defuse\Crypto\Key\Exception\WrongKeyOrModifiedCiphertextException;

class encriptado{


    public function encriptar($texto){
	$contenido = "def000001bec91d76eb5cafbb5ee67ad96523f4621158c78f45d27a54bfff21826774fe412a5c398917e628beca47536015425451f98175e587379f8057e198676ee3d2a";
	$clave = Key::loadFromAsciiSafeString($contenido);
	$mensajeCifrado = Crypto::encrypt($texto, $clave);
	return $mensajeCifrado;
    }

    public function desencriptar($texto){
    	$contenido = "def000001bec91d76eb5cafbb5ee67ad96523f4621158c78f45d27a54bfff21826774fe412a5c398917e628beca47536015425451f98175e587379f8057e198676ee3d2a";
	$clave = Key::loadFromAsciiSafeString($contenido);
	try {
    		$mensajeCifrado = Crypto::decrypt($texto, $clave);
	} catch (Ex\BadFormatException $e) {
    		exit("Los datos están corruptos o la clave es incorrecta");
	}
	return $mensajeCifrado;
    }

    public function cambiarBarras($texto){
        for ($i=0; $i <= (strlen($texto)-1); $i++) {
            if ($texto[$i]=='/'){
                $texto[$i]='-';
            }
	    if ($texto[$i]==''){
                $texto[$i]='_';
            }

        }
        return $texto;
    }

    public function ingresarBarras($texto){
        for ($i = 0; $i <= (strlen($texto)-1); $i++) {
            if ($texto[$i]=='-'){
                $texto[$i]='/';
            }
	    if ($texto[$i]=='_'){
                $texto[$i]='';
            }
        }
        return $texto;
    }
}