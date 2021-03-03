<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PerfilSolicitante;
use App\Entity\CategoriaPrincipal;
use App\Entity\Archivos;
use App\Entity\CategoriaSecundaria;
use App\Entity\Contacto;
use Symfony\Component\Filesystem\Filesystem;
use App\Form\FormularioContactoType;




class SistemaController extends AbstractController
{
    /**
     * @Route("/", name="sistemaSinBarra")
     */
    public function sistemaSinBarras(): Response
    {
        //Este controller muestra los perfiles
        $manager=$this->getDoctrine()->getManager();

        //Listar en orden segun los click y alfabeticamente (medio innecesario por alfabeto)
        $perfiles= $manager->getRepository(PerfilSolicitante::class)->findBy(array(), array('click' => 'DESC', 'descripcion_corta' => 'ASC'));
        
        //Este for es para recorrer cada perfil mostrado en el inicio y hacer la comprobacion con las fechasDesde y fechaHasta
        //Para publicarlo o despublicarlo segun corresponda en las fechas dictadas
        //Y el flush abajo es para actualizarlo en la base de datos.

        foreach($perfiles as $perfil){
            
            $fechaDesde = $perfil -> getFechaPublicacionDesde();
            $fechaHasta = $perfil -> getFechaPublicacionHasta();
            $fechaActual = $this -> getFechActual();
            if($fechaDesde <= $this -> getFechActual()){
                $perfil -> setPublicado("Publicado");
            }
            if($fechaHasta != null){
                //Compruebo con la fecha actual porque la fechaDesde no avanza automaticamente, en cambio la fecha actual si.
                if($fechaActual >= $fechaHasta){
                    $perfil -> setPublicado("Despublicado");
                }
            }
                
        }
        $manager -> flush();

        // $perfiles = $manager -> getRepository(PerfilSolicitante::class) -> findAll();

        return $this->render('sistema/index.html.twig',
                ['perfil' => $perfiles]
            );
    }

    /**
     * @Route("/sistema", name="sistema")
     */
    public function Home()
    {
        //Este controller muestra los perfiles
        $manager=$this->getDoctrine()->getManager();
      
     
           
        
     
        //Listar en orden segun los click y alfabeticamente (medio innecesario por alfabeto)
        // $perfiles= $manager->getRepository(PerfilSolicitante::class)->findBy(array(), array('click' => 'DESC', 'descripcion_corta' => 'ASC'));
        $perfiles= $manager->getRepository(PerfilSolicitante::class)->findBy(array(), array('descripcion_corta' => 'ASC'));
        
        //Este for es para recorrer cada perfil mostrado en el inicio y hacer la comprobacion con las fechasDesde y fechaHasta
        //Para publicarlo o despublicarlo segun corresponda en las fechas dictadas
        //Y el flush abajo es para actualizarlo en la base de datos.
        foreach($perfiles as $perfil){
            $fechaDesde = $perfil -> getFechaPublicacionDesde();
            $fechaHasta = $perfil -> getFechaPublicacionHasta();
            $fechaActual = $this -> getFechActual();
            if($fechaDesde <= $this -> getFechActual()){
                $perfil -> setPublicado("Publicado");
            }
            if($fechaHasta != null){
                //Compruebo con la fecha actual porque la fechaDesde no avanza automaticamente, en cambio la fecha actual si.
                if($fechaActual >= $fechaHasta){
                    $perfil -> setPublicado("Despublicado");
                }
            }
                
        }
        $manager -> flush();
       
        // $perfiles = $manager -> getRepository(PerfilSolicitante::class) -> findAll();

        return $this->render('sistema/index.html.twig',
                ['perfil' => $perfiles]
            );
    }

     /**
     * @Route("/categoriaPrincipal/{id}", name="categoriaPrincipal")
     */
    public function CategoriaPrincipal($id){
        //Este controller muestra las categorias y a su vez envio parametros que van a servir para los botones de volver los id
        //y la variable perfil para un titulo en el html   
        $em = $this -> getDoctrine() -> getManager();
        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($id);
        
        //Sumar Click
        $perfil -> setClick($perfil -> getClick() + 1);
        $em -> flush();
        //

        $categorias = $perfil -> getIdCategoriaPrincipal();

        //Foreach comprobacion fechaDesde y Hasta
        foreach($categorias as $catPP){
            $fechaDesde = $catPP -> getFechaPublicacionDesde();
            $fechaHasta = $catPP -> getFechaPublicacionHasta();
            $fechaActual = $this -> getFechActual();
            if($fechaDesde <= $this -> getFechActual()){
                $catPP -> setPublicado("Publicado");
            }
            if($fechaHasta != null){
                if($fechaActual >= $fechaHasta){
                    $catPP -> setPublicado("Despublicado");
                }
            }
                
        }
        $em -> flush();

        // $categorias= $em->getRepository(CategoriaPrincipal::class)->findBy(array('perfilSolicitante' => $id), array('click' => 'DESC') );

        return $this ->render('sistema/categoriaPrincipal.html.twig', [
            'cat' => $categorias,
            'idPerfil' => $id,
            'perfil' => $perfil
        ]);
    }

