@extends('partials.dashboard.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.consultation_work.update', $consultationWork->id) }}" class="form"
                method="post" id="submitted-form"
                data-redirection-url="{{ route('dashboard.consultation_work.edit', $consultationWork->id) }}">
                @csrf
                @method('PUT')

                <!-- Main Image Upload -->
                <div class="row mb-20">
                    <div class="col-md-12 fv-row d-flex justify-content-evenly">
                        <div class="d-flex flex-column align-items-center">
                            <label class="text-center fw-bold mb-4">{{ __('Main Image') }}</label>
                            <div>
                                <x-dashboard.upload-image-inp name="main_image" :image="$consultationWork->main_image"
                                    directory="Consultation_works" placeholder="default.jpg" type="editable">
                                </x-dashboard.upload-image-inp>
                            </div>
                            <p class="invalid-feedback" id="main_image"></p>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Steps Section -->
                <h4 class="text-bold">{{ __('Steps') }}</h4>

                @for ($i = 1; $i <= 3; $i++)
                    <div class="mb-3">
                        <!-- Step Image Upload -->
                        <div class="row mb-10">
                            <div class="col-md-12 fv-row d-flex justify-content-evenly">
                                <div class="d-flex flex-column align-items-center">
                                    <label class="text-center fw-bold mb-4">{{ __("Step $i Image") }}</label>
                                    <div>
                                        <x-dashboard.upload-image-inp name="steps[{{ $i }}][image]"
                                            :image="$consultationWork->steps[$i - 1]['image'] ?? null" directory="steps" placeholder="default.jpg" type="editable">
                                        </x-dashboard.upload-image-inp>
                                    </div>
                                    <p class="invalid-feedback" id="steps_{{ $i }}_image"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Step ID -->
                        <input type="hidden" name="steps[{{ $i }}][id]"
                            value="{{ $consultationWork->steps[$i - 1]['id'] ?? '' }}">

                        <div class="d-flex flex-column">
                            <label class="form-label">{{ __("Step $i Name") }}</label>
                            <input type="text" class="form-control" name="steps[{{ $i }}][name]"
                                value="{{ old("steps.$i.name", $consultationWork->steps[$i - 1]['name'] ?? '') }}">
                            <p class="invalid-feedback" id="steps_{{ $i }}_name"></p>
                        </div>

                        <div class="d-flex flex-column">
                            <label class="form-label">{{ __("Step $i Description") }}</label>
                            <textarea class="form-control" name="steps[{{ $i }}][description]">
                            {{ old("steps.$i.description", $consultationWork->steps[$i - 1]['description'] ?? '') }}
                        </textarea>
                            <p class="invalid-feedback" id="steps_{{ $i }}_description"></p>
                        </div>
                    </div>
                    <hr>
                @endfor
                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __('Update Consultation Work') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>
                <!-- end   :: Form footer -->
            </form>
        </div>
    </div>
@endsection
