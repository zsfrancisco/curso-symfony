<?php

namespace App\Controller;

use App\Entity\Nota;
use App\Entity\Estudiante;
use App\Entity\Asignatura;
use App\Form\NotaType;
use App\Repository\NotaRepository;
use App\Repository\AsignaturaRepository;
use App\Repository\EstudianteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nota")
 */
class NotaController extends AbstractController
{
    /**
     * @Route("/", name="nota_index", methods={"GET"})
     */
    public function index(AsignaturaRepository $asignaturaRepository, NotaRepository $notaRepository, EstudianteRepository $estudianteRepository): Response
    {
        return $this->render('nota/index.html.twig', [
            'asignaturas' => $asignaturaRepository->findAll(),
            'estudiantes' => $estudianteRepository->findAll(),
            'notas' => $notaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show_student/{id}", name="show_student", methods={"GET"})
     */
    public function show_student($id, NotaRepository $notaRepository): Response
    {
        return $this->render('nota/notas_estudiante.html.twig', [
            'notas' => $notaRepository->findBy(
                ['estudiante' => $id]
            ),
        ]);
    }

    /**
     * @Route("/aprobados/{id}", name="aprobados", methods={"GET"})
     */
    public function estudiantes_aprobados($id, NotaRepository $notaRepository): Response
    {
        return $this->render('nota/estudiantes_aprobados.html.twig', [
            'notas' => $notaRepository->estudiantesAprobados($id)
        ]);
    }

    /**
     * @Route("/new", name="nota_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $notum = new Nota();
        $form = $this->createForm(NotaType::class, $notum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notum);
            $entityManager->flush();

            return $this->redirectToRoute('nota_index');
        }

        return $this->render('nota/new.html.twig', [
            'notum' => $notum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nota_show", methods={"GET"})
     */
    public function show(Nota $notum): Response
    {
        return $this->render('nota/show.html.twig', [
            'notum' => $notum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nota_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nota $notum): Response
    {
        $form = $this->createForm(NotaType::class, $notum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nota_index');
        }

        return $this->render('nota/edit.html.twig', [
            'notum' => $notum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nota_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nota $notum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nota_index');
    }
}
