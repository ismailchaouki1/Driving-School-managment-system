<?php

namespace App\Http\Controllers\Api;

use App\Exports\VehiclesExport;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $vehicles = Vehicle::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $vehicles,
                'message' => 'Vehicles retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load vehicles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
                'plate' => 'required|string|unique:vehicles',
                'vin' => 'nullable|string|unique:vehicles',
                'category' => 'required|string|in:B,A,A1,C,D,BE',
                'fuel' => 'required|string|in:Gasoline,Diesel,Electric,Hybrid,LPG',
                'transmission' => 'required|string|in:Manual,Automatic',
                'color' => 'nullable|string',
                'status' => 'required|in:Active,Maintenance,Inactive,Out of Service',
                'mileage' => 'nullable|integer|min:0',
                'last_maintenance' => 'nullable|date',
                'next_maintenance' => 'nullable|date|after:last_maintenance',
                'insurance_expiry' => 'nullable|date',
                'insurance_provider' => 'nullable|string|max:255',
                'insurance_policy' => 'nullable|string|max:255',
                'technical_inspection' => 'nullable|date',
                'registration_expiry' => 'nullable|date',
                'assigned_instructor' => 'nullable|string|max:255',
                'purchase_price' => 'nullable|numeric|min:0',
                'current_value' => 'nullable|numeric|min:0',
                'fuel_efficiency' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            $vehicle = Vehicle::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle created successfully',
                'data' => $vehicle
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create vehicle: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            $validated = $request->validate([
                'brand' => 'sometimes|string|max:255',
                'model' => 'sometimes|string|max:255',
                'year' => 'sometimes|integer|min:1990|max:' . (date('Y') + 1),
                'plate' => ['sometimes', 'string', Rule::unique('vehicles')->ignore($id)],
                'vin' => ['nullable', 'string', Rule::unique('vehicles')->ignore($id)],
                'category' => 'sometimes|string|in:B,A,A1,C,D,BE',
                'fuel' => 'sometimes|string|in:Gasoline,Diesel,Electric,Hybrid,LPG',
                'transmission' => 'sometimes|string|in:Manual,Automatic',
                'color' => 'nullable|string',
                'status' => 'sometimes|in:Active,Maintenance,Inactive,Out of Service',
                'mileage' => 'nullable|integer|min:0',
                'last_maintenance' => 'nullable|date',
                'next_maintenance' => 'nullable|date',
                'insurance_expiry' => 'nullable|date',
                'insurance_provider' => 'nullable|string|max:255',
                'insurance_policy' => 'nullable|string|max:255',
                'technical_inspection' => 'nullable|date',
                'registration_expiry' => 'nullable|date',
                'assigned_instructor' => 'nullable|string|max:255',
                'purchase_price' => 'nullable|numeric|min:0',
                'current_value' => 'nullable|numeric|min:0',
                'fuel_efficiency' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            $vehicle->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle updated successfully',
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update vehicle: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();

            return response()->json([
                'success' => true,
                'message' => 'Vehicle deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete vehicle: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add maintenance record to vehicle
     */
    public function addMaintenance(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            $validated = $request->validate([
                'date' => 'required|date',
                'type' => 'required|string',
                'mileage' => 'required|integer|min:0',
                'cost' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            $maintenanceHistory = $vehicle->maintenance_history ?? [];
            $newRecord = [
                'id' => time(),
                'date' => $validated['date'],
                'type' => $validated['type'],
                'mileage' => $validated['mileage'],
                'cost' => $validated['cost'] ?? 0,
                'notes' => $validated['notes'] ?? '',
            ];

            $maintenanceHistory[] = $newRecord;
            $vehicle->maintenance_history = $maintenanceHistory;
            $vehicle->last_maintenance = $validated['date'];
            $vehicle->save();

            return response()->json([
                'success' => true,
                'message' => 'Maintenance record added successfully',
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add maintenance record: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add document to vehicle
     */
    public function addDocument(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string',
                'type' => 'required|string',
                'expiry_date' => 'nullable|date',
                'file_name' => 'nullable|string',
            ]);

            $documents = $vehicle->documents ?? [];
            $newDocument = [
                'id' => time(),
                'name' => $validated['name'],
                'type' => $validated['type'],
                'expiry_date' => $validated['expiry_date'] ?? null,
                'upload_date' => now()->toDateString(),
                'file_name' => $validated['file_name'] ?? 'document.pdf',
            ];

            $documents[] = $newDocument;
            $vehicle->documents = $documents;
            $vehicle->save();

            return response()->json([
                'success' => true,
                'message' => 'Document added successfully',
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add incident report to vehicle
     */
    public function addIncident(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            $validated = $request->validate([
                'date' => 'required|date',
                'type' => 'required|string',
                'description' => 'required|string',
                'cost' => 'nullable|numeric|min:0',
                'reported_by' => 'nullable|string',
                'resolved' => 'boolean',
            ]);

            $incidents = $vehicle->incidents ?? [];
            $newIncident = [
                'id' => time(),
                'date' => $validated['date'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'cost' => $validated['cost'] ?? 0,
                'reported_by' => $validated['reported_by'] ?? 'System',
                'resolved' => $validated['resolved'] ?? false,
            ];

            $incidents[] = $newIncident;
            $vehicle->incidents = $incidents;
            $vehicle->save();

            return response()->json([
                'success' => true,
                'message' => 'Incident reported successfully',
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to report incident: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Export vehicles to Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $query = Vehicle::query();

            // Apply filters
            if ($request->has('category') && $request->category !== 'All') {
                $query->where('category', $request->category);
            }

            if ($request->has('status') && $request->status !== 'All') {
                $query->where('status', $request->status);
            }

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('plate', 'like', "%{$search}%")
                      ->orWhere('vin', 'like', "%{$search}%")
                      ->orWhere('assigned_instructor', 'like', "%{$search}%");
                });
            }

            $vehicles = $query->orderBy('created_at', 'desc')->get();

            $export = new VehiclesExport($vehicles);
            $filename = 'vehicles_' . date('Y-m-d_His') . '.xlsx';

            return Excel::download($export, $filename);
        } catch (\Exception $e) {
            Log::error('Excel export failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export vehicles to CSV
     */
    public function exportCsv(Request $request)
    {
        try {
            $query = Vehicle::query();

            // Apply filters
            if ($request->has('category') && $request->category !== 'All') {
                $query->where('category', $request->category);
            }

            if ($request->has('status') && $request->status !== 'All') {
                $query->where('status', $request->status);
            }

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('plate', 'like', "%{$search}%")
                      ->orWhere('vin', 'like', "%{$search}%")
                      ->orWhere('assigned_instructor', 'like', "%{$search}%");
                });
            }

            $vehicles = $query->orderBy('created_at', 'desc')->get();

            $export = new VehiclesExport($vehicles);
            $filename = 'vehicles_' . date('Y-m-d_His') . '.csv';

            return Excel::download($export, $filename, \Maatwebsite\Excel\Excel::CSV);
        } catch (\Exception $e) {
            Log::error('CSV export failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export vehicles to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $query = Vehicle::query();

            // Apply filters
            if ($request->has('category') && $request->category !== 'All') {
                $query->where('category', $request->category);
            }

            if ($request->has('status') && $request->status !== 'All') {
                $query->where('status', $request->status);
            }

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('plate', 'like', "%{$search}%")
                      ->orWhere('vin', 'like', "%{$search}%")
                      ->orWhere('assigned_instructor', 'like', "%{$search}%");
                });
            }

            $vehicles = $query->orderBy('created_at', 'desc')->get();

            $totalVehicles = $vehicles->count();
            $activeVehicles = $vehicles->where('status', 'Active')->count();
            $maintenanceVehicles = $vehicles->where('status', 'Maintenance')->count();
            $totalValue = $vehicles->sum(function($v) {
                return $v->current_value ?? $v->purchase_price ?? 0;
            });
            $totalMileage = $vehicles->sum('mileage');

            $pdf = Pdf::loadView('exports.vehicles-pdf', [
                'vehicles' => $vehicles,
                'totalVehicles' => $totalVehicles,
                'activeVehicles' => $activeVehicles,
                'maintenanceVehicles' => $maintenanceVehicles,
                'totalValue' => $totalValue,
                'totalMileage' => $totalMileage,
                'exportDate' => now()->format('Y-m-d H:i:s')
            ]);

            $pdf->setPaper('A4', 'landscape');

            return $pdf->download('vehicles_' . date('Y-m-d_His') . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF export failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export single vehicle details to PDF
     */
    public function exportVehiclePdf($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            $pdf = Pdf::loadView('exports.vehicle-detail-pdf', ['vehicle' => $vehicle]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->download('vehicle_' . $vehicle->plate . '_' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            Log::error('Vehicle PDF export failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
