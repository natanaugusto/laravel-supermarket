<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::all();
        return response()->json($productTypes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'tax_percentage' => 'required|numeric',
        ]);

        $productType = ProductType::create($request->all());

        return response()->json(
            ['message' => 'Product type created successfully.', 'data' => $productType],
            SymfonyResponse::HTTP_CREATED
        );
    }

    public function show(ProductType $productType)
    {
        return response()->json($productType);
    }

    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'name' => 'required',
            'tax_percentage' => 'required|numeric',
        ]);

        $productType->update($request->all());

        return response()->json(
            ['message' => 'Product type updated successfully.', 'data' => $productType],
            SymfonyResponse::HTTP_ACCEPTED
        );
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return response()->json(['message' => 'Product type deleted successfully.'], SymfonyResponse::HTTP_ACCEPTED);
    }
}
