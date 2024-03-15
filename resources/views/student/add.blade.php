@extends('layouts.main')
@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Add Student</h6>
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
                    <form action="{{ route('student.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">Student Name</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="name" placeholder="eg.. Class One" value="{{ old('name') }}"
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
                                          <option value="{{ $clas->id }}">{{ $clas->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                              </div>
                          </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="px-2">Year Admitted</label>
                                    <div class="mb-3 px-2">
                                        <input type="text" class="form-control" name="yearAdmitted" placeholder="eg.. 2023/2024" value="{{ old('yearAdmitted') }}"
                                            aria-describedby="email-addon">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                  <label class="px-2">Gender</label>
                                  <div class="mb-3 px-2">
                                          <div class="form-group">
                                            <select class="form-control" name="gender" id="gender">
                                              <option value="">-select--</option>
                                              <option value="male">Male</option>
                                              <option value="female">Female</option>
                                            </select>
                                          </div>
                                  </div>
                              </div>
                                  </div>

                                  <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label class="px-2">Reg No</label>
                                        <div class="mb-3 px-2">
                                            <input type="text" class="form-control" name="reg" placeholder="eg.. NIT/BGT/1023" value="{{ old('reg') }}"
                                                aria-describedby="email-addon">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label class="px-2">Parent Name</label>
                                      <div class="mb-3 px-2">
                                        <input type="text" class="form-control" name="parent_name" placeholder="full name" value="{{ old('parent_name') }}"
                                        aria-describedby="email-addon">
                                      </div>
                                  </div>
                                      </div>

                                      <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label class="px-2">Parent Phone</label>
                                            <div class="mb-3 px-2">
                                                <input type="text" class="form-control" name="parent_phone" placeholder="eg.. 0736........" value="{{ old('parent_phone') }}"
                                                    aria-describedby="email-addon">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                          <label class="px-2">Parent Email</label>
                                          <div class="mb-3 px-2">
                                            <input type="text" class="form-control" name="parent_email" placeholder="eg.. parent@email.com" value="{{ old('parent_email') }}"
                                            aria-describedby="email-addon">
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

