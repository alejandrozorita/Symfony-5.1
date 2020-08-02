<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Company;

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
}
