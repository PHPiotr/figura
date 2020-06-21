<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends AbstractController
{
    public function index()
    {
        $content = $this->renderView("sitemap.txt.twig");
        $textResponse = new Response($content , 200);
        $textResponse->headers->set('Content-Type', 'text/plain');
        return $textResponse;
    }
}
