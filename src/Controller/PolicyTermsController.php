<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PolicyTermsController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('policy_terms/contact.html.twig');
    }

    #[Route('/about-us', name: 'app_about_us')]
    public function about(): Response
    {
        return $this->render('policy_terms/about.html.twig');
    }

    #[Route('/privacy-policy', name: 'app_privacy_policy')]
    public function policy(): Response
    {
        return $this->render('policy_terms/policy.html.twig');
    }

    #[Route('/terms-and-conditions', name: 'app_terms_conditions')]
    public function terms(): Response
    {
        return $this->render('policy_terms/terms.html.twig');
    }
}
