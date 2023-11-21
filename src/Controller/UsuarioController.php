<?php
// src/Controller/UsuarioController.php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuarios', name: 'usuarios')]
class UsuarioController extends AbstractController
{
    #[Route('', name: 'app_usuario_read_all', methods: ['GET'])]
    public function readAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

        $data = [];
        foreach ($usuarios as $usuario) {
            $usuarioData = $this->serializeUsuario($usuario);
            $data[] = $usuarioData;
        }

        return $this->json($data);
    }

    #[Route('/{id}', name: 'app_usuario_read_one', methods: ['GET'])]
    public function readOne(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        if (!$usuario) {
            return $this->json(['error' => 'No se encontró el usuario.'], 404);
        }

        $usuarioData = $this->serializeUsuario($usuario);

        return $this->json($usuarioData);
    }

    private function serializeUsuario(Usuario $usuario): array
    {
        $usuarioData = [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'edad' => $usuario->getEdad(),
        ];

        $direccionesData = [];
        foreach ($usuario->getDirecciones() as $direccion) {
            $direccionesData[] = [
                'id' => $direccion->getId(),
                'departamento' => $direccion->getDepartamento(),
                'municipio' => $direccion->getMunicipio(),
                'direccion' => $direccion->getDireccion(),
                // ... Agregar otras propiedades según la entidad Direccion
            ];
        }

        $usuarioData['direcciones'] = $direccionesData;

        return $usuarioData;
    }
}

