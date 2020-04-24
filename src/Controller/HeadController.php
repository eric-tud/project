<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HeadController extends AbstractController
{
    /**
     * @Route("/head", name="head")
     * @IsGranted("ROLE_HEAD")
     */
    public function index()
    {
        return $this->render('head/index.html.twig', [
            'controller_name' => 'HeadController',
        ]);
    }
}
