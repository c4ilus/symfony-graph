<?php

namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class StyleResolver implements ResolverInterface, AliasedInterface {

  private $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function resolve(Argument $args)
  {
    $style = $this->em->getRepository('App:Style')->find($args['id']);
    return $style;
  }

  /**
   * {@inheritdoc}
   */
  public static function getAliases()
  {
    return [
      'resolve' => 'Style'
    ];
  }
}
