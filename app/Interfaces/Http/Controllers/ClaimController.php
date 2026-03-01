<?php

namespace App\Interfaces\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Claim\UseCases\CreateClaimUseCase;
use App\Application\Claim\UseCases\VerifyClaimUseCase;
use App\Application\Claim\UseCases\ApproveClaimUseCase;
use App\Application\Claim\UseCases\GetAllClaimsByUserIdUseCase;
use App\Application\Claim\UseCases\GetAllClaimsUseCase;
use App\Application\Claim\UseCases\RejectClaimUseCase;
use App\Shared\Responses\ActionResult;
use App\Shared\Responses\Response;
use Illuminate\Validation\ValidationException;

class ClaimController
{
    public function __construct(
        private GetAllClaimsUseCase $getAllUseCase,
        private GetAllClaimsByUserIdUseCase $getAllByUserIdUseCase,
        private CreateClaimUseCase $createUseCase,
        private VerifyClaimUseCase $verifyUseCase,
        private ApproveClaimUseCase $approveUseCase,
        private RejectClaimUseCase $rejectUseCase,
    ) {}

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $page = (int) $request->query("page", 1);
            $limit = 10;
            if ($user->role === 'user') {
                $result = $this->getAllByUserIdUseCase->execute($user->id, $page, $limit);
            } else {
                $result = $this->getAllUseCase->execute($page, $limit);
            }

            return response()->json(
                Response::successRecords(
                    "Get Data success",
                    $result->getRecords(),
                    200,
                    $result->getPagination()
                ),
                200
            );
        } catch (\Exception $e) {
    
            return response()->json(
                Response::error(
                    $e->getMessage(),
                    400
                ),
                400
            );
    
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'amount' => 'required|numeric|min:0'
            ]);
    
            $this->createUseCase->execute([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
            ]);
    
            return response()->json(
                ActionResult::success(
                    "Success",
                    "Data Claim Created Successfully"
                )->toArray(),
                201
            );
        } catch (ValidationException $e) {
            return response()->json(
                ActionResult::error(
                    "Failed",
                    $e->getMessage()
                )->toArray(),
                422
            );
        } catch (\Throwable $e) {
            return response()->json(
                ActionResult::exception($e)->toArray(),
                400
            );
        }
    }

    public function verify($id)
    {
        try {
            $this->verifyUseCase->execute($id, auth()->id());
    
            return response()->json(
                ActionResult::success(
                    "Success",
                    "Verify Claim Successfully"
                )->toArray(),
                201
            );
        } catch (\Throwable $e) {
            return response()->json(
                ActionResult::exception($e)->toArray(),
                400
            );
        }
    }

    public function approve($id)
    {
        try {
            $this->approveUseCase->execute($id, auth()->id());
    
            return response()->json(
                ActionResult::success(
                    "Success",
                    "Approve Claim Successfully"
                )->toArray(),
                201
            );
        } catch (\Throwable $e) {
            return response()->json(
                ActionResult::exception($e)->toArray(),
                400
            );
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'reason' => 'required|string|max:500'
            ]);
    
            $this->rejectUseCase->execute(
                $id,
                auth()->id(),
                $request->reason
            );
    
            return response()->json(
                ActionResult::success(
                    "Success",
                    "Reject Claim Successfully"
                )->toArray(),
                201
            );
        } catch (\Throwable $e) {
            return response()->json(
                ActionResult::exception($e)->toArray(),
                400
            );
        }
    }
}