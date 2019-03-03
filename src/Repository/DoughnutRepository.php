<?php
/** Namespace */
namespace App\Repository;

/** Usages */
use Doctrine\ORM\EntityRepository;
use App\Entity\Doughnut;

/**
 * Class DoughnutRepository
 * @package App\Repository
 *
 * @method Doughnut[] findAll()
 * @method Doughnut find($id, $lockMode = null, $lockVersion = null)
 * @method Doughnut findOneBy(array $criteria, array $orderBy = null)
 * @method Doughnut[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoughnutRepository extends EntityRepository
{

}