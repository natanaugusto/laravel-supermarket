<?php

use App\Models\ProductType;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

it('can list product types', function () {
    $productTypes = ProductType::factory()->count(5)->create();

    $response = $this->getJson(route('product-type.index'));

    $response->assertStatus(SymfonyResponse::HTTP_OK);
    $productTypes->each(function ($productType) use ($response) {
        $response->assertJsonFragment([
            'id' => $productType->id,
            'name' => $productType->name,
            'tax_percentage' => $productType->tax_percentage,
        ]);
    });
});

it('can create a product type', function () {
    $payload = [
        'name' => 'Electronics',
        'tax_percentage' => 15.00,
    ];

    $response = $this->postJson(route('product-type.store'), $payload);

    $response->assertStatus(SymfonyResponse::HTTP_CREATED)
        ->assertJson(['message' => 'Product type created successfully.']);

    $this->assertDatabaseHas('product_types', $payload);
});

it('can show a product type', function () {
    $productType = ProductType::factory()->create();

    $response = $this->getJson(route('product-type.show', ['product_type' => $productType->id]));

    $response->assertStatus(SymfonyResponse::HTTP_OK)
        ->assertJson([
            'id' => $productType->id,
            'name' => $productType->name,
            'tax_percentage' => $productType->tax_percentage,
        ]);
});

it('can update a product type', function () {
    $productType = ProductType::factory()->create();
    $payload = [
        'name' => 'Home Appliances',
        'tax_percentage' => 18.00,
    ];

    $response = $this->putJson(route('product-type.update', ['product_type' => $productType->id]), $payload);

    $response->assertStatus(SymfonyResponse::HTTP_ACCEPTED)
        ->assertJson(['message' => 'Product type updated successfully.']);

    $this->assertDatabaseHas('product_types', $payload);
});

it('can soft delete a product type', function () {
    $productType = ProductType::factory()->create();

    $response = $this->deleteJson(route('product-type.destroy', ['product_type' => $productType->id]));

    $response->assertStatus(SymfonyResponse::HTTP_ACCEPTED)
        ->assertJson(['message' => 'Product type deleted successfully.']);

    $this->assertSoftDeleted('product_types', ['id' => $productType->id]);
});
