<?php


namespace App\Repository;


use Symfony\Component\PropertyAccess\PropertyAccess;

trait RepositoryTool {

    private $propertyAccessor;

    /**
     * Автоматически заполняет свойства объекта данными из массива.
     *
     * @param object $object Объект для заполнения.
     * @param array $data Данные для заполнения свойств объекта.
     */
    public function hydrate(object $object, array $data): void {
        if (!$this->propertyAccessor) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        foreach ($data as $key => $value) {
            if ($this->propertyAccessor->isWritable($object, $key)) {
                $this->propertyAccessor->setValue($object, $key, $value);
            }
        }
    }

}
