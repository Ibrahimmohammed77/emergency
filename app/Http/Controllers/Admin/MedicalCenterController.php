<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MedicalCenterController extends Controller
{
    /**
     * Display a listing of medical centers.
     */
    public function index()
    {
        $centers = MedicalCenter::latest()->paginate(10);
        return view('admin.medical-centers.index', compact('centers'));
    }

    /**
     * Show the form for creating a new medical center.
     */
    public function create()
    {
        $specializations = ['عام', 'قلب', 'أعصاب', 'عظام', 'أطفال', 'نساء وتوليد'];
        return view('admin.medical-centers.create', compact('specializations'));
    }

    /**
     * Store a newly created medical center.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:medical_centers,email',
            'phone' => 'required|string|max:20|unique:medical_centers,phone',
            'address' => 'required|string',
            'specialization' => 'required|string',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('medical-centers/logos', 'public');
        }

        MedicalCenter::create($data);

        return redirect()->route('admin.medical-centers.index')
            ->with('success', 'تم إضافة المركز الطبي بنجاح');
    }

    /**
     * Display the specified medical center.
     */
    public function show(MedicalCenter $center)
    {
        return view('admin.medical-centers.show', compact('center'));
    }

    /**
     * Show the form for editing the medical center.
     */
    public function edit(MedicalCenter $center)
    {
        $specializations = ['عام', 'قلب', 'أعصاب', 'عظام', 'أطفال', 'نساء وتوليد'];
        return view('admin.medical-centers.edit', compact('center', 'specializations'));
    }

    /**
     * Update the specified medical center.
     */
    public function update(Request $request, MedicalCenter $center)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('medical_centers')->ignore($center->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('medical_centers')->ignore($center->id)],
            'address' => 'required|string',
            'specialization' => 'required|string',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($center->logo) {
                Storage::disk('public')->delete($center->logo);
            }
            $data['logo'] = $request->file('logo')->store('medical-centers/logos', 'public');
        }

        $center->update($data);

        return redirect()->route('admin.medical-centers.index')
            ->with('success', 'تم تحديث بيانات المركز الطبي بنجاح');
    }

    /**
     * Remove the specified medical center.
     */
    public function destroy(MedicalCenter $center)
    {
        if ($center->logo) {
            Storage::disk('public')->delete($center->logo);
        }
        
        $center->delete();
        
        return redirect()->route('admin.medical-centers.index')
            ->with('success', 'تم حذف المركز الطبي بنجاح');
    }

    /**
     * Update the medical center status.
     */
    public function updateStatus(Request $request, MedicalCenter $center)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $center->update(['status' => $request->status]);

        return redirect()->route('admin.medical-centers.index')
            ->with('success', 'تم تحديث حالة المركز الطبي بنجاح');
    }
}