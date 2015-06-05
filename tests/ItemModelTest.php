<?php

class ItemModelTest extends TestCase
{
    public function testExistsIsTrue()
    {
        $itemId     = 501; // Use real item ID.

        // Instantiate model.
        $model      = new CrewkieApi\Model\Game\Item;

        $this->assertTrue($model->exists((int) $itemId));
    }

    public function testExistsIsFalse()
    {
        // There will never be an Item ID of 0.
        $itemId     = 0;

        // Instantiate model.
        $model      = new CrewkieApi\Model\Game\Item;

        // Instantiate model.
        $this->assertFalse($model->exists($itemId));
    }
}