<?php
/** Namespace */
namespace App\Controller;

/** Usages */
use App\Entity\Doughnut;
use App\Form\DoughnutType;
use App\Services\FormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DoughnutController
 * @package App\Controller
 */
class DoughnutController extends AbstractController
{
    /**
     * @var FormProcessor
     */
    private $formProcessor;

    /**
     * DoughnutController constructor.
     * @param FormProcessor $formProcessor
     */
    public function __construct(FormProcessor $formProcessor)
    {
        $this->formProcessor = $formProcessor;
    }

    /**
     * @return FormProcessor
     */
    public function getFormProcessor(): FormProcessor
    {
        return $this->formProcessor;
    }

    /**
     * @Route("/doughnuts/", methods={"GET"})
     * @return Response
     */
    public function list()
    {
        $doughnuts = $this->getDoctrine()
            ->getRepository(Doughnut::class)
            ->findAll();
        return new JsonResponse($doughnuts);
    }

    /**
     * @Route("/doughnuts/", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function post(EntityManagerInterface $entityManager)
    {
       try {
           $doughnut = $this->getFormProcessor()->submit(DoughnutType::class);
           $entityManager->persist($doughnut);
           $entityManager->flush();
           return $this->generateResponse(Response::HTTP_CREATED, [
               'Location' => ''
           ]);
       } catch (\Exception $exception) {
           // TODO return form errors
           return $this->generateResponse(Response::HTTP_BAD_REQUEST);
       }
    }

    /**
     * Generate an api response
     *
     * @param $status
     * @param array $headers
     * @return Response
     */
    protected function generateResponse ($status, array $headers = [])
    {
        return new Response('', $status, $headers);
    }
}