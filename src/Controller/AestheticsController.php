<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AestheticsController extends AbstractController
{
    public function index()
    {
        return $this->render('aesthetics.html.twig', []);
    }
    public function liposuction()
    {
        return $this->render('aesthetics.html.twig', [
            'active' => 'liposuction'
        ]);
    }
    public function endermology()
    {
        return $this->render('aesthetics.html.twig', [
            'active' => 'endermology',
        ]);
    }
    public function multipolarWave()
    {
        return $this->render('aesthetics.html.twig', [
            'active' => 'multipolar_wave',
        ]);
    }
    public function lipolaser()
    {
        return $this->render('aesthetics.html.twig', [
            'active' => 'lipolaser',
        ]);
    }
}
