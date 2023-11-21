<?php
// src/Controller/DireccionController.php
namespace App\Controller;

use App\Entity\Direccion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/direcciones")
 */
class DireccionController extends AbstractController
{
    /**
     * @Route("/", name="direccion_index", methods={"GET"})
     */
    public function index(): Response
    {
        $direcciones = $this->getDoctrine()->getRepository(Direccion::class)->findAll();

        return $this->json($direcciones);
    }

    /**
     * @Route("/{id}", name="direccion_show", methods={"GET"})
     */
    public function show(Direccion $direccion): Response
    {
        return $this->json($direccion);
    }

    /**
     * @Route("/", name="direccion_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $direccion = new Direccion();
        // Asignar valores a las propiedades de la entidad según los datos recibidos.

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($direccion);
        $entityManager->flush();

        return $this->json($direccion);
    }

    /**
     * @Route("/{id}", name="direccion_update", methods={"PUT"})
     */
    public function update(Request $request, Direccion $direccion): Response
    {
        $data = json_decode($request->getContent(), true);

        // Actualizar las propiedades de la entidad según los datos recibidos.

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($direccion);
    }

    /**
     * @Route("/{id}", name="direccion_delete", methods={"DELETE"})
     */
    public function delete(Direccion $direccion): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($direccion);
        $entityManager->flush();

        return $this->json(['message' => 'Dirección eliminada']);
    }
}
