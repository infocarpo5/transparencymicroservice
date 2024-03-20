@extends('layouts.main')
@section('contents')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Subjects List</h6>
          <a class="btn btn-outline-default btn-sm mb-0 me-3"  href="{{ route('subject.create') }}">Add</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">#</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Unit</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class Name</th>
                    <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                  </tr>
              </thead>
              <tbody>
                @if(!empty($subject))
                @foreach ($subject as $row )
                <tr class="text-left">
                  <td class="text-center"><p class="text-xs text-secondary mb-0"> {{ $loop->iteration }}</p></td>
                    <td>
                      <p class="text-xs text-secondary mb-0">{{ $row->name }}</p>
                    </td>
                    <td>
                      <p class="text-xs text-secondary mb-0">{{ $row->unit ?? "" }}</p>
                    </td>
                    <td>
                      <p class="text-xs text-secondary mb-0">{{ $row->class->name }}</p>
                    </td>
                    <td class="align-middle">
                      <a href="{{ url('subject/edit/'.$row->uuid) }}" class="text-secondary btn btn-sm btn-outline-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                      <a  onclick="archiveFunction('<?= $row->uuid ?>')" class="text-secondary btn btn-sm btn-outline-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Delete
                      </a>
                    </td>
                  </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="text-center"> {{ $subject->onEachSide(1)->links('vendor.pagination.custom') }} </div>
    </div>
  </div>

  @if (session()->has('success'))
  <div class="alert alert-success" id="ficha">
    <button type="button" class="close" onclick="closeSession()">
      <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ session('success') }}</strong> 
  </div>
  @endif


    {{-- success modal --}}
    <div class="modal" id="successModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header bg-gradient-success">
                  <div class="d-flex ">
                    <h5 class="modal-title text-white">Success </h5>
                  </div>
              </div>
              <div class="modal-body">
                  <p id="data"></p>
              </div>
          </div>
      </div>
  </div>
  {{-- end modal --}}

      {{-- failed modal --}}
      <div class="modal" id="failedModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-danger">
                    <div class="d-flex ">
                      <h5 class="modal-title text-white">Failed </h5>
                    </div>
                </div>
                <div class="modal-body">
                    <p id="dataa"></p>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal --}}
@endsection
<script>
      function closeSession(){
      $("#ficha").hide();
    }

  function more(id){
    $.get('/subject/show/' + id, function(response){
        $('#email').text(response.email);
        $('#username').text(response.username + ' Profile');
        $('#usernamee').text(response.username);
        $('#phone').text(response.phone);
        $('#nida').text(response.nida);
        $('#license').text(response.license);
        $('#full_name').text(response.full_name);
        $('#plate_number').text(response.plate_number);
        $('#picha').attr('src', 'assets/img/' + response.image);
        $('#showModal').modal('show');
    });
  }


  function archiveFunction(code) {
  event.preventDefault(); 
  var id = code; 
  swal({
    title: "Are you sure?",
    text: "You will not be able to retrieve it again",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, Delete it!",
    cancelButtonText: "No, cancel please!",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        type: 'delete',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/subject/delete/' + id,
        success: function(response) {
          $("#successModal").show();
          $("#data").text(response.message);
          $("#successModal").fadeIn();
        $("#successModal").fadeOut(6000);
        window.location.reload();
        },
        error: function(response) {
          $("#failedModal").show();
          $("#dataa").text(response.responseJSON.message);
          $("#failedModal").fadeIn();
        $("#failedModal").fadeOut(7000);
        }
      });
    }
  });
}

</script>