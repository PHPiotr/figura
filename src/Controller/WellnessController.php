<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WellnessController extends AbstractController
{
    public function index()
    {
        $number = random_int(0, 100);

        return $this->render('wellness.html.twig', [
            'number' => $number,
        ]);
    }
}
