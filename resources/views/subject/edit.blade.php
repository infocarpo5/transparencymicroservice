@extends('layouts.main')
@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Subject</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    	<!-- Validation Errors -->
			@if ($errors->any())
				<div class="mb-4">
					<div class="font-medium text-red-600">
						{{ __('Whoops! Something went wrong.') }}
					</div>

					<ul class="mt-3 list-disc list-inside text-sm text-red-600">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
                    <form action="{{ route('subject.update', $subject->uuid) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">Subject Name</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="name" placeholder="eg.. Programming" value="{{ $subject->name }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Unit</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="unit" placeholder="eg.. 12" value="{{ $subject->unit }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Class Name</label>
                                <div class="mb-3 px-2">
                                        <div class="form-group">
                                          <select class="form-control" name="class_id" id="class_id">
                                            <option value="">-select--</option>
                                            @foreach($classes as $clas)
                                            @if ($clas->id == $subject->class_id)
                                            <option value="{{ $subject->class_id}}" selected>{{ $clas->name }}</option>
                                            @else
                                            <option value="{{ $clas->id }}">{{ $clas->name }}</option>
                                            @endif
                                            @endforeach
                                          </select>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="mb-3 px-10 py-3 col-6 offset-3" style="float: right;" >
                                    <input type="submit" class="form-control btn bg-gradient-success mt-3 w-100" value="Update" aria-label="Email"
                                        aria-describedby="email-addon">
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

