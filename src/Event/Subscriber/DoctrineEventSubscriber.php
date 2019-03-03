<?php
/** Namespace */
namespace App\Event\Subscriber;

/** Usages */
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 * Class DoctrineEventSubscriber
 * @package App\Event\Subscriber
 */
class DoctrineEventSubscriber implements EventSubscriber
{
    /** @var array $fields */
    private $fields = [
        'updatedAt', 'createdAt'
    ];

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist'
        ];
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        /** @var mixed $entity */
        $entity = $eventArgs->getObject();
        /** @var ClassMetadata $metaData */
        $metaData = $eventArgs->getObjectManager()->getClassMetadata(get_class($entity));
        /** @var \DateTime $current */
        $current = new \DateTime();

        foreach($this->fields as $field) {
            if ($metaData->hasField($field) and
                !$entity->{'get'.ucfirst($field)}() instanceof \DateTime) {
                $entity->{'set'.ucfirst($field)}($current);
            }
        }
    }
}