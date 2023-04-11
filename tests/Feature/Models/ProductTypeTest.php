<?php

use App\Models\ProductType;

it('can create a product type using the factory', function () {
    $productType = ProductType::factory()->create();

    $this->assertDatabaseHas('product_types', [
        'id' => $productType->id,
        'name' => $productType->name,
        'tax_percentage' => $productType->tax_percentage,
    ]);
});

it('can retrieve a product type', function () {
    $productType = ProductType::factory()->create();

    $foundProductType = ProductType::find($productType->id);

    $this->assertEquals($productType->id, $foundProductType->id);
    $this->assertEquals($productType->name, $foundProductType->name);
    $this->assertEquals($productType->tax_percentage, $foundProductType->tax_percentage);
});

it('can update a product type', function () {
    $productType = ProductType::factory()->create();

    $updatedData = [
        'name' => 'Updated Product Type',
        'tax_percentage' => 25.00,
    ];

    $productType->update($updatedData);

    $this->assertDatabaseHas('product_types', $updatedData);
});

it('can soft delete a product type', function () {
    $productType = ProductType::factory()->create();

    $productType->delete();

    $this->assertSoftDeleted('product_types', [
        'id' => $productType->id,
        'name' => $productType->name,
        'tax_percentage' => $productType->tax_percentage,
    ]);
});

it('can list all product types', function () {
    $productTypes = ProductType::factory()->count(5)->create();

    $allProductTypes = ProductType::all();

    $this->assertCount(5, $allProductTypes);

    $productTypes->each(function ($productType) use ($allProductTypes) {
        $this->assertTrue($allProductTypes->contains($productType));
    });
});
