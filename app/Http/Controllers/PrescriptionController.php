<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class PrescriptionController extends Controller
{

    public function store(Request $request)
    {
        // For store a prescription
        $rules = [
            "prescription" => "required|image",
            "patientId" => "required|numeric",
            "prescriptionNotes" => "nullable|string",
            "drFee" => "required|numeric",
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(["msg" => "ValidationFailed", "errors" => $validator->errors()], 422);
        } else {
            $validated = $validator->validated();
            $prescriptionImagePath = $request->file("prescription")->store("Prescrip");

            $result = Prescription::create([
                "patientId" => $validated["patientId"],
                "prescriptionPath" => $prescriptionImagePath,
                "drFee" => $validated["drFee"],
                "prescriptionNotes" => $validated["prescriptionNotes"],
            ]);
            if (isset($result)) {
                return response(["msg" => "success"], 200);
            } else {
                return response(["msg" => "failed"], 400);
            }
        }
    }
}
