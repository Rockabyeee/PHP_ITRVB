<?php

namespace my\Container;

use Faker\Container\ContainerInterface;
use my\Exceptions\ContainerNotFoundException;
use ReflectionClass;

class DIContainer implements ContainerInterface
{

    private array $resolves = [];

    public function has(string $type): bool
    {
        try {
            $this->get($type);
        } catch (ContainerNotFoundException) {
            return false;
        }

        return true;
    }

    public function bind(string $type, $class)
    {
        $this->resolves[$type] = $class;
    }

    public function get(string $type): object
    {
        if (array_key_exists($type, $this->resolves)) {
            $typeToCreate = $this->resolves[$type];

            if (is_object($typeToCreate)) {
                return $typeToCreate;
            }

            return $this->get($typeToCreate);
        }

        if (!class_exists($type)) {
            throw new ContainerNotFoundException("Cannot resolve type: $type");
        }

        $reflectionClass = new ReflectionClass($type);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return new $type();
        }

        $parameters = [];

        foreach ($constructor->getParameters() as $parameter) {
            $parameterType = $parameter->getType()->getName();

            $parameters[] = $this->get($parameterType);
        }

        return new $type(...$parameters);
    }
}