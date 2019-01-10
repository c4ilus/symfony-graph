<?php

namespace App\GraphQL\Mutation;

use App\Entity\Band;
use App\Entity\Style;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BandMutation extends AbstractController implements MutationInterface, AliasedInterface
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
    public function addBand(array $argument): array
    {
        $entityManager = $this->getDoctrine()->getManager();

        $band = new Band();
        $band->setName($argument['name']);
        $band->setCountry($argument['country']);

        if (!empty($argument['styles'])) {
            foreach ($argument['styles'] as $style_id) {
                $style = $entityManager->getRepository(Style::class)->find($style_id);
                $band->addStyle($style);
            }
        }

        $this->em->persist($band);
        $this->em->flush();

        return [
            'id' => $band->getId()
        ];
    }

    /**
     * @param array $argument
     * @return array
     */
    public function updateBand(array $argument): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $band = $entityManager->getRepository(Band::class)->find($argument['id']);

        if (!$band) {
            throw $this->createNotFoundException(
                'No music band found for id '. $argument['id']
            );
        } else {
            if (!empty($argument['name'])) {
                $band->setName($argument['name']);
            }
            if (!empty($argument['country'])) {
                $band->setCountry($argument['country']);
            }

            if (!empty($argument['styles'])) {
                $band->resetStyles();
                foreach ($argument['styles'] as $style_id) {
                    $style = $entityManager->getRepository(Style::class)->find($style_id);
                    $band->addStyle($style);
                }
            }

            $entityManager->flush();
        }

        return [
            'id' => $band->getId()
        ];
    }

    /**
     * @param array $argument
     * @return array
     */
    public function deleteBand(array $argument): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $band = $entityManager->getRepository(Band::class)->find($argument['id']);

        if (!$band) {
            throw $this->createNotFoundException(
                'No music band found for id '. $argument['id']
            );
        } else {
            $entityManager->remove($band);
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
            'AddBand' => 'add_band',
            'UpdateBand' => 'update_band',
            'DeleteBand' => 'delete_band'
        ];
    }
}
