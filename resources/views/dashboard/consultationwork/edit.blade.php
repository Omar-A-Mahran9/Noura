@extends('partials.dashboard.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.consultation_work.update', $consultationWork->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Main Image Upload -->
                <div class="row mb-20">
                    <div class="col-md-12 fv-row d-flex justify-content-evenly">
                        <div class="d-flex flex-column align-items-center">
                            <label class="text-center fw-bold mb-4">{{ __('Main Image') }}</label>
                            <div>
                                <x-dashboard.upload-image-inp name="main_image" :image="$consultationWork->main_image"
                                    directory="consultation_work" placeholder="default.jpg" type="editable">
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

                        <label class="form-label">{{ __("Step $i Name") }}</label>
                        <input type="text" class="form-control" name="steps[{{ $i }}][name]"
                            value="{{ old("steps.$i.name", $consultationWork->steps[$i - 1]['name'] ?? '') }}">

                        <label class="form-label">{{ __("Step $i Description") }}</label>
                        <textarea class="form-control" name="steps[{{ $i }}][description]">{{ old("steps.$i.description", $consultationWork->steps[$i - 1]['description'] ?? '') }}</textarea>


                    </div>
                    <hr>
                @endfor

                <button type="submit" class="btn btn-primary">{{ __('Update Consultation Work') }}</button>
            </form>
        </div>
    </div>
@endsection
