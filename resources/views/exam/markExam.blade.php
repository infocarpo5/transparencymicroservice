@extends('layouts.main')
@section('contents')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>{{ $exam }} Mark Exam </h6>
          {{-- <a class="btn btn-outline-default btn-sm mb-0 me-3"  href="{{ route('exam.create') }}">Add</a> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">#</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stdent Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mark</th>
                    <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                  </tr>
              </thead>
              <tbody id="data-here">

              </tbody>
            </table>
          </div>
        </div>
      </div>
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

@section('scripts')
<script>
      function closeSession(){
      $("#ficha").hide();
    }

  function more(id){
    $.get('/exam/show/' + id, function(response){
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
        url: '/exam/delete/' + id,
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


$(document).ready(function () {
  var currentUrl = window.location.href;
  var examId = currentUrl.split('/').pop();

  $.ajax({
    type: "get",
    url: `/exam/get-data-to-mark/${examId}`,
    dataType: "JSON",
    success: function (response) {
      let studentsHtml = '';
      let index = 1;

      response.forEach(function(item, index) {
      studentsHtml += '<tr class="text-left">';
      studentsHtml += '<td class="text-left"><p class="text-xs text-secondary mb-0">' + (index + 1) + '</p></td>';
      studentsHtml += '<td class="text-left"><p class="text-xs text-secondary mb-0">' + item.studentName + '</p></td>';
      studentsHtml += '<td class="text-left">' + (item.score !== null ? item.score : '<input type="text" id="score_input_' + item.studentId + '" class="form-control score-input" name="mark"  placeholder="Fill marks">') + '</td>';
      studentsHtml += '</tr>';
    });
      $("#data-here").append(studentsHtml);
    }
  });


  $(document).on("keyup", ".score-input", function(event) {
    // Check if the pressed key is Enter
    if (event.keyCode === 13) {
      // Get the ID of the input
      var id = $(this).attr("id").split("_")[2]; // Changed index to 2
      // Get the score entered
      var score = $(this).val();
      // Now you have both the ID and score, you can process them further
      console.log("Student ID: " + id + ", Score: " + score);
      let data = {
        studentId: id,
        score: score,
        examId: examId
      }
        $.ajax({
        method: "post",
        url: `/mark?`,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "JSON",
        success: function (response) {
        console.log(response);
        if (response.status == 200) {
          toastr.success(response.success);
          $.ajax({
            type: "get",
            url: `/exam/get-data-to-mark/${examId}`,
            dataType: "JSON",
            success: function (response) {
              $("#data-here").empty();
              let studentsHtml = '';
              let index = 1;

              response.forEach(function(item, index) {
              studentsHtml += '<tr class="text-left">';
              studentsHtml += '<td class="text-left"><p class="text-xs text-secondary mb-0">' + (index + 1) + '</p></td>';
              studentsHtml += '<td class="text-left"><p class="text-xs text-secondary mb-0">' + item.studentName + '</p></td>';
              studentsHtml += '<td class="text-left">' + (item.score !== null ? item.score : '<input type="text" id="score_input_' + item.studentId + '" class="form-control score-input" name="mark"  placeholder="Fill marks">') + '</td>';
              studentsHtml += '</tr>';
            });
              $("#data-here").append(studentsHtml);
            }
          });
        } else {
          toastr.error(response.error);
        }
    }
  });
    }
  });
});

</script>



@endsection