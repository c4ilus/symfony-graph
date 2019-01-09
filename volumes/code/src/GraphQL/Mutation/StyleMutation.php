<?php

namespace App\GraphQL\Mutation;

use App\Entity\Style;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StyleMutation extends AbstractController implements MutationInterface, AliasedInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $argument
     * @return array
     */
    public function addStyle(array $argument): array
    {
        $style = new Style();
        $style->setName($argument['name']);

        $this->em->persist($style);
        $this->em->flush();

        return [
            'id' => $style->getId()
        ];
    }

    /**
     * @param array $argument
     * @return array
     */
    public function updateStyle(array $argument): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $style = $entityManager->getRepository(Style::class)->find($argument['id']);

        if (!$style) {
            throw $this->createNotFoundException(
                'No music style found for id '. $argument['id']
            );
        } else {
            $style->setName($argument['name']);
            $entityManager->flush();
        }

        return [
            'id' => $style->getId()
        ];
    }

    /**
     * @param array $argument
     * @return array
     */
    public function deleteStyle(array $argument): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $style = $entityManager->getRepository(Style::class)->find($argument['id']);

        if (!$style) {
            throw $this->createNotFoundException(
                'No music style found for id '. $argument['id']
            );
        } else {
            $entityManager->remove($style);
            $entityManager->flush();
        }

        return [
            'id' => $argument['id']
        ];
    }

    /**
     * Returns methods aliases.
     *
     * For instance:
     * array('myMethod' => 'myAlias')
     *
     * @return array
     */
    public static function getAliases(): array
    {
        return [
            'AddStyle' => 'add_style',
            'UpdateStyle' => 'update_style',
            'DeleteStyle' => 'delete_style',
        ];
    }
}
