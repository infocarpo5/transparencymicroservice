@extends('layouts.main')
@section('contents')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Driver</h6>
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
                    <form action="{{ route('class.update', $class->uuid) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">Full Name</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="full_name" placeholder="eg.. Juma Hamis Mdoe" value="{{ $class->full_name }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Email</label>
                                <div class="mb-3 px-2">
                                    <input type="email" class="form-control" name="email" placeholder="eg email@example.com" value="{{ $class->email }}"
                                        aria-label="Email" aria-describedby="email-addon">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">User name</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="username" placeholder="eg Mr. Mdoe" value="{{ $class->username }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Password</label>
                                <div class="input-group mb-3 px-2">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="********" value="{{ old('password') }}">
                                     {{-- <i class="icon fas fa-eye" id="eye-icon"></i> --}}
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Password Confirmation</label>
                                <div class="input-group mb-3 px-2">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="********" value="{{ old('password_confirmation') }}">
                                     {{-- <i class="icon fas fa-eye" id="eye-icon"></i> --}}
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Phone number</label>
                                <div class="mb-3 px-2">
                                    <input type="number" class="form-control" name="phone" aria-label="Email" placeholder="eg.. 255012345678" value="{{ $class->phone }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">National ID</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="nida" placeholder="Twenty digits without symbols" value="{{ $class->nida }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Plate Number</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="plate_number" placeholder="eg.. T001" value="{{ $class->plate_number }}"
                                        aria-label="Email" aria-describedby="email-addon">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label class="px-2">License</label>
                                <div class="mb-3 px-2">
                                    <input type="text" class="form-control" name="license" placeholder="eg.. TN1234567890" value="{{ $class->license }}"
                                        aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="px-2">Passport Image</label>
                                <div class="mb-3 px-2">
                                    <input type="file" class="form-control" name="image" placeholder="" value="{{ old('image') }}"
                                        aria-label="Email" aria-describedby="email-addon">
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

