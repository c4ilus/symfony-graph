<?php

namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class BandResolver implements ResolverInterface, AliasedInterface {

  private $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function resolve(Argument $args)
  {
    $band = $this->em->getRepository('App:Band')->find($args['id']);
    return $band;
  }

  /**
   * {@inheritdoc}
   */
  public static function getAliases()
  {
    return [
      'resolve' => 'Band'
    ];
  }
}
