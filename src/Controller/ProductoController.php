<?php
// src/Controller/ProductoController.php
namespace App\Controller;

use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productos")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto_index", methods={"GET"})
     */
    public function index(): Response
    {
        $productos = $this->getDoctrine()->getRepository(Producto::class)->findAll();

        return $this->json($productos);
    }

    /**
     * @Route("/{id}", name="producto_show", methods={"GET"})
     */
    public function show(Producto $producto): Response
    {
        return $this->json($producto);
    }

    /**
     * @Route("/", name="producto_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $producto = new Producto();
        $producto->setNombre($data['nombre']);
        $producto->setPrecio($data['precio']);
        $producto->setExistencia($data['existencia']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($producto);
        $entityManager->flush();

        return $this->json($producto);
    }

    /**
     * @Route("/{id}", name="producto_update", methods={"PUT"})
     */
    public function update(Request $request, Producto $producto): Response
    {
        $data = json_decode($request->getContent(), true);

        $producto->setNombre($data['nombre']);
        $producto->setPrecio($data['precio']);
        $producto->setExistencia($data['existencia']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($producto);
    }

    /**
     * @Route("/{id}", name="producto_delete", methods={"DELETE"})
     */
    public function delete(Producto $producto): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($producto);
        $entityManager->flush();

        return $this->json(['message' => 'Producto eliminado']);
    }
}
