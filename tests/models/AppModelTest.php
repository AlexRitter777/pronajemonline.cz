<?php

use app\models\AppModel;
use PHPUnit\Framework\TestCase;

/**
 * Test class for AppModel.
 *
 * This class contains tests for the load method of the AppModel class. It verifies that
 * the method correctly loads valid data, rejects invalid attributes, and handles empty
 * or incorrect data types appropriately.
 */
class AppModelTest extends TestCase
{

    /**
     * Tests successful data loading.
     *
     * Ensures that valid data passed to the load method correctly populates model attributes.
     */
    public function testDataLoadSuccess(){

        $data = [
            'userName' => 'Test',
            'userEmail' => 'test@test.com',
            'userPassword' => 'Password',
            'userPasswordRepeat' => 'Password',

        ];

        $appModel = new AppModel();
        $appModel->load($data);

        $this->assertEquals('Test', $appModel->getAttributeValue('userName'));
        $this->assertEquals('test@test.com', $appModel->getAttributeValue('userEmail'));
        $this->assertEquals('Password', $appModel->getAttributeValue('userPassword'));
        $this->assertEquals('Password', $appModel->getAttributeValue('userPasswordRepeat'));

    }

    /**
     * Tests exception throwing for invalid attribute.
     *
     * Verifies that the load method throws an exception when data contains an attribute
     * not defined in the model's attributes array.
     */
    public function testDataLoadThrowsExceptionForInvalidAttribute() {

        $data = ['invalidAttribute' => 'value'];

        $model = new AppModel();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Not allowed attributes given');

        $model->load($data);
    }


    /**
     * Tests exception throwing for empty data.
     *
     * Ensures that the load method throws an exception when an empty array is passed,
     * indicating no data was provided for loading.
     */
    public function testDataLoadThrowsExceptionForEmptyData() {

        $data = [];
        $model = new AppModel();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No attributes given');

        $model->load($data);
    }

    /**
     * Tests method's type handling by providing invalid data type.
     *
     * Ensures that the load method throws a TypeError when the provided data is not an array.
     */
    public function testLoadShouldThrowExceptionOnInvalidType()
    {
        $this->expectException(\TypeError::class); // >PHP7

        $model = new AppModel();
        $invalidData = 'not an array'; // wrong data type
        $model->load($invalidData);
    }

}