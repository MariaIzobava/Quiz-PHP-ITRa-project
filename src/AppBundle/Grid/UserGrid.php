<?php
namespace AppBundle\Grid;

use Cwd\BootgridBundle\Column\NumberType;
use Cwd\BootgridBundle\Column\TextType;
use Cwd\BootgridBundle\Grid\AbstractGrid;
use Cwd\BootgridBundle\Grid\GridBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserGrid extends AbstractGrid
{
    /**
     * @param GridBuilderInterface $builder
     * @param array                $options
     */
    public function buildGrid(GridBuilderInterface $builder, array $options)
    {
        $builder->add(new NumberType('id', 'u.id', ['label' => 'ID', 'identifier' => true]))
                ->add(new TextType('firstname', 'u.firstname', ['label' => 'Firstname']))
                ->add(new TextType('lastname', 'u.lastname', ['label' => 'Lastname']))
                ->add(new TextType('email', 'u.email', ['label' => 'Email']));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'default_sorts' => array('u.id' => false),
            'data_route' => 'app_user_ajaxdata',
        ));
    }


    /**
     * @param ObjectManager $objectManager
     * @param array         $params
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder(ObjectManager $objectManager, array $params = [])
    {
        $qb = $objectManager
            ->getRepository('AppBundle\Model\User')
            ->createQueryBuilder('u')
            ->orderBy('u.lastname', 'ASC');

        return $qb;
    }
}