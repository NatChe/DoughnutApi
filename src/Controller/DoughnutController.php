<?php
/** Namespace */
namespace App\Controller;

/** Usages */
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DoughnutController
 * @package App\Controller
 */
class DoughnutController
{
    /**
     * @Route("/doughnuts/", methods={"GET"})
     * @return Response
     */
    public function list()
    {
        return new Response('ok');
    }

    /**
     * @Route("/doughnuts/{id}/", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function get($id)
    {
        return new Response($id);
    }

    public function post()
    {
        // TODO implement
    }
}