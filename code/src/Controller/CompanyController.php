<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company")
     * @param  \Doctrine\ORM\EntityManagerInterface  $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $companies = $entityManager
          ->getRepository(Company::class)
          ->findAll();
        return $this->render('company/index.html.twig', [
          'controller_name' => 'CompanyController',
          'companies' => $companies
        ]);
    }


    /**
     * @param  Request  $request
     * @param  EntityManagerInterface  $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/company/new", name="company_new")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(CompanyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $company = new Company();
            $company->setName($data['name']);
            $company->setEmail($data['email']);

            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company');
        }

        return $this->render('company/new.html.twig', [
          'form' => $form->createView(),
        ]);
    }

}
