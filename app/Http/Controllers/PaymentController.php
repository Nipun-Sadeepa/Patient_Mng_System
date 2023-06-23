<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Psy\VarDumper\Presenter;

class PaymentController extends Controller
{

    public function index()
    {
        // Get latest payments
        $result = Patient::join("prescriptions", "patients.id", "prescriptions.patientId")
            ->select(DB::raw('DATE(prescriptions.created_at) AS dateOnly'), 'drFee', 'prescriptions.id', 'patientId', 'name')
            ->latest('prescriptions.created_at')->take(100)->paginate(20);

        if (isset($result[0])) {
            return view("payment.payment")->with('paymentSummary', $result);
        } else {
            return view("payment.payment")->with('errorPaymentIndex', 'error');
        }
    }

    public function showReport($date1, $date2)
    {
        // Get payments regarding to time period
        $formattedDate1 = date('Y-m-d', strtotime($date1));
        $formattedDate2 = date('Y-m-d', strtotime($date2));

        $paymentHistory = Patient::join("prescriptions", "patients.id", "prescriptions.patientId")
            ->select(DB::raw('DATE(prescriptions.created_at) AS dateOnly'), 'drFee', 'prescriptions.id', 'patientId', 'name')
            ->whereDate('prescriptions.created_at', '>=', $formattedDate1)->whereDate('prescriptions.created_at', '<=', $formattedDate2)
            ->latest('prescriptions.created_at')->paginate(20);

        $paymentOfGroups = Patient::join("prescriptions", "patients.id", "prescriptions.patientId")
            ->select(DB::raw('SUM(drFee) AS sumFee'), 'patientId', 'name', 'nic')
            ->whereDate('prescriptions.created_at', '>=', $formattedDate1)->whereDate('prescriptions.created_at', '<=', $formattedDate2)
            ->groupBy('patientId', 'name', 'nic')->get();

        $totalPayments = Prescription::select(DB::raw('SUM(drFee) AS totalFee'))
            ->whereDate('prescriptions.created_at', '>=', $formattedDate1)->whereDate('prescriptions.created_at', '<=', $formattedDate2)->get();

        if (isset($paymentHistory[0]) && isset($paymentOfGroups[0])) {
            return view("payment.payment")->with('paymentSummary', $paymentHistory)->with('paymentOfGroups', $paymentOfGroups)
                ->with('totalPayments', $totalPayments);
        } else {
            return view("payment.payment")->with('errorPaymentShowReport', 'error');
        }
    }
}