    /**
     * @Route("/categoriaSecundaria/{id}/{idPerfil}", name="categoriaSecundaria")
     */
    public function CategoriaSecundaria($id,$idPerfil){
        //Misma tematica de arriba 
        $em = $this -> getDoctrine() -> getManager();
       

        $categoriaP = $em -> getRepository(CategoriaPrincipal::class) -> find($id);

        //Sumar Click
        $categoriaP -> setClick($categoriaP -> getClick() + 1);
        $em -> flush();
        //

        $categoriaS = $categoriaP -> getCategoriaSecundaria();

          //Foreach comprobacion fechaDesde  y fechaHasta
        foreach($categoriaS as $catSec){
            $fechaDesde = $catSec -> getFechaPublicacionDesde();
            $fechaHasta = $catSec -> getFechaPublicacionHasta();
            $fechaActual = $this -> getFechActual();
            if($fechaDesde <= $this -> getFechActual()){
                $catSec -> setPublicado("Publicado");
            }
             if($fechaHasta != null){
                if($fechaActual >= $fechaHasta){
                    $catSec -> setPublicado("Despublicado");
                }
            }
                
        }
        $em -> flush();

        //Me busca solo las categorias SEC asociadas a la principal y de las ordena
        $categoriaS= $em->getRepository(CategoriaSecundaria::class)->findBy(array('id_categoria_principal' => $id), array('click' => 'DESC' , 'nombre_categoria' => 'ASC') );

        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($idPerfil);
        

        return $this -> render('sistema/categoriaSecundaria.html.twig', [
            'catSec' => $categoriaS, 
            'idPerfil' => $idPerfil,
            'idCatPP' => $id,
            'catPP' => $categoriaP,
            'perfil' => $perfil
            
        ]);
    }

    /**
     * @Route("/informacion/{id}/{idPerfil}/{idCatPP}", name="informacion")
     */
    public function Informacion($id, $idPerfil, $idCatPP){
        //Misma idea de arriba
        $em = $this -> getDoctrine() -> getManager();

        $categoriaS = $em -> getRepository(CategoriaSecundaria::class) -> find($id);
     
        $catPP = $em -> getRepository(CategoriaPrincipal::class) -> find($idCatPP);

        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($idPerfil);

        //Sumar Click
        $categoriaS -> setClick($categoriaS -> getClick() + 1);
        $em -> flush();
        //

       
        $informacion = $categoriaS -> getInformacion();
        // $informacion = $categoriaS -> getInformacion() + $perfil -> getInformacion();
        //Deberia hacerle el get al perfil, no a la cat secundaria, y una vez que ese perfil ya tenga asociada una informacion, no permitir que se le asocie otra igual
        //
       
        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($idPerfil);

        return $this -> render('sistema/informacion.html.twig', [
            'info' => $informacion,
            'idPerfil' => $idPerfil,
            'idCatPP' => $idCatPP,
            'idCatSec' => $id,
            'catSec' => $categoriaS,
            'perfil' => $perfil,
            'catPP' => $catPP
            
        ]);
    }

