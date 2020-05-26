<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FitnessController extends AbstractController
{
    public function index()
    {
        return $this->render('fitness.html.twig', [
            'active' => 'swan_shaper',
        ]);
    }

    public function swanShaper()
    {
        return $this->render('fitness.html.twig', [
            'active' => 'swan_shaper',
        ]);
    }

    public function vacuShaper()
    {
        return $this->render('fitness.html.twig', [
            'active' => 'vacu_shaper',
        ]);
    }

    public function rollShaper()
    {
        return $this->render('fitness.html.twig', [
            'active' => 'roll_shaper',
        ]);
    }

    public function vibrationPlatform()
    {
        return $this->render('fitness.html.twig', [
            'active' => 'vibration_platform',
        ]);
    }

    public function horizontalBike()
    {
        return $this->render('fitness.html.twig', [
            'active' => 'horizontal_bike',
        ]);
    }
}
