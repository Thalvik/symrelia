<?php

namespace Thalvik\SymreliaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormTypeInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations AS RestRoute;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Thalvik\SymreliaBundle\Entity\Article;


class ArticleController extends FOSRestController {


    /**
    * Get all articles.
    *
    * @ApiDoc(
    *   resource = true,
    *   statusCodes = {
    *     200 = "Returned when successful"
    *   }
    * )
    * @RestRoute\Get("/")
    *
    *
    *
    * @param Request               $request      the request object
    * @param ParamFetcherInterface $paramFetcher param fetcher service
    *
    * @return array
    */

    public function getArticlesAction() {

       return $this->allArticlesView();
    }


    /**
    * Get a single article.
    *
    * @ApiDoc(
    *   output = "Thalvik\SymreliaBundle\Entity\Article",
    *   statusCodes = {
    *     200 = "Returned when successful",
    *     404 = "Returned when the item is not found"
    *   }
    * )
    *
    * @RestRoute\Get("/{id}", requirements={"id" = "\d+"})
    *
    * @param int     $id      the item id
    *
    * @return array
    *
    * @throws NotFoundHttpException when item not exist
    */
    public function getArticleAction($id) {

        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ThalvikSymreliaBundle:Article')->find((int)$id);
        if (empty($article)) {
            throw $this->createNotFoundException('Does not exist.');
        }

        $view = $this->view($article, 200);
        return $this->handleView($view);
    }


    /**
    * Creates a new article from the submitted data.
    *
    * @ApiDoc(
    *   resource = true,
    *   input = "Thalvik\SymreliaBundle\Entity\Article",
    *   statusCodes = {
    *     200 = "Returned when successful",
    *     400 = "Returned when the form has errors"
    *   }
    * )
    * @RestRoute\Post("/")
    *
    * @RestRoute\View()
    *
    * @param Request $request the request object
    *
    * @return FormTypeInterface[]|View
    */
    public function postArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->get('article');
        $article = $em->getRepository('ThalvikSymreliaBundle:Article')->getArticle($data);
        return $this->processForm($request, $article);
    }

    /**
    * Updates a article from the submitted data.
    *
    * @ApiDoc(
    *   resource = true,
    *   input = "Thalvik\SymreliaBundle\Entity\Article",
    *   statusCodes = {
    *     200 = "Returned when successful",
    *     400 = "Returned when the form has errors"
    *   }
    * )
    *
    * @RestRoute\Put("/{id}", requirements={"id" = "\d+"})
    *
    * @RestRoute\View()
    *
    * @param Request $request the request object
    * @param int     $id      the note id
    *
    * @return FormTypeInterface[]|View
    */
    public function putArticleAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('ThalvikSymreliaBundle:Article')->find($id);
        return $this->processForm($request, $article);
    }

    /**
    * Deletes a article.
    *
    * @ApiDoc(
    *   resource = true,
    *   statusCodes={
    *     204="Returned when successful"
    *   }
    * )
    * @RestRoute\Delete("/{id}", requirements={"id" = "\d+"})   
    *
    * @param Request $request the request object
    * @param int     $id      the note id
    *
    * @return View
    */
    public function deleteArticleAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('ThalvikSymreliaBundle:Article')->deleteArticle($id);
        return $this->allArticlesView();
    }


    private function processForm(Request $request, Article $article) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('article', $article);
        $form->bind($request);

        if ($form->isValid()) {

            try {
                $articleObject = $em->getRepository('ThalvikSymreliaBundle:Article')->saveArticle($article);

                //return $this->routeRedirectView('api_articles_get_article', array('id' => $articleObject->getId()), 301);

                //return new JsonResponse(array('Ovo je response'));
                // $view = $this->view($articleObject, 200);
                // return $this->handleView($view);

                return $this->allArticlesView();

            } catch (\Exception $e) {
                var_dump($e->getMessage());
                die();
            }
        }

        $view = $this->view($form, 400);
        return $this->handleView($view);

    }

    private function allArticlesView() {

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('ThalvikSymreliaBundle:Article')->findAll();

        $view = $this->view($articles, 200)
        ->setTemplate("ThalvikSymreliaBundle:Article:getArticles.html.twig")
        ->setTemplateVar('articles');

        return $this->handleView($view);
    }

}
