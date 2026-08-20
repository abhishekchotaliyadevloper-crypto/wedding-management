<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Resources\InquiryResource;
use App\Services\InquiryService;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct(
        private InquiryService $service
    ) {}

    public function index(Request $request)
    {
        $inquiries = $this->service->getAllInquiries(
            $request->only('search', 'page', 'per_page')
        );

        return InquiryResource::collection($inquiries);
    }

    public function store(StoreInquiryRequest $request)
    {
        $inquiry = $this->service->createInquiry($request->validated());

        return (new InquiryResource($inquiry))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id)
    {
        return new InquiryResource($this->service->getInquiryById($id));
    }

    public function destroy(int $id)
    {
        $this->service->deleteInquiry($id);

        return response()->json(['message' => 'Inquiry deleted successfully.']);
    }
}
