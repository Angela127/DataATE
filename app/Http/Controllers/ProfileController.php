<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's personal data form.
     */
    public function personalData(Request $request): View
    {
        $user = $request->user();

        $customer = $user->customer;

        if (! $customer) {
            $customer = new Customer([
                'user_id' => $user->id,
            ]);
        }

        return view('profile.personal-data', [
            'user' => $user,
            'customer' => $customer,
        ]);
    }

    /**
     * Update the user's personal data.
     */
    public function updatePersonalData(Request $request): RedirectResponse
    {
        
        $tab = $request->input('tab', 'personal');

        // Validate only fields for the current tab
        $rules = match ($tab) {
            'personal' => [
                'name' => ['nullable', 'string', 'max:255'],
                'username' => ['nullable', 'string', 'max:255'],
                'nationality' => ['nullable', 'string', 'max:255'],
                'gender' => ['nullable', 'string', 'max:50'],
                'matric_staff_no' => ['nullable', 'string', 'max:255'],
                'faculty' => ['nullable', 'string', 'max:255'],
                'residential_college' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string', 'max:500'],
                'phone' => ['nullable', 'string', 'max:20'],
            ],
            'emergency' => [
                'name' => ['sometimes', 'string', 'max:255'],
                'emergency_contact_name' => ['nullable', 'string', 'max:255'],
                'relationship' => ['nullable', 'string', 'max:255'],
                'emergency_phone' => ['nullable', 'string', 'max:20'],
            ],
            'documents' => [
                'name' => ['sometimes', 'string', 'max:255'],
                'ic_passport' => ['nullable', 'string', 'max:255'],
                'license_no' => ['nullable', 'string', 'max:255'],
                'license_expiry' => ['nullable', 'date'],
                'license_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],
            'identity_card_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],
                
            ],
            default => [],
        };

        $validated = $request->validate($rules);

        $user = $request->user();

        // Update basic name on users table (fallback to current name if not provided on non-personal tabs)
        $user->name = $validated['name'] ?? $user->name;
        $user->save();

        // Remove attributes that belong to the user model only
        unset($validated['name']);

        // Create or update customer profile
        $customer = $user->customer ?: new Customer([
            'user_id' => $user->id,
        ]);

         // Handle license image upload
        if ($request->hasFile('license_image')) {
            // Delete old image if exists
            if ($customer->license_image && file_exists(public_path($customer->license_image))) {
                unlink(public_path($customer->license_image));
            }

            $file = $request->file('license_image');
            $filename = 'license_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $directory = public_path('images/driving_licenses');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move file to public/images/driving_licenses
            $file->move($directory, $filename);
            
            // Store relative path in database
            $validated['license_image'] = 'images/driving_licenses/' . $filename;
        }

        // Handle identity card image upload
        if ($request->hasFile('identity_card_image')) {
            // Delete old image if exists
            if ($customer->identity_card_image && file_exists(public_path($customer->identity_card_image))) {
                unlink(public_path($customer->identity_card_image));
            }

            $file = $request->file('identity_card_image');
            $filename = 'identity_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $directory = public_path('images/identity_cards');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move file to public/images/identity_cards
            $file->move($directory, $filename);
            
            // Store relative path in database
            $validated['identity_card_image'] = 'images/identity_cards/' . $filename;
        }

        // Handle student/staff card image upload
        if ($request->hasFile('matric_staff_image')) {
            // Delete old image if exists
            if ($customer->matric_staff_image && file_exists(public_path($customer->matric_staff_image))) {
                unlink(public_path($customer->matric_staff_image));
            }

            $file = $request->file('matric_staff_image');
            $filename = 'matric_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $directory = public_path('images/matric_staff_cards');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move file to public/images/matric_staff_cards
            $file->move($directory, $filename);
            
            // Store relative path in database
            $validated['matric_staff_image'] = 'images/matric_staff_cards/' . $filename;
        }


        $customer->fill($validated);
        $customer->save();

        return Redirect::route('profile.personal-data')->with('status', 'personal-data-updated');
    }

    /**
     * Display the driving license upload form.
     */
    public function drivingLicense(Request $request): View
    {
        return view('driving_license', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Store the user's driving license.
     */
    public function storeDrivingLicense(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'driving_license' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        // Store the file
        if ($request->hasFile('driving_license')) {
            $file = $request->file('driving_license');
            $filename = 'license_' . $request->user()->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('driving_licenses', $filename, 'public');

            // Create or update customer record with license image path
            $user = $request->user();
            $customer = $user->customer ?: new Customer([
                'user_id' => $user->id,
            ]);

            $customer->license_image = $path;
            $customer->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Driving license uploaded successfully. It will be reviewed within 24 hours.',
        ]);
    }
}