    /**
     * @Route("/formularioContacto/{idPerfil}/{idCatPP}/{idCatSec}", name="formularioContacto")
     */
    public function FormularioContacto(Request $request, \Swift_Mailer $mailer, $idPerfil, $idCatPP, $idCatSec){
        //Esta funcion es para el contacto y enviar un mail
        $contacto = new Contacto();

        $formulario = $this -> createForm(FormularioContactoType::class, $contacto);
        $formulario -> handleRequest($request);
        
        $em = $this -> getDoctrine() -> getManager();


        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($idPerfil);
        $catPP = $em -> getRepository(CategoriaPrincipal::class) ->find($idCatPP);
        $catSec = $em -> getRepository(CategoriaSecundaria::class) ->find($idCatSec);


        //valido que el DNI/Telefono/CodArea sean válidos y demas validaciones
        if($formulario -> isSubmitted() && $formulario -> isValid()  && $this -> telIsNumeric($contacto) && $this -> dniIsNumeric($contacto) && $this -> codAreaIsNumeric($contacto) && $this -> validacionesExtras($contacto) && $this -> validarTamanio($contacto)){
         
            $contacto = $formulario->getData();
            $archivos = $contacto ->getDocumento();

            if( count($archivos ) <= 5){
                $contador = 0;
                foreach($archivos as $archivo){
              
                    if($archivo != null){

                        
                        $documento = new Archivos();

                        
                        $extensionArchivo = $archivo -> guessExtension();
                        
                        if($extensionArchivo == 'jpg' || $extensionArchivo == 'png' || $extensionArchivo == 'pdf' || $extensionArchivo == 'docx' || $extensionArchivo == 'doc' || $extensionArchivo == 'bmp' || $extensionArchivo == 'gif' || $extensionArchivo == 'jpeg'){
                            
                            $nombreArchivo= time() . $contador .".".$extensionArchivo;
                                
                            $contador++;
                            
                            $archivo->move("uploads/archivos/",$nombreArchivo);
                            
                            $documento ->setNombreArchivo($nombreArchivo);

                            $contacto -> addArchivo($documento);

                           
                            
                        }
                        else{
                            $this -> addFlash('error', 'Extension inválida, sólo se permiten .jpg, .png, .pdf, .docx, .doc, .bmp, .gif, .jpeg');
                            return $this -> render('contacto/formularioContacto.html.twig', [
                                'formulario' => $formulario -> createView(),
                                'idCatPP' => $idCatPP,
                                'idPerfil' => $idPerfil,
                                'perfil' => $perfil,
                                'catPP' => $catPP,
                            ]);
                        }
                    }
                    
                }
            }
            else{
                $this -> addFlash('error', 'Máximo 5 archivos');
                return $this -> render('contacto/formularioContacto2.html.twig', [
                    'formulario' => $formulario -> createView(),
                    'idCatPP' => $idCatPP,
                    'idPerfil' => $idPerfil,
                    'perfil' => $perfil,
                    'catPP' => $catPP,
                ]);
            }
            $destino = $catPP -> getDestinos() ;
            
            if($destino != null){
                
                $contacto = $formulario->getData();
                // $date = $contacto -> getFechaEnvio();
                // $result = $date->format('Y-m-d');
                $em -> persist($contacto);
                $em -> flush();
    
                //Transporte del email a pata no modifico nada en el .env
                $transport = (new \Swift_SmtpTransport('smtp.gmail.com',587,'tls'))
                
                ->setUsername('intranet@unraf.edu.ar')
                ->setPassword('1ntr4n3t123');
                
                //Envio de email
                $mailer = new \Swift_Mailer($transport);

                $message = (new \Swift_Message('Hello'))
                ->setSubject('Sistema de Ayudas')
                ->setFrom('hello@example.com')
                ->setTo($destino -> getEmail())
                ->setBody(
                    '<html>' .
                    ' <body>' .
                    '<div>' .
                        '<h2 style="color:#0F9FA8;text-align:center;">Sistema de Ayudas</h2>' .
                        '<hr>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Nombre </span> :' . $contacto -> getNombre() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Apellido </span> :' . $contacto -> getApellido() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">DNI </span> :' . $contacto -> getDni() . '</h4>' .
                        '<hr>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Fecha </span> :' . $this -> getFechActualString() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Motivo del contacto </span> :' . $contacto -> getMotivoContacto() . '</h4>' .
                        '<hr>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Perfil Solicitante </span> :' . $perfil -> getDescripcionCorta() .'</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Categoria Principal </span> :' . $catPP -> getNombreCategoria() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Categoria Secundaria </span> :' . $catSec -> getNombreCategoria() . '</h4>' .
                        
                    '</div>' .
                    ' </body>' .
                    '</html>',
                      'text/html' // Mark the content-type as HTML
                )
                
                ;

                $archivosAdjuntos = $contacto -> getArchivos();
                foreach($archivosAdjuntos as $archivo){
                    $message->attach(\Swift_Attachment::fromPath('uploads/archivos/' . $archivo -> getNombreArchivo()));
                }

                $mailer->send($message);
                
            
                $mailer->send($message);
                
                foreach($archivosAdjuntos as $archivo){
                    unlink('uploads/archivos/' . $archivo -> getNombreArchivo());
                }

                $this->addFlash('info', 'Se ha enviado el mail correctamente. Pronto tendrá su respuesta en su email ' . $contacto -> getEmail());
                return $this->redirectToRoute('sistema');
            
               
               
            }
         
        }

        return $this -> render('contacto/formularioContacto.html.twig', [
            'formulario' => $formulario -> createView(),
            'idCatPP' => $idCatPP,
            'idPerfil' => $idPerfil,
            'idCatSec' => $idCatSec,
            'perfil' => $perfil,
            'catPP' => $catPP,
            'catSec' => $catSec
        ]);
    }


