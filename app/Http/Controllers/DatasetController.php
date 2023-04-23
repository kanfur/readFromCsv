<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsvImport;
use App\Models\Dataset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DatasetController extends Controller
{
    public function importCsv(Request $request)
    {
        set_time_limit(300);

        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|max:20400|mimetypes:text/plain,text/csv,application/csv,application/octet-stream,application/vnd.ms-excel',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        // Get the uploaded file
        $uploadedFile = $request->file('csv_file');
        $csvFileName = time() . '_' . $uploadedFile->getClientOriginalName();
        $csvFilePath = $uploadedFile->storeAs('csv', $csvFileName);

        // Dispatch a job to process the CSV import
        ProcessCsvImport::dispatch($csvFilePath);

        return redirect()->back()->with([
            'status' => 200,
            'message' => 'CSV file import has been queued for processing',
        ]);
    }

    public function showDataset(Request $request)
    {
        $query = Dataset::query();

        // Category filter
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category', $category);
        }
        $selectedCategory = $request->input('category');

        // Gender filter
        if ($request->filled('gender')) {
            $gender = $request->input('gender');
            $query->where('gender', $gender);
        }
        $selectedGender = $request->input('gender');

        // Date of Birth filter
        if ($request->filled('birthDate')) {
            $dob = Carbon::parse($request->input('birthDate'));
            $query->where('birthDate', $dob->format('Y-m-d'));
        }
        $selectedDob = $request->input('birthDate');

        // Age filter
        if ($request->filled('age')) {
            $age = $request->input('age');
            $query->whereRaw("strftime('%Y', 'now') - strftime('%Y', birthDate) = $age");
        }
        $selectedAge = $request->input('age');

        // Age range filter
        $ageRanges = ['0-10', '11-20', '21-30', '31-40', '41-50', '51-60', '61-70', '71-80', '81-90', '91-100'];
        if ($request->filled('ageRange')) {
            $ageRange = explode('-', $request->input('ageRange'));
            $minAge = $ageRange[0];
            $maxAge = $ageRange[1];

            $query->whereRaw("strftime('%Y', 'now') - strftime('%Y', birthDate) BETWEEN $minAge AND $maxAge");
        }
        $selectedAgeRange = $request->input('ageRange');
        $data = $query->paginate(15);

        return view('dataset', [
            'data' => $data,
            'categories' => Dataset::groupBy('category')->select('category')->get(),
            'ageRanges' => $ageRanges,
            'selectedCategory' => $selectedCategory,
            'selectedGender' => $selectedGender,
            'selectedDob' => $selectedDob,
            'selectedAge' => $selectedAge,
            'selectedAgeRange' => $selectedAgeRange,
        ]);
    }

}
