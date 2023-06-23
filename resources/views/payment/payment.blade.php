@extends('./layouts/main')

@section('content')

    <h2>Payment History</h2>  
    <br><br>

    <!-- Payment filtering -->
    <div class="border d-flex">
        <div class="ms-auto">
            <label for="searchDateStart" class="form-label">Start Date : </label> &nbsp;&nbsp;
            <input class="me-2" type="date" placeholder="Search by date" aria-label="Search" name="searchDateStart" id="searchDateStart">
            <label for="searchDateEnd" class="form-label">End Date : </label> &nbsp;&nbsp;
            <input class="me-2" type="date" placeholder="Search by date" aria-label="Search" name="searchDateEnd" id="searchDateEnd">
            <a href="#" class="btn btn-outline-success" onclick="getDate()" id="searchLink">Search</a> 
        </div>
    </div>
    <br>

    <!-- Show filtered payments -->
    @isset($errorPaymentShowReport)
        <p class="alert alert-warning">Can't find any payments regarding to your searched time period</p>
    @endisset
    
    @if(isset($paymentOfGroups) && isset($totalPayments))
        <div class="bg-success text-white">
            <p>Total payments for given time period : {{$totalPayments[0]->totalFee}} <br>
            Follow this table to check all payments regarding to each patient
            </p>
        </div> <br><br>

        <h3>Payment Summary regarding to patient</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="align-middle text-center" scope="col">Patient Name</th>
                    <th class="align-middle text-center" scope="col">Patient NIC</th>
                    <th class="align-middle text-center" scope="col">Total Payments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentOfGroups as $payment)
                    <tr>
                        <td class="align-middle text-center">{{$payment->name}}</td>
                        <td class="align-middle text-center">{{$payment->nic}}</td>
                        <td class="align-middle text-center">{{$payment->sumFee}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
    @endif
    
    <!-- Show latest 100 payments -->
    <h3>All Payment Details</h3>
    @isset($errorPaymentIndex)
        <p class="alert alert-warning">Can't find any payments till now that recorded in application</p>
    @endisset
    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="align-middle text-center" scope="col">Date</th>
                <th class="align-middle text-center" scope="col">Patimet Name</th>
                <th class="align-middle text-center" scope="col">Payment</th>
            </tr>
        </thead>
        <tbody>

        @if(isset($paymentSummary))
            @foreach($paymentSummary as $payment)
                <tr id={{$payment->id}} >
                    <td class="align-middle text-center">{{$payment->dateOnly}}</td>
                    <td class="align-middle text-center">{{$payment->name}}</td>
                    <td class="align-middle text-center">{{$payment->drFee}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
    {{ $paymentSummary->links() }}


    <script>
        function getDate(){ 
            console.log("came")   
            const searchDateStart = document.getElementById('searchDateStart')
            const searchDateEnd = document.getElementById('searchDateEnd')
            const searchLink = document.getElementById('searchLink')
        
            const date1 = searchDateStart.value
            const date2 = searchDateEnd.value
            const url1 = '/payment/' + encodeURIComponent(date1)
            const url2 =  encodeURIComponent(date2)
            console.log(url1+'/'+url2)
            searchLink.setAttribute('href', url1+'/'+url2)
        }
    </script>
@endsection


