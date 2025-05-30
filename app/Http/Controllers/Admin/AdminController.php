<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accident;
use App\Models\Admin;
use App\Models\MedicalCenter;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin dashboard with statistics
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_centers' => MedicalCenter::count(),
            'active_centers' => MedicalCenter::where('status', 'active')->count(),
            'pending_accidents' => Accident::where('status', 'pending')->count(),
            'resolved_accidents' => Accident::where('status', 'resolved')->count(),
        ];

        $recentAccidents = Accident::with(['user', 'vehicle', 'medicalCenter'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAccidents'));
    }

    /**
     * List all admin users
     */
    public function index()
    {
        $admins = Admin::where('id', '!=', auth('admin')->id())->get();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show form to create new admin
     */
    public function create()
    {
        $admins = Admin::where('id', '!=', auth('admin')->id())->get();

        return view('admin.admins.create')->with(['admins'=>$admins]);
    }

    /**
     * Store new admin user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:super_admin,admin',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully');
    }

    /**
     * Manage medical centers (approve/disable)
     */
    public function manageMedicalCenters()
    {
        $centers = MedicalCenter::latest()->paginate(10);
        return view('admin.medical-centers.index', compact('centers'));
    }

    /**
     * Update medical center status
     */
    public function updateMedicalCenterStatus(MedicalCenter $center, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $center->update(['status' => $request->status]);

        return back()->with('success', 'Medical center status updated');
    }

    /**
     * Manage regular users
     */
    public function manageUsers()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Update user status
     */
    public function updateUserStatus(User $user, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user->update(['status' => $request->status]);

        return back()->with('success', 'User status updated');
    }

    /**
     * Show admin profile
     */
    public function profile()
    {
        return view('admin.profile', ['admin' => auth('admin')->user()]);
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,'.$admin->id,
            'current_password' => ['required', function ($attribute, $value, $fail) use ($admin) {
                if (!Hash::check($value, $admin->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        $admin->update($data);

        return back()->with('success', 'Profile updated successfully');
    }
}