# Provides Zend Paginator Adapter implementations.

Learn about the paginator on [Zend Framework Paginator documentation](http://framework.zend.com/manual/en/zend.paginator.usage.html).

## DoctrineMongoDBAdapter

    use Zend\Paginator\Paginator;
    use Zend\Paginator\Adapter\DoctrineMongoDBAdapter;

    $query      = $repository->createQuery();           // create a Doctrine MongoDB Query
    $adapter    = new DoctrineMongoDBAdapter($query);   // create a Doctrine MongoDB Adapter
    $paginator  = new Paginator($adapter);              // create a Paginator

## DoctrineORMAdapter

    use Zend\Paginator\Paginator;
    use Zend\Paginator\Adapter\DoctrineORMAdapter;

    $query      = $repository->createQuery();           // create a Doctrine ORM Query
    $adapter    = new DoctrineORMAdapter($query);       // create a Doctrine ORM Adapter
    $paginator  = new Paginator($adapter);              // create a Paginator