    /**
     * @Route("/formularioContacto2/{idPerfil}/{idCatPP}", name="formularioContacto2")
     */
    public function FormularioContacto2(Request $request, \Swift_Mailer $mailer, $idPerfil, $idCatPP){
        //Esta funcion es para el contacto y enviar un mail
        $contacto = new Contacto();

        $formulario = $this -> createForm(FormularioContactoType::class, $contacto);
        $formulario -> handleRequest($request);
        
        $em = $this -> getDoctrine() -> getManager();


        $perfil = $em -> getRepository(PerfilSolicitante::class) -> find($idPerfil);
        $catPP = $em -> getRepository(CategoriaPrincipal::class) ->find($idCatPP);


        //valido que el DNI/Telefono/CodArea sean válidos y demas validaciones
        if($formulario -> isSubmitted() && $formulario -> isValid()  && $this -> telIsNumeric($contacto) && $this -> dniIsNumeric($contacto) && $this -> codAreaIsNumeric($contacto) && $this -> validacionesExtras($contacto) && $this -> validarTamanio($contacto)){
            
            $contacto = $formulario->getData();
            $archivos = $contacto ->getDocumento();

            if( count($archivos ) <= 5){
                $contador = 0;
                foreach($archivos as $archivo){
              
                    if($archivo != null){

                        
                        $documento = new Archivos();

                        
                        $extensionArchivo = $archivo -> guessExtension();
                        
                        if($extensionArchivo == 'jpg' || $extensionArchivo == 'png' || $extensionArchivo == 'pdf' || $extensionArchivo == 'docx' || $extensionArchivo == 'doc' || $extensionArchivo == 'bmp' || $extensionArchivo == 'gif' || $extensionArchivo == 'jpeg'){
                            
                            $nombreArchivo= time() . $contador .".".$extensionArchivo;
                                
                            $contador++;
                            
                            $archivo->move("uploads/archivos/",$nombreArchivo);
                            
                            $documento ->setNombreArchivo($nombreArchivo);

                            $contacto -> addArchivo($documento);

                           
                            
                        }
                        else{
                            $this -> addFlash('error', 'Extension inválida, sólo se permiten .jpg, .png, .pdf, .docx, .doc, .bmp, .gif, .jpeg');
                            return $this -> render('contacto/formularioContacto2.html.twig', [
                                'formulario' => $formulario -> createView(),
                                'idCatPP' => $idCatPP,
                                'idPerfil' => $idPerfil,
                                'perfil' => $perfil,
                                'catPP' => $catPP,
                            ]);
                        }
                    }
                    
                }
            }
            else{
                $this -> addFlash('error', 'Máximo 5 archivos');
                return $this -> render('contacto/formularioContacto2.html.twig', [
                    'formulario' => $formulario -> createView(),
                    'idCatPP' => $idCatPP,
                    'idPerfil' => $idPerfil,
                    'perfil' => $perfil,
                    'catPP' => $catPP,
                ]);
            }


            $destino = $catPP -> getDestinos();
            
            if($destino != null){
                
                $contacto = $formulario->getData();
        
              
                //Transporte del email a pata no modifico nada en el .env
                $transport = (new \Swift_SmtpTransport('smtp.gmail.com',587,'tls'))
                
                ->setUsername('intranet@unraf.edu.ar')
                ->setPassword('1ntr4n3t123');
                
                //Envio de email
                

                $mailer = new \Swift_Mailer($transport);

                $message = (new \Swift_Message('Hello'))
                ->setSubject('Sistema de Ayudas')
                ->setFrom('hello@example.com')
                ->setTo($destino -> getEmail())
                
                ->setBody(
                    '<html>' .
                    ' <body>' .
                    '<div>' .
                        '<h2 style="color:#0F9FA8;text-align:center;">Sistema de Ayudas</h2>' .
                        '<hr>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Nombre </span> :' . $contacto -> getNombre() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Apellido </span> :' . $contacto -> getApellido() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">DNI </span> :' . $contacto -> getDni() . '</h4>' .
                        '<hr>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Fecha </span> :' . $this -> getFechActualString() . '</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Motivo del contacto </span> :' . $contacto -> getMotivoContacto() . '</h4>' .
                        '<hr>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Perfil Solicitante </span> :' . $perfil -> getDescripcionCorta() .'</h4>' .
                        ' <h4 style = "color: black;"><span style = "color: #1503ba; text-decoration: underline;">Categoria Principal </span> :' . $catPP -> getNombreCategoria() . '</h4>' .
                        
                    '</div>' .
                    ' </body>' .
                    '</html>',
                    'text/html' // Mark the content-type as HTML
                )
                
                
                ;
                

                //Al no persistir los datos de los archivos en la base de datos, tengo que hacer este get para recuperar los archivos cargados previamente en el contacto
                //Linea 390
                //Una vez todos los archivos (array) guardados los recorro y los envio
                $archivosAdjuntos = $contacto -> getArchivos();
                foreach($archivosAdjuntos as $archivo){
                    $message->attach(\Swift_Attachment::fromPath('uploads/archivos/' . $archivo -> getNombreArchivo()));
                }

                $mailer->send($message);
                
                foreach($archivosAdjuntos as $archivo){
                    unlink('uploads/archivos/' . $archivo -> getNombreArchivo());
                }

                $this->addFlash('info', 'Se ha enviado el mail correctamente. Pronto tendrá su respuesta en su email ' . $contacto -> getEmail());
                return $this->redirectToRoute('sistema');
            
            
            
            }
            else{
                $this -> addFlash('warning', 'Por favor si el email no se envía informe de este error a Luciano.romero@unraf.edu.ar');
            }
            
          
        }

        return $this -> render('contacto/formularioContacto2.html.twig', [
            'formulario' => $formulario -> createView(),
            'idCatPP' => $idCatPP,
            'idPerfil' => $idPerfil,
            'perfil' => $perfil,
            'catPP' => $catPP,
        ]);
    }


   
    //Hacer esta funcion con cada archivo
   public function validarTamanio($contacto){
        
        $archivosAdjuntos = $contacto -> getDocumento();
        foreach($archivosAdjuntos as $archivo){
            $tamanio = filesize($archivo);
            
            if($tamanio > 5000000){
                $this->addFlash('error', 'Archivo demasiado grande, máximo 5MB');
                return false;
            }
        }
        return true;
     
   }

