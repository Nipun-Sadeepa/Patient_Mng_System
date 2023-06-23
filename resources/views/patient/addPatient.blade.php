@extends('./layouts/main')
@section('content')

<!-- Form for add patient -->
<form name="addPatientForm" action="" id="addPatientForm" autocomplete="on" onsubmit="addPatient(event)">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" autofocus required>
    </div>
    <div class="mb-3">
        <label for="bday" class="form-label">Birth Day</label>
        <input type="date" class="form-control" name="bday" id="bday" min="1990-01-01" required>
    </div>
    <div class="mb-3">
        <label for="contactNo" class="form-label">Contact No</label>
        <input type="text" class="form-control" name="contactNo" id="contactNo" minlength="10" maxlength="10" required>
    </div>
    <div class="mb-3">
        <label for="nic" class="form-label">NIC</label>
        <input type="text" class="form-control" name="nic" id="nic" minlength="10" maxlength="13" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" accept="image/*" name="image" id="image" required />
    </div>
    <div class="input-group">
        <span class="input-group-text">Notes</span>
        <textarea class="form-control" aria-label="With textarea" name="notes" id="notes" required></textarea>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>


<script>
    async function addPatient(event) {
        event.preventDefault();
        let formData = new FormData(document.getElementById("addPatientForm"))
        await fetch("/patient", {
                method: "POST",
                body: formData,
            })
            .then(response => {
                return response.json()
            })
            .then(data => {
                if (data.msg == "success") {
                    window.location.href = "/dashboard";
                }
            })
    }
</script>
@endsection