<?php

namespace App\Controller\Traits;

/**
 * Trait DoctrineTrait
 *
 * @package App\Controller\Traits
 */
trait DoctrineTrait
{
    /**
     * @param string $repository
     *
     * @return array
     */
    protected function findAll(string $repository)
    {
        return $this->repository($repository)->findAll();
    }

    /**
     * @param string $repository
     * @param int    $id
     *
     * @return null|object
     */
    protected function find(string $repository, int $id)
    {
        return $this->repository($repository)->find($id);
    }

    /**
     * @param string $repository
     * @param string $slug
     *
     * @return null|object
     */
    protected function findOneBySlug(string $repository, string $slug)
    {
        return $this->repository($repository)->findOneBy(
            [
                'slug' => $slug,
            ]
        );
    }

    /**
     * @param string $repository
     * @param string $slug
     *
     * @return array
     */
    protected function findBySlug(string $repository, string $slug)
    {
        return $this->repository($repository)->findBy(
            [
                'slug' => $slug,
            ]
        );
    }

    /**
     * @param string $repository
     * @param array  $criteria
     *
     * @return null|object
     */
    protected function findOneBy(string $repository, array $criteria)
    {
        return $this->repository($repository)->findOneBy($criteria);
    }

    /**
     * @param string     $repository
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array
     */
    protected function findBy(string $repository, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository($repository)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param string $repository
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function repository(string $repository)
    {
        return $this->getManager()->getRepository($repository);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param object $object
     */
    protected function persist($object)
    {
        $this->getManager()->persist($object);
    }

    protected function flush()
    {
        $this->getManager()->flush();
    }
}
