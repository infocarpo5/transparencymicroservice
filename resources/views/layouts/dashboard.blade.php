@if(Auth::user()->role_id === 1)
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <a href="{{ url('programmes/index') }}">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Programmes</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $programmes }}
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-4 text-end">
                        {{-- <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <a href="{{ url('students/index') }}">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Students</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $students }}
                                    {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-4 text-end">
                        {{-- <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Courses</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $courses }}
                                {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        {{-- <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Exams</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $exams }}
                                {{-- <span class="text-success text-sm font-weight-bolder">+5%</span> --}}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        {{-- <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->role_id === 0)
<div>
    <h3>Student Profile</h3>
</div>
<table class="table  ">
    <tbody class="table-striped table-bordered">
        <tr>
            <th>Name</th>
            <td>Kelvin</td>
            <th>Reg</th>
            <td>NIT/BIT/2019/1</td>
        </tr>
        <tr>
            <th>Programme</th>
            <td>BIT</td>
            <th>A/y</th>
            <td>2019/1</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Active</td>
            <th>Dender</th>
            <td>Male</td>
        </tr>
    </tbody>
</table>

<div>
    <h3>Next Keen Info</h3>
</div>
<table class="table  ">
    <tbody class="table-striped table-bordered">
        <tr>
            <th>Parent Name</th>
            <td>Kelvin</td>
            <th>Reg</th>
            <td>NIT/BIT/2019/1</td>
        </tr>
        <tr>
            <th>Programme</th>
            <td>BIT</td>
            <th>A/y</th>
            <td>2019/1</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Active</td>
            <th>Dender</th>
            <td>Male</td>
        </tr>
    </tbody>
</table>
@endif