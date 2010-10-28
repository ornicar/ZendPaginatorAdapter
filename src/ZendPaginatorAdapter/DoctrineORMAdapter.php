<?php

namespace ZendPaginatorAdapter;

use Doctrine\ORM\Query;
use Zend\Paginator\Adapter;
use DoctrineExtensions\Paginate\Paginate;

class DoctrineORMAdapter implements Adapter
{
    /**
     * The query to paginate
     *
     * @var Query
     */
    protected $query = null;

    /**
     * @see PaginatorAdapterInterface::__construct
     *
     * @param Query the query to paginate
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * @see Zend\Paginator\Adapter:getItems
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $ids = $this->createLimitSubquery($offset, $itemCountPerPage)
                        ->getScalarResult();

        $ids = array_map(function ($e) { return current($e); }, $ids);

        return $this->createWhereInQuery($ids)->getResult();
    }

    /**
     * @see Zend\Paginator\Adapter:count
     */
    public function count()
    {
        return $this->createCountQuery()->getSingleScalarResult();
    }

    protected function createCountQuery()
    {
        return Paginate::createCountQuery($this->query);
    }

    protected function createLimitSubquery($offset, $itemCountPerPage)
    {
        return Paginate::createLimitSubQuery($this->query, $offset, $itemCountPerPage);
    }

    protected function createWhereInQuery($ids)
    {
        return Paginate::createWhereInQuery($this->query, $ids);
    }

}
