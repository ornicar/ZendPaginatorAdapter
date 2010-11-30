<?php

namespace ZendPaginatorAdapter;

use Zend\Paginator\Adapter;
use Doctrine\ODM\MongoDB\QueryBuilder;
use Doctrine\ODM\MongoDB\MongoCursor;

/**
 * Implements the Zend\Paginator\Adapter Interface for use with Zend\Paginator\Paginator
 *
 * Allows pagination of Doctrine\ODM\MongoDB\Query objects
 */
class DoctrineMongoDBAdapter implements Adapter
{
    /**
     * The query builder to paginate
     *
     * @var QueryBuilder
     */
    protected $queryBuilder = null;

    /**
     * @see PaginatorAdapterInterface::__construct
     *
     * @param QueryBuilder the query builder to paginate
     */
    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @see Zend\Paginator\Adapater::getItems
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $queryBuilder = clone $this->queryBuilder;

        $results = $queryBuilder->skip($offset)->limit($itemCountPerPage)->getQuery()->execute();

        // If we get a MongoCursor, transform it to an array
        if($results instanceof MongoCursor) {
            $results = $results->toArray();
        }

        // Dont use object IDs as array keys
        return array_values($results);
    }

    /**
     * @see Zend\Paginator\Adapter::count
     */
    public function count()
    {
        return $this->queryBuilder->getQuery()->count();
    }
}
