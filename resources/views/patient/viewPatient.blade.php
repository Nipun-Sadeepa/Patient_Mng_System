@extends('./layouts/main')
@section('content')

    <!-- Basic patient details -->
    <h3> Patient Details</h3>
    @isset($errorPatientShow)
        <p class="alert alert-warning">Can't find a patient related to your search</p>
    @endisset
    <div class="border border-dark rounded">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="align-middle text-center" scope="col">Image</th>
                    <th class="align-middle text-center" scope="col">Name</th>
                    <th class="align-middle text-center" scope="col">Birth day</th>
                    <th class="align-middle text-center" scope="col">Contact No</th>
                    <th class="align-middle text-center" scope="col">NIC</th> 
                    <th class="align-middle text-center" scope="col">Notes</th>   
                </tr>
            </thead>
            <tbody>
                @if(isset($patientDetails))
                    <tr id={{$patientDetails->patientId}} >
                        <td class="align-middle text-center"><img style="width:10vw; height:20vh;" src="http://127.0.0.1:8000/{{$patientDetails->imagePath}}"></img></td>
                        <td class="align-middle text-center">{{$patientDetails->name}}</td>
                        <td class="align-middle text-center">{{$patientDetails->bday}}</td>
                        <td class="align-middle text-center">{{$patientDetails->contactNo}}</td>
                        <td class="align-middle text-center">{{$patientDetails->nic}}</td>
                        <td class="align-middle text-center">{{$patientDetails->notes}}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div> 
    <br><br>

    <!-- Form for add prescription and doctor fee -->
    <h3> Add Prescriptions</h3>
    <div class="border border-dark rounded">
        <form name="addPrescriptionForm" id="addPrescriptionForm" onsubmit="addPrescription(event)"> 
            @csrf
            <div class="mb-3">
                <input type="hidden" class="form-control" name="patientId" id="patientId" value="{{$patientDetails->id}}">
            </div>
            <div class="mb-3">
                <label for="prescription" class="form-label">Prescription</label>
                <input type="file" class="form-control" accept="image/*" name="prescription" id="prescription" autofocus required>
            </div>
            <div class="mb-3">
                <label for="drFee" class="form-label">Doctor Fee</label>
                <input type="number" class="form-control" name="drFee" id="drFee" required>
            </div>
            <div class="input-group">
                <span class="input-group-text">Notes</span>
                <textarea class="form-control" aria-label="With textarea" name="prescriptionNotes" id="prescriptionNotes"></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add Prescription</button>
        </form>
        
    </div>
    <br><br>

    <!-- Past prescription details regarding to patient -->
    <h3> Patient Pass History</h3>
    @isset($errorPatientHistory)
        <p class="alert alert-warning">Can't find past prescription records regarding to this patient</p>
    @endisset
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="align-middle text-center" scope="col">Date</th>
                    <th class="align-middle text-center" scope="col">Prescription</th>
                    <th class="align-middle text-center" scope="col">Extra Notes</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($patientHistory[0]))
                    @foreach($patientHistory as $history)
                        <tr id={{$history->id}} >
                            <td class="align-middle text-center">{{$history->dateOnly}}</td>
                            <td class="text-center"><a href="http://127.0.0.1:8000/{{$history->prescriptionPath}}"><img style="width:20vw; height:60vh;" src="http://127.0.0.1:8000/{{$history->prescriptionPath}}"></img></a></td>
                            @if($history->prescriptionNotes == NULL)
                                <td class="align-middle text-center">Not Added</td>   
                            @else
                                <td class="align-middle text-center">{{$history->prescriptionNotes}}</td> 
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table> 


        <script> 

            async function addPrescription(event){
                const formData= new FormData(document.getElementById("addPrescriptionForm"))
                const id=formData.get("patientId")
                await fetch("/prescription",{
                    method:"POST",
                    body:formData, 
                })
                .then(response=>{return response.json()})
                .then(data=>{ 
                    if(data.msg=="ValidationFailed"){
                        console.log(data.errors)  
                    }
                    else if(data.msg=="success"){
                        console.log("success")
                        window.location.href= "/patient/"+id ;
                    }
                })
        }
        </script>

@endsection