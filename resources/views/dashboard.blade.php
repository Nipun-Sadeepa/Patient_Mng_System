<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/patient/create">Add patient</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/payment">Payment Management</a>
                            </li>
                        </ul>

                      
                        <div class="d-flex ms-auto">
                            <input class="form-control me-2" type="search" placeholder="Searchc by NIC" aria-label="Search" name="nic" id="nic">
                            <a href="#" class="btn btn-outline-success" onclick="getSearchString()" id="searchLink">Search</a> 
                        </div>
                       
                    </div>  
                </nav>    

                @isset($matchingResults)
                    <p class="alert alert-warning">Can't find exact patient regarding to NIC you provide. Please refer follows to find relevant patient</p>
                @endisset

                @isset($errorPatientIndex)
                    <p class="alert alert-warning">Can't find any patients registered to the application</p>
                @endisset

                <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Birth day</th>
                                <th scope="col">Contact No</th>
                                <th scope="col">NIC</th>
                                <th scope="col">View</th>
                                </tr>
                        </thead>
                        <tbody>
                            @if(isset($allPatient))
                                @foreach($allPatient as $patient)
                                    <tr id={{$patient->id}} >
                                        <td>{{$patient->name}}</td>
                                        <td>{{$patient->bday}}</td>
                                        <td>{{$patient->contactNo}}</td>
                                        <td>{{$patient->nic}}</td>
                                        <td><a href="/patient/{{$patient->id}}" class="btn btn-primary">View</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    @if($allPatient->hasPages())
                        {{ $allPatient->links() }}
                    @endif
                  
                </div>
            </div>
        </div>
    </div>

    
    <script>
        function deletePatient(event){

        }

        function getSearchString(){
            const searchInput = document.getElementById('nic')
            const searchLink = document.getElementById('searchLink')
        
            const searchString = searchInput.value
            const url = '/search/' + encodeURIComponent(searchString)
            searchLink.setAttribute('href', url)
        }

    </script>
</x-app-layout>
