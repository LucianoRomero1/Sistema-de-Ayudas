<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Destinos;
use App\Entity\CategoriaPrincipal;
use App\Form\DestinoType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserBusqueda;
use App\Form\UserBusquedaType;


class DestinoController extends AbstractController
{
    /**
     * @Route("/admin/altaDestino", name="altaDestino")
     */
    public function altaDestino(Request $request)
    {
        $destino = new Destinos();

        $formulario = $this -> createForm(DestinoType::class, $destino);
        $formulario -> handleRequest($request);

        if($formulario -> isSubmitted() && $formulario -> isValid()){
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($destino);
            $em -> flush();

            $this -> addFlash('info', '¡El destino se cargó correctamente!');
            return $this -> redirectToRoute('verDestinos');
        }

        return $this -> render('destino/altaDestino.html.twig', 
        ['formulario' => $formulario -> createView()]);
    }


    /**
     * @Route("/admin/verDestinos", name="verDestinos")
     */
    public function verDestino(Request $request){
        $em = $this -> getDoctrine() -> getManager();

        $form = $this -> createForm(UserBusquedaType::class, new UserBusqueda());
        $form -> handleRequest($request);
        $busqueda = $form -> getData();


        $destino = $em -> getRepository(Destinos::class) ->findBy(array(), array('email' => 'ASC'));


        if($form -> isSubmitted()){
            return $this -> render('destino/verDestino.html.twig', [
                'destino' => $this -> buscarDestino($busqueda), 'formulario' => $form -> createView()
                ]);
        }
        else{
            return $this -> render('destino/verDestino.html.twig', [
                'destino' => $destino, 'formulario' => $form -> createView()
            ]);
        }

    }


    public function buscarDestino(UserBusqueda $busqueda){
        $manager=$this->getDoctrine()->getManager();
        
        $query = $manager->createQuery(
        "SELECT d
        FROM App\Entity\Destinos d
        WHERE d.email LIKE :email
        ORDER BY d.id ASC
        "
        )->setParameter('email','%'. $busqueda->getBuscar().'%');
        
        
        //Límite de resultados..
        $query->setMaxResults(100);
        
        //Retorna busqueda de la compra..
        return $query->getResult();
    }


      /**
     * @Route("/admin/modificarDestino/{id}", name="modificarDestino")
     */
    public function modificarDestino($id, Request $request){
        $em = $this -> getDoctrine() -> getManager();
        
        $destino = $em -> getRepository(Destinos::class) -> find($id);

        $formulario = $this -> createForm(DestinoType::class, $destino);
        $formulario -> handleRequest($request);

        if($formulario -> isSubmitted() && $formulario -> isValid()){
            
            $this -> addFlash('info', '¡El destino se modificó correctamente!');
            $em -> flush();

            return $this -> redirectToRoute('verDestinos');
        }

        return $this -> render('destino/modificarDestino.html.twig',[
            'formulario' => $formulario -> createView()
        ]);
    }



       /**
     * @Route("/admin/eliminarDestino/{id}", name="eliminarDestino")
     */
    public function eliminarDestino($id){
        $em = $this -> getDoctrine() -> getManager();
        $destino = $em -> getRepository(Destinos::class) -> find($id);

        $em -> remove($destino);
        $em -> flush();

        $this -> addFlash('info', '¡El destino se eliminó correctamente!');
        return $this -> redirectToRoute('verDestinos');
    }
     


    /**
     * @Route("/admin/asignarCategoriaDestino/{id}", name="asignarCategoriaDestino")
     */
    public function AsignarCategoriaDestino($id){

        $em = $this -> getDoctrine() -> getManager();
        $destino = $em -> getRepository(Destinos::class) -> find($id);
        $categoriasDestino = $destino -> getCategoriaPP();

        //Arriba asigno una categoria a un perfil y aca muestro las demas categorias restantes.
        // $categoriasResto = $em -> getRepository(CategoriaPrincipal::class) -> findAll();

        //Ordena alfabeticamente pero solo las categorias restantes las agregadas ordenarlas con SORT en twig
        $categoriasResto= $em->getRepository(CategoriaPrincipal::class)->findBy(array(), array('nombre_categoria' => 'ASC'));

        return $this -> render('destino/asignarDestino.html.twig', [
            "categoriasDestino" => $categoriasDestino,
            "categoriasResto" => $categoriasResto,
            "destino" => $destino 
        ]);
    }


     /**
     * @Route("/admin/agregarCategoriaDestino/{id}/{id2}", name="agregarCategoriaDestino")
     */
    public function AgregarCategoriaPerfil($id, $id2){
        $em = $this -> getDoctrine() -> getManager();
        $destino = $em -> getRepository(Destinos::class) -> find($id2);
        $categoriaPP = $em -> getRepository(CategoriaPrincipal::class) -> find($id);

        $destino -> addCategoriaPP($categoriaPP);
        $categoriaPP -> setEmailAsignado(true);
        $em -> persist($destino);
        $em -> flush();

        $this -> addFlash('info', '¡Categoría asignada correctamente!');
        return $this -> AsignarCategoriaDestino($id2);
    }

    /**
     * @Route("/admin/eliminarCategoriaDestino/{id}/{id2}", name="eliminarCategoriaDestino")
     */
    public function EliminarCategoriaPerfil($id, $id2){
        $em = $this -> getDoctrine() -> getManager();

        $destino = $em -> getRepository(Destinos::class) -> find($id2);
        $categoriaPP = $em -> getRepository(CategoriaPrincipal::class) -> find($id);

        $categoriaPP -> setEmailAsignado(false);
        $destino -> removeCategoriaPP($categoriaPP);
        $em -> flush();

        $this -> addFlash('info', '¡La categoría asignada se eliminó correctamente!');
        return $this -> AsignarCategoriaDestino($id2);
    }
}