    public function validacionesExtras($contacto){
        $nombre = $contacto -> getNombre();
        $apellido = $contacto -> getApellido();
        $motivoContacto = $contacto -> getMotivoContacto();
        if(strlen($nombre) <= 1){
            $this->addFlash('error', 'Ingrese un nombre válido');
            return false;
        }
        else if(strlen($apellido) <= 1 ){
            $this->addFlash('error', 'Ingrese un apellido válido');
            return false;
        }
        else if(strlen($motivoContacto) < 30){
            $this->addFlash('error', 'Ingrese 30 caracteres como mínimo en el motivo de su consulta');
            return false;
        }
        else{
            return true;
        }

    }

    public function telIsNumeric($contacto){
        $telefono = $contacto -> getTelefono();
        $codArea = $contacto -> getCodigoArea();

        if($telefono != null && $codArea == null){
            $this->addFlash('error', 'Por favor ingrese un código de área si ingresa un teléfono');
            return false;
        }
        else if(is_numeric($telefono) || $telefono == null){
            return true;
        }
        else{
            $this->addFlash('error', 'Ingrese un teléfono válido');
            return false;
        }
    }

    public function codAreaIsNumeric($contacto){
        $codArea = $contacto -> getCodigoArea();
        $telefono = $contacto -> getTelefono();

        if($codArea != null && $telefono == null){
         
            $this->addFlash('error', 'Por favor ingrese un teléfono si ingresa un código de área ');
            return false;
        }
        else if(is_numeric($codArea) || $codArea == null){
            return true;
        }
        else{
            $this->addFlash('error', 'Ingrese un código de área válido');
            return false;
        }
    }

    public function dniIsNumeric($contacto){
        $dni = $contacto -> getDni();
        if(is_numeric($dni) && strlen($dni) < 9 || $dni == null){
            return true;
        }
        else{
            $this->addFlash('error', 'Ingrese un DNI válido');
            return false;
        }
    }


    public function getFechActual(){
        
        $fechaActual=  new \DateTime();
                
        return $fechaActual;
    }


    public function getFechActualString(){
        $fechaActual=  new \DateTime();
        
        //Se le resta 3 horas a la fecha para que sea correcta a la actual. Desconozco el motivo
        //$fechaActual->modify("-3 hours");
        $fecha = $fechaActual->format('Y/m/d H:i');
        return $fecha;
    }


}

