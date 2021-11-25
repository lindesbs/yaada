<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Section;
use App\Form\ItemEditType;
use App\Form\SectionEditType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
	/**
	 * @Route("/", name="dashboard")
	 */
	public function index(ItemRepository $itemRepository): Response
	{
		$arrItems = $itemRepository->getAllForOverview();

		$section0 = new Section();
		$section0->setName("Allgemein");
		$section0->setDescription("Sammelbecken");

		$arrOutputSections = [];
		$arrOutputItems = [];
		foreach ($arrItems as $item)
		{
			$section = ($item->getSection()) ?: $section0;

			$id=0;

			if ($item->getSection())
			{
				$id = $item->getSection()->getId() ?: 0;
			}

			if (!array_key_exists($id, $arrOutputItems))
			{
				$arrOutputItems[$id] = [];
			}

			$arrOutputSections[$id] = $section;
			$arrOutputItems[$id][] = $item;
		}


		return $this->render('dashboard/index.html.twig', [
			'sections' => $arrOutputSections,
			'items' => $arrOutputItems
		]);
	}


	/**
	 * @Route("/add", name="application_add")
	 * @Route("/edit/{itemId}", name="application_edit")
	 */
	public function add(Request $request, int $itemId =-1,ItemRepository $itemRepository): Response
	{
		$app = new Item();

		if ($itemId>0)
		{
			$app = $itemRepository->findOneBy(["id" => $itemId]);
		}

		$form = $this->createForm(ItemEditType::class, $app);


		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			/* @var Item $app */
			$app = $form->getData();
			$app->setNewTab(true);
			$app->setSorting(1);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($app);
			$entityManager->flush();

			return $this->redirectToRoute('dashboard');
		}

		return $this->renderForm('dashboard/edit.html.twig', [
			'form' => $form,
		]);
	}

	/**
	 * @Route("/addSection", name="application_add_section")
	 */
	public function addSection(Request $request): Response
	{
		$section = new Section();

		$form = $this->createForm(SectionEditType::class, $section);


		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$section = $form->getData();

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($section);
			$entityManager->flush();

			return $this->redirectToRoute('dashboard');
		}

		return $this->renderForm('dashboard/editSection.html.twig', [
			'form' => $form,
		]);
	}
}
