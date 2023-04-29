<?php

namespace App\Controller\Admin;

use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfigurationAdmin extends AbstractController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin/site/configuration', name: 'admin_site_config')]
    public function index(): Response
    {
        //this gets the root of the config.yaml file
        $file = $this->getParameter('app_root').'/config/configuration.yaml';

        //This shows the keys and values of the config.yaml file
        $form = Yaml::parseFile($file);
        //dd($form);

        return $this->render('Admin/site_config/siteconfig.html.twig', [
            'forms' => $form,
        ]);
    }

    #[Route('/admin/site/modify/config', name: 'admin_site_modify_config')]
    public function modifyConfig(Request $request, CacheInterface $cache): Response
    {
        $file = $this->getParameter('app_root').'/config/configuration.yaml';
        $form = Yaml::parseFile($file);

        //Check if the request exit
        if ($request->request) {
            foreach ($request->request->all() as $key => $value) {
                foreach ($value as $k => $v) {
                    $form[$key]['tabs'][$k]['value'] = $v;
                }
            }

            file_put_contents($file, Yaml::dump($form, 4));
            $cache->delete('configuration');
        }

        return $this->redirect(
            $this->adminUrlGenerator->setRoute('admin_site_config', [])->generateUrl()
        );
    }
}
