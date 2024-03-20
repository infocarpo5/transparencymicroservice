@extends('layouts.main')
@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Add Exam</h6>
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
                    <form action="{{ route('exam.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">Exam Name</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="name" placeholder="eg.. Class One" value="{{ old('name') }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                              <label class="px-2">To be Done</label>
                              <div class="mb-3 px-2">
                                  <input type="date" class="form-control" name="date" placeholder="" value="{{ old('date') }}"
                                      aria-describedby="email-addon">
                              </div>
                          </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-lg-6">
                                  <label class="px-2">Abbreviation</label>
                                  <div class="mb-3 px-2">
                                      <input type="text" class="form-control" name="abbreviation" placeholder="eg.. 2023/2024" value="{{ old('abbreviation') }}"
                                          aria-describedby="email-addon">
                                  </div>
                              </div>
                              <div class="form-group col-lg-6">
                                <label class="px-2">Term</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="term" placeholder="eg.. semester 1" value="{{ old('term') }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                              <label class="px-2">Subject Name</label>
                              <div class="mb-3 px-2">
                                      <div class="form-group">
                                        <select class="form-control" name="subject_id" id="subject_id">
                                          <option value="">-select--</option>
                                          @foreach($subjects as $clas)
                                          <option value="{{ $clas->id }}">{{ $clas->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                              </div>
                          </div>
                                  </div>
                                          </div>
                              <div class="row">
                                <div class="mb-3 px-10 py-3  col-lg-6 offset-3" style="float: right;" >
                                  <input type="submit" class="form-control btn bg-gradient-success mt-3 w-100" value="submit" aria-label="Email"
                                      aria-describedby="email-addon">
                              </div>
                              </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

