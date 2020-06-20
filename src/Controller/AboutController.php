<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    public function index()
    {
        return $this->render('about.html.twig', [
            'experienceYears' => date('Y') - 2007,
        ]);
    }
}
