<?php

namespace App\Controller\Admin;

use claviska\SimpleImage;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocieteAdmin extends AbstractController
{
    private $adminUrlGenerator;
    private $image;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->image = 'images/societe';
    }

    #[Route('/admin/site/config/societe', name: 'admin_societe_config')]
    public function index(): Response
    {
        //this gets the root of the config.yaml file
        $file = $this->getParameter('app_root').'/config/societe.yaml';

        //This shows the keys and values of the config.yaml file
        $form = Yaml::parseFile($file);
        //dd($form);

        return $this->render('Admin/site_config/societeconfig.html.twig', [
            'forms' => $form,
            'image' => $this->image,
        ]);
    }

    #[Route('/admin/site/modify/config/societe', name: 'admin_modifier_societe_config')]
    public function modifyConfig(Request $request, CacheInterface $cache): Response
    {
        $file = $this->getParameter('app_root').'/config/societe.yaml';
        $form = Yaml::parseFile($file);

        //Check if the request exit
        if ($request->request) {
            if($request->files->has('social')){
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $request->files->get('social');
                $theImage = $uploadedFile['tabs']['image']['value'];
                $newFilename = md5(uniqid()) . '.' . $theImage->guessExtension();

                // Move the file to the new location
                $theImage->move($this->image, $newFilename);

                $miniature = new SimpleImage();
                $miniature->fromFile($this->image.'/'.$newFilename)
                        ->resize(320, 200)
                        ->toFile($this->image.'/miniatures/'.$newFilename, 'image/jpeg', 100);
                
                // Update the image path in YAML file
                $form['social']['tabs']['image']['value'] = $newFilename;
            }

            file_put_contents($file, Yaml::dump(array_replace_recursive(Yaml::parseFile($file), $form), 4));
            $cache->delete('societe');
        }

        return $this->redirect(
            $this->adminUrlGenerator->setRoute('admin_societe_config', [])->generateUrl()
        );
    }
}
