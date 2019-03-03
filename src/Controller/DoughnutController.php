<?php
/** Namespace */
namespace App\Controller;

/** Usages */
use App\Entity\Doughnut;
use App\Form\DoughnutType;
use App\Services\FormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DoughnutController
 * @package App\Controller
 * @method Doughnut doughnut()
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
        return $this->json($doughnuts, Response::HTTP_OK, [], [
            'groups' => ['default'],
        ]);
    }

    /**
     * @Route("/doughnuts/{reference}/", methods={"GET"})
     * @param Doughnut $doughnut
     * @return JsonResponse
     * @ParamConverter("doughnut", class="App\Entity\Doughnut")
     */
    public function show(Doughnut $doughnut)
    {
        return $this->json($doughnut, Response::HTTP_OK, [], [
            'groups' => ['default']
        ]);
    }

    /**
     * @Route("/doughnuts/", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function new(EntityManagerInterface $entityManager)
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
     * @Route("/doughnuts/{reference}", methods={"DELETE"})
     * @param EntityManagerInterface $entityManager
     * @param Doughnut $doughnut
     * @return JsonResponse
     * @ParamConverter("doughnut", class="App\Entity\Doughnut")
     */
    public function remove(EntityManagerInterface $entityManager, Doughnut $doughnut)
    {
        $entityManager->remove($doughnut);
        $entityManager->flush();

        return $this->json('', Response::HTTP_NO_CONTENT);
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