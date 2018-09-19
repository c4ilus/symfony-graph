<?php

namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class StylesListResolver implements ResolverInterface, AliasedInterface
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'StylesList'
        ];
    }

    public function resolve(Argument $args)
    {
        $styles = $this->em->getRepository('App:Style')->findBy(
            [],
            ['id' => 'desc'],
            $args['limit'],
            0
        );

        return ['styles' => $styles];
    }
}
