<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Operations\GetOperationsDto;
use App\Http\Requests\Operations\IndexRequest;
use App\Http\Resources\OperationCollection;
use App\Services\OperationService;
use Illuminate\Http\Response;

class OperationController extends Controller
{
    public function __construct(
        private readonly OperationService $operationService
    )
    {
    }

    /**
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $getOperationsDto = GetOperationsDto::from($request->validated());
        $getOperationsDto->user_id = auth()->user()->id;

        $operations = $this->operationService->getUserOperations($getOperationsDto);

        return response([
            'balance' => auth()->user()->balance->balance,
            'operations' => new OperationCollection($operations)
        ]);
    }
}
