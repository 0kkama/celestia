<?php

namespace App\Admin\User;


use App\Model\User;
use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;
use Creonit\AdminBundle\Component\Scope\Scope;
use Creonit\AdminBundle\Component\TableComponent;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserTable extends TableComponent
{
    /**
     * @header
     * {{ button('Добавить', {type: 'success', size: 'sm', icon: 'plus'}) | open('UserEditor') }}
     * {{ button('Группы пользователей', {icon: 'users', size: 'sm'}) | open('UserGroupTable') }}
     *
     * @cols ., Имя пользователя, ФИО, .
     *
     * \User
     *
     * @col {{ id }}
     * @col {{ email | open('UserEditor', {key: _key}) }}
     * @col {{ name }}
     * @col {{ _delete() }}
     */
    public function schema()
    {
    }

    /**
     * @param ComponentRequest $request
     * @param ComponentResponse $response
     * @param ParameterBag $data
     * @param User $entity
     * @param Scope $scope
     * @param \Creonit\AdminBundle\Component\Scope\ListRowScopeRelation|null $relation
     * @param $relationValue
     * @param $level
     */
    protected function decorate(ComponentRequest $request, ComponentResponse $response, ParameterBag $data, $entity, Scope $scope, $relation, $relationValue, $level)
    {
        $data->set('name', implode(' ', array_filter([
            $entity->getLastName(),
            $entity->getFirstName(),
            $entity->getMiddleName()
        ])));
    }


}
