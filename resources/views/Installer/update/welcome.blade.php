@extends('layouts/fullLayoutMaster')

@section('title', 'Ultimate SMS Auto Installer')


@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">


    <style>

        table {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
        }

        table thead th {
            text-align: left;
            padding: 5px 0 5px 0;
        }

        table tbody td {
            padding: 5px 0;
        }

        table tbody td:last-child, table thead th:last-child {
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <div class="auth-wrapper auth-cover">
        <div class="auth-inner row m-0">
            <!-- Brand logo-->
            <a class="brand-logo" href="{{route('login')}}">
                <img src="{{asset(config('app.logo'))}}" alt="{{config('app.name')}}"/>
            </a>
            <!-- /Brand logo-->

            <!-- Left Text-->
            <div class="col-lg-3 d-none d-lg-flex align-items-center p-0">
                <div class="w-100 d-lg-flex align-items-center justify-content-center">
                    <img class="img-fluid w-100" src="{{asset('images/pages/create-account.svg')}}" alt="{{config('app.name')}}"/>
                </div>
            </div>
            <!-- /Left Text-->

            <!-- Register-->
            <div class="col-lg-9 d-flex align-items-center auth-bg px-2 px-sm-3 px-lg-5 pt-3">
                <div class="width-800 mx-auto">
                    <div class="bs-stepper register-multi-steps-wizard shadow-none">
                        <div class="bs-stepper-header px-0" role="tablist">

                            <div class="step" data-target="#system_configuration" role="tab" id="system_configuration-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                      <i data-feather="server" class="font-medium-3"></i>
                                    </span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">System Compatibility</span>
                                        <span class="bs-stepper-subtitle">Check Environments</span>
                                    </span>
                                </button>
                            </div>


                            <div class="line">
                                <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>

                            <div class="step" data-target="#check-permissions" role="tab" id="check-permissions-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                        <i data-feather="shield-off" class="font-medium-3"></i>
                                    </span>

                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Permissions</span>
                                        <span class="bs-stepper-subtitle">Set Folder Permissions</span>
                                    </span>
                                </button>
                            </div>


                            <div class="line">
                                <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>

                            <div class="step" data-target="#verification" role="tab" id="verification-trigger">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">
                                      <i data-feather="check-square" class="font-medium-3"></i>
                                    </span>

                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Verify License</span>
                                        <span class="bs-stepper-subtitle">Verify your license</span>
                                    </span>
                                </button>
                            </div>

                        </div>

                        <div class="bs-stepper-content px-0 mt-4">

                            @if ($errors->any())

                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        <div class="alert-body">{{ $error }}</div>
                                    </div>
                                @endforeach

                            @endif


                            <div id="system_configuration" class="content get_form_data" role="tabpanel" aria-labelledby="system_configuration-trigger">
                                <div class="content-header mb-2">
                                    <h6 class="fw-bolder mb-75">System Compatibility</h6>
                                    <span>Check Environments</span>
                                </div>

                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <thead>
                                            <tr>
                                                <th style="width: 500px">Requirements</th>
                                                <th>Result</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($requirements['requirements'] as $type => $requirement)

                                                @if($type == 'php')
                                                    <tr>
                                                        <td>PHP {{ $phpSupportInfo['minimum'] }} </td>

                                                        <td>
                                                            <div class="badge bg-{{ $phpSupportInfo['supported'] ? 'success' : 'danger' }} text-uppercase mr-1 mb-1"><span>{{ $phpSupportInfo['current'] }}</span></div>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @foreach($requirements['requirements'][$type] as $extention => $enabled)
                                                    <tr>
                                                        <td>{{ ucfirst($extention) }} PHP Extension</td>
                                                        <td>
                                                            @if($enabled)
                                                                <div class="badge bg-success text-uppercase mr-1 mb-1">
                                                                    Enabled
                                                                </div>
                                                            @else

                                                                <div class="badge bg-danger text-uppercase mr-1 mb-1">
                                                                    Not Enabled
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-outline-secondary btn-prev" disabled type="button">
                                        <i data-feather="chevron-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                    </button>

                                    @if ( ! isset($requirements['errors']) && $phpSupportInfo['supported'] )
                                        <button class="btn btn-primary btn-next" type="button" data-id="is_valid">
                                            <span class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.next') }}</span>
                                            <i data-feather="chevron-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>


                            <div id="check-permissions" class="content get_form_data" role="tabpanel" aria-labelledby="check-permissions-trigger">
                                <div class="content-header mb-2">
                                    <h2 class="fw-bolder mb-75">Check Permissions</h2>
                                    <span>Set Permission 775 following folders</span>
                                </div>

                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <thead>
                                            <tr>
                                                <th>Folder</th>
                                                <th>Permission</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($permissions['permissions'] as $permission)
                                                <tr>
                                                    <td>{{ $permission['folder'] }} </td>

                                                    <td>
                                                        <div class="badge bg-{{ $permission['isSet'] ? 'success' : 'danger' }} text-uppercase mr-1 mb-1">
                                                            <span>{{ $permission['permission'] }}</span>
                                                        </div>
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn btn-primary btn-prev" type="button">
                                        <i data-feather="chevron-left" class="align-middle me-sm-25 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                    </button>

                                    @if ( ! isset($permissions['errors']))
                                        <button class="btn btn-primary btn-next" type="button" data-id="is_valid">
                                            <span class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.next') }}</span>
                                            <i data-feather="chevron-right" class="align-middle ms-sm-25 ms-0"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div id="verification" class="content get_form_data" role="tabpanel" aria-labelledby="verification-trigger">
                                <form method="post" action="{{ route('Updater::verify_product') }}">
                                    @csrf
                                    <div class="content-header mb-2">
                                        <h2 class="fw-bolder mb-75">Verification</h2>
                                        <span>Verify your purchase code</span>
                                    </div>

                                    <!-- select plan options -->
                                    <div class="row custom-options-checkable gx-3 gy-2">
                                        <div class="col-12 mb-1">
                                            <label class="form-label required" for="purchase_code">Purchase Code</label>
                                            <input type="text" id="purchase_code" class="form-control required @error('purchase_code') is-invalid @enderror" value="{{ old('purchase_code') }}" name="purchase_code" required/>

                                            @error('purchase_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <!-- / select plan options -->

                                    <div class="d-flex justify-content-between mt-1">
                                        <button class="btn btn-primary btn-prev" type="button">
                                            <i data-feather="chevron-left" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-success btn-submit" type="submit">
                                            <i data-feather="check" class="align-middle me-sm-25 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Update</span>
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/wizard/bs-stepper.min.js'))}}"></script>
@endsection

@section('page-script')

    <script>
        let registerMultiStepsWizard = document.querySelector('.register-multi-steps-wizard'),
            pageResetForm = $('.auth-register-form'),
            numberedStepper;


        // multi-steps registration
        // --------------------------------------------------------------------

        // Horizontal Wizard
        if (typeof registerMultiStepsWizard !== undefined && registerMultiStepsWizard !== null) {
            numberedStepper = new Stepper(registerMultiStepsWizard);

            $(registerMultiStepsWizard)
                .find('.btn-next')
                .each(function () {
                    $(this).on('click', function (e) {
                        let isValid = $(this).data('id');
                        if (isValid === 'is_valid') {
                            numberedStepper.next();
                        } else {
                            e.preventDefault();
                        }
                    });
                });

            $(registerMultiStepsWizard)
                .find('.btn-prev')
                .on('click', function () {
                    numberedStepper.previous();
                });
        }

    </script>
@endsection

