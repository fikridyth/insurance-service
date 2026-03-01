<?php

namespace App\Interfaces\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Claim\UseCases\CreateClaimUseCase;
use App\Application\Claim\UseCases\VerifyClaimUseCase;
use App\Application\Claim\UseCases\ApproveClaimUseCase;
use App\Application\Claim\UseCases\GetAllClaimsByUserIdUseCase;
use App\Application\Claim\UseCases\GetAllClaimsUseCase;
use App\Application\Claim\UseCases\RejectClaimUseCase;

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
        $user = $request->user();
        if ($user->role === 'user') {
            $claims = $this->getAllByUserIdUseCase->execute($user->id);
        } else {
            $claims = $this->getAllUseCase->execute();
        }

        return response()->json([
            "success" => true,
            "data" => $claims
        ]);
    }

    public function store(Request $request)
    {
        $claim = $this->createUseCase->execute([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return response()->json($claim);
    }

    public function verify($id)
    {
        $claim = $this->verifyUseCase->execute($id, auth()->id());

        return response()->json($claim);
    }

    public function approve($id)
    {
        $claim = $this->approveUseCase->execute($id, auth()->id());

        return response()->json($claim);
    }

    public function reject(Request $request, $id)
    {
        $claim = $this->rejectUseCase->execute($id, auth()->id(), $request->reason);

        return response()->json($claim);
    }
}