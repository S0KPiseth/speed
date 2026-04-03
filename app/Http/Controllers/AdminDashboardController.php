<?php

namespace App\Http\Controllers;

use App\Models\IDVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController
{
    public function index(Request $request)
    {
        $pendingRequests = IDVerificationRequest::query()
            ->join('users', 'users.id', '=', 'id_verification_request.user_id')
            ->select([
                'id_verification_request.id',
                'id_verification_request.user_id',
                'id_verification_request.status',
                'id_verification_request.id_front_url',
                'id_verification_request.id_back_url',
                'id_verification_request.created_at',
                'users.username',
                'users.email',
            ])
            ->where('id_verification_request.status', 'pending')
            ->orderByDesc('id_verification_request.created_at')
            ->get();

        return view('pages.admin.dashboard', [
            'user' => $request->user(),
            'pendingRequests' => $pendingRequests,
        ]);
    }

    public function approve(Request $request, int $requestId): RedirectResponse
    {
        $admin = $request->user();

        $verificationRequest = IDVerificationRequest::query()->find($requestId);

        if (! $verificationRequest) {
            return back()->withErrors('ID verification request not found.');
        }

        if ($verificationRequest->status !== 'pending') {
            return back()->withErrors('This request is already processed.');
        }

        DB::transaction(function () use ($verificationRequest, $admin) {
            $verificationRequest->update([
                'status' => 'approved',
                'admin_id' => $admin->id,
                'rejection_reason' => null,
            ]);
        });

        return back()->with('success', 'ID request has been approved.');
    }

    public function reject(Request $request, int $requestId): RedirectResponse
    {
        $admin = $request->user();

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'rejection_reason.required' => 'Please provide a reason before rejecting.',
            'rejection_reason.min' => 'Rejection reason must be at least 5 characters.',
        ]);

        $verificationRequest = IDVerificationRequest::query()->find($requestId);

        if (! $verificationRequest) {
            return back()->withErrors('ID verification request not found.');
        }

        if ($verificationRequest->status !== 'pending') {
            return back()->withErrors('This request is already processed.');
        }

        $verificationRequest->update([
            'status' => 'rejected',
            'admin_id' => $admin->id,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'ID request has been rejected.');
    }
}
