<?php

namespace App\Http\Controllers;

use App\Models\IDVerificationRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use ImageKit;

class DocumentVerificationController
{
    public function show(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $idVerification = IDVerificationRequest::query()
            ->where('user_id', $user->id)
            ->first(['status', 'rejection_reason']);

        return view('pages.verify.document', [
            'user' => $user,
            'idVerificationStatus' => $idVerification?->status,
            'idVerificationReason' => $idVerification?->rejection_reason,
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $currentStatus = IDVerificationRequest::query()
            ->where('user_id', $user->id)
            ->value('status');

        if ($currentStatus === 'pending') {
            return back()->withErrors('You have already submitted your ID documents. Please wait for our team to verify them.');
        }

        $validated = $request->validate([
            'id_front' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'id_back' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ], [
            'id_front.required' => 'Please upload the front side of your ID.',
            'id_front.image' => 'Front ID must be a valid image.',
            'id_front.mimes' => 'Front ID must be JPG or PNG.',
            'id_front.max' => 'Front ID image must not exceed 10MB.',
            'id_back.required' => 'Please upload the back side of your ID.',
            'id_back.image' => 'Back ID must be a valid image.',
            'id_back.mimes' => 'Back ID must be JPG or PNG.',
            'id_back.max' => 'Back ID image must not exceed 10MB.',
        ]);

        $imageKit = new ImageKit();
        $frontUpload = null;
        $backUpload = null;

        try {
            $frontUpload = $imageKit->uploadFile($validated['id_front'], 'id_front_' . $user->id);
            $backUpload = $imageKit->uploadFile($validated['id_back'], 'id_back_' . $user->id);

            DB::transaction(function () use ($user, $frontUpload, $backUpload, $imageKit) {
                $existingRequest = IDVerificationRequest::query()->where('user_id', $user->id)->first();

                if ($existingRequest) {
                    if (! empty($existingRequest->id_front_file_id)) {
                        $imageKit->deleteImage($existingRequest->id_front_file_id);
                    }

                    if (! empty($existingRequest->id_back_file_id)) {
                        $imageKit->deleteImage($existingRequest->id_back_file_id);
                    }
                }

                IDVerificationRequest::query()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'status' => 'pending',
                        'id_front_url' => $frontUpload['url'],
                        'id_back_url' => $backUpload['url'],
                        'id_front_file_id' => $frontUpload['fileId'],
                        'id_back_file_id' => $backUpload['fileId'],
                        'rejection_reason' => null,
                        'admin_id' => null,
                    ]
                );
            });

            return back()->with('success', 'Document is uploaded successfully and awaiting admin approval.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            if ($frontUpload && isset($frontUpload['fileId'])) {
                $imageKit->deleteImage($frontUpload['fileId']);
            }

            if ($backUpload && isset($backUpload['fileId'])) {
                $imageKit->deleteImage($backUpload['fileId']);
            }

            return back()->withErrors('Unable to upload ID documents right now. Please try again.');
        }
    }
}
