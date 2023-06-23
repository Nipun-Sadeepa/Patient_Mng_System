<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Prescription;
use Dotenv\Store\File\Paths;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

    public function index(){
        // Get all patients
        $result=Patient::paginate(5);
        if(isset($result[0])){
            return view("dashboard")->with("allPatient",$result);
        }
        else{
            return view("dashboard")->with("errorPatientIndex","error"); 
        }
       
    }

    public function show(string $id){
        // Get details, past prescriptions regarding to specific patient

        // $patientDetails = Patient::join("prescriptions","patients.id","prescriptions.patientId")
        // ->select('patients.*', 'prescriptions.*', DB::raw('DATE(prescriptions.created_at) AS dateOnly'))
        // ->latest('prescriptions.created_at')->paginate(20);

        $patientDetails=Patient::where('id',$id)->first();
        $patientHistory=Prescription::select('prescriptions.*',DB::raw('DATE(created_at) AS dateOnly'))
        ->where('patientId',$id)->latest()->get();
        
        if(isset($patientDetails) && isset($patientHistory[0])){
            return view("patient.viewPatient")->with("patientDetails",$patientDetails)->with("patientHistory",$patientHistory);
        }
        else if(isset($patientDetails) && empty($patientHistory[0])){
            return view("patient.viewPatient")->with("patientDetails",$patientDetails)->with("errorPatientHistory","error"); 
        }else{
            return view("patient.viewPatient")->with("errorPatientShow","error"); 
        }
    }

    public function create(){
        return view('patient.addPatient');
    }

    public function store(Request $request){
        // Store a patient
        $rules=[
            "name"=>"required|string|max:255",
            "bday"=>"required|date",
            "contactNo"=>"required|string|size:10",
            "nic"=>"required|string|between:10,13",
            "image"=>"required|image",
            "notes"=>"required|string",
        ];
        $validator=Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(["msg"=>"ValidationFailed","errors" => $validator->errors()], 422);
        }
        else{
            $validated = $validator->validated();
            $imagePath= $request->file("image")->store("User_NIC");
            $result= Patient::create([
                "name"=>$validated["name"],
                "bday"=>$validated["bday"],
                "contactNo"=>$validated["contactNo"],
                "nic"=>$validated["nic"],
                "imagePath"=>$imagePath,
                "notes"=>$validated["notes"],
            ]);

            if(isset($result)){
                return response(["msg"=>"success"],200);
            }
            else{
                return response(["msg"=>"failed"],400);
            }
        }
       
    }

    public function search($nic){
        // For search patient according to nic or get matching results
        $result=Patient::where('nic', $nic)->paginate();
        if(isset($result[0])){
            return view("dashboard")->with("allPatient",$result);
        }
        else{
            $nic=preg_replace('/\D/', '', $nic);
            $result=Patient::where('nic', 'Like', '%'.$nic.'%')->get();
            return view("dashboard")->with("allPatient",$result)->with('matchingResults','yes');
        }
    }
   
}
