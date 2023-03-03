<?php

namespace Rbnb\Http\Controller;

use Rbnb\System\Http\Controller;

class PageController extends Controller
{
    public function index(): void
    {
        echo $this->twig->render('visitor/home.twig', ['title' => 'Bienvenue sur RBNB!']);
    }
}