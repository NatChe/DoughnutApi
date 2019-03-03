<?php
/** Namespace */
namespace App\Exceptions;

/** Usages */
use Symfony\Component\Form\FormInterface;

/**
 * Class FormValidationException
 * @package App\Exceptions
 */
class FormValidationException extends \Exception
{
    /** @var FormInterface $form */
    private $form;

    /**
     * FormValidationException constructor.
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @return array
     */
    public function getErrorDetails() : array
    {
        return $this->getFormErrors($this->form);
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function getFormErrors(FormInterface $form) : array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getFormErrors($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}