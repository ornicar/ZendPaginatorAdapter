<?php

namespace ZendPaginatorAdapter;

use Zend\Paginator\Adapter;
use Doctrine\ODM\MongoDB\Query;
use Doctrine\ODM\MongoDB\MongoCursor;

/**
 * Implements the Zend\Paginator\Adapter Interface for use with Zend\Paginator\Paginator
 *
 * Allows pagination of Doctrine\ODM\MongoDB\Query objects
 */
class DoctrineMongoDBAdapter implements Adapter
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
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @see Zend\Paginator\Adapater::getItems
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $query = clone $this->query;

        $results = $query->skip($offset)->limit($itemCountPerPage)->execute();

        // If we get a MongoCursor, transform it to an array
        if($results instanceof MongoCursor) {
            $results = $results->getResults();
        }

        // Dont use object IDs as array keys
        return array_values($results);
    }

    /**
     * @see Zend\Paginator\Adapter::count
     */
    public function count()
    {
        return $this->query->count();
    }
}
