<?php

namespace models;

use app\db_models\ModelTest;
use app\db_models\Users;
use PHPUnit\Framework\TestCase;

class ModelTestTest extends TestCase
{
    /**
     * Tests the inferTableName method for different model classes.
     */
    public function testInferTableName(){

        // Test for the ModelTest class
        $modelTest = new ModelTest();
        $this->assertEquals('model_test', $this->invokeMethod($modelTest, 'inferTableName'));

        // Test for the Users class
        $users = new Users();
        $this->assertEquals('users', $this->invokeMethod($users, 'inferTableName'));

    }

    /**
     * Invokes a private or protected method on a given object.
     *
     * @param object $object The object instance on which the method should be called.
     * @param string $methodName The name of the method to invoke.
     * @param array $parameters An array of parameters to pass to the method.
     * @return mixed The result of the invoked method.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);

        // Make the method accessible (bypassing visibility modifiers)
        $method->setAccessible(true);

        // Invoke the method with the provided parameters and return the result
        return $method->invokeArgs($object, $parameters);
    }

}