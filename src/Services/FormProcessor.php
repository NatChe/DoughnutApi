<?php
/** Namespace */
namespace App\Services;

/** Usages */
use App\Exceptions\FormValidationException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class FormProcessor
 * @package App\Services
 */
class FormProcessor
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * FormProcessor constructor.
     * @param EntityManager $entityManager
     * @param FormFactory $formFactory
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $entityManager, FormFactory $formFactory, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return FormFactory
     */
    public function getFormFactory(): FormFactory
    {
        return $this->formFactory;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    public function getRequest() {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * @param $formType
     * @param null $data
     * @return mixed
     * @throws FormValidationException
     */
    public function submit($formType, $data = null) {
        $form = $this->formFactory->create($formType, $data, [
            'method' => $this->getRequest()->getMethod()
        ]);
        $form->handleRequest($this->getRequest());

        if ((!$form->isSubmitted()) || (!$form->isValid())) {
            if ($form->getErrors(true)->count() > 0) {
                throw new FormValidationException($form);
            } else {
                throw new BadRequestHttpException('Invalid format');
            }
        }

        return $form->getData();
    }
}