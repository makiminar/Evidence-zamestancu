<?php

namespace App\Controller;

use App\Form\Type\BuildingType;
use App\Services\BuildingService;
use App\Services\ParamsParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/buildings", name="buildings_")
 */
class BuildingController extends AbstractController
{
    private BuildingService $buildingService;

    /**
     * BuildingController constructor.
     * @param BuildingService $buildingService
     */
    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('view_buildings');
        $params = ParamsParser::getParamsFromUrl($request->query->all());
        $count = $this->buildingService->countForParams($params);
        $buildings = $this->buildingService->filter($params);
        dump($count);
        return $this->render('buildings/index.html.twig', [
            'buildings' => $buildings,
            'buildingsCount' => $count,
            'params' => $params
        ]);
    }

    /**
     * @Route("/{id}", name="detail")
     * @param int $id
     * @return Response
     */
    public function detail(int $id): Response
    {
        $building = $this->buildingService->find($id);
        if (!$building) {
            return $this->render('errors/404.html.twig');
        }
        $this->denyAccessUnlessGranted('view_building', $building);
        return $this->render('buildings/detail.html.twig', ['building' => $building]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id): Response
    {
        $building = $this->buildingService->find($id);

        if (!$building) {
            return $this->render('errors/404.html.twig');
        }
        $this->denyAccessUnlessGranted('edit_building', $building);
        $form = $this->createForm(BuildingType::class, $building)
            ->add('edit', SubmitType::class, [
                'attr' => ['class' => 'button-base button-success'],
                'label' => 'Save'
            ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->buildingService->save($form->getData());
            return $this->redirectToRoute('buildings_detail', ['id' => $building->getId()]);
        }

        return $this->render('buildings/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}