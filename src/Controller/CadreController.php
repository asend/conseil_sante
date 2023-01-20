<?php

namespace App\Controller;

use App\Entity\Cadre;
use App\Form\CadreType;
use App\Repository\CadreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cadre')]
class CadreController extends AbstractController
{
    #[Route('/', name: 'app_cadre_index', methods: ['GET'])]
    public function index(CadreRepository $cadreRepository): Response
    {
        return $this->render('cadre/index.html.twig', [
            'cadres' => $cadreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cadre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CadreRepository $cadreRepository): Response
    {
        $cadre = new Cadre();
        $form = $this->createForm(CadreType::class, $cadre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cadreRepository->add($cadre, true);

            return $this->redirectToRoute('app_cadre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cadre/new.html.twig', [
            'cadre' => $cadre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cadre_show', methods: ['GET'])]
    public function show(Cadre $cadre): Response
    {
        return $this->render('cadre/show.html.twig', [
            'cadre' => $cadre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cadre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cadre $cadre, CadreRepository $cadreRepository): Response
    {
        $form = $this->createForm(CadreType::class, $cadre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cadreRepository->add($cadre, true);

            return $this->redirectToRoute('app_cadre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cadre/edit.html.twig', [
            'cadre' => $cadre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cadre_delete', methods: ['POST'])]
    public function delete(Request $request, Cadre $cadre, CadreRepository $cadreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cadre->getId(), $request->request->get('_token'))) {
            $cadreRepository->remove($cadre, true);
        }

        return $this->redirectToRoute('app_cadre_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/corps/{id}', name: 'app_cadre_corp')]
    public function getCorpsById(Request $request, SerializerInterface $serializerInterface, CadreRepository $cadreRepository, Cadre $cadre): Response
    {
        //dd($request->get('id'));
        // $json = $serializerInterface->serialize($cadreRepository->findAll(), 'json');
        // $response = new Response($json, 200, [
        //     "Content-Type" => "application/json"
        // ]);
        //return  $this->json($secteurRepository->findAll(), 200, [], ['groups' => 'secteur:read']);

        $responseArray = array();
        foreach($cadreRepository->find($request->get('id'))->getCorps() as $corps){
            $responseArray[] = array(
                "id" => $corps->getId(),
                "name" => $corps->getNom()
            );
        }
        
        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);
    }
}