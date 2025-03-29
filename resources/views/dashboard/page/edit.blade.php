@extends('partials.dashboard.master')

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('dashboard.page.update', $page->id) }}" method="post" class="form" id="submitted-form"
                data-redirection-url="{{ route('dashboard.page.edit', $page->id) }}">
                @csrf
                @method('PUT')

                {{-- <div class="mb-4">
                    <label for="title_inp" class="form-label fw-bold">{{ __('Page Title') }}</label>
                    <input type="text" id="title_inp" class="form-control" name="title"
                        value="{{ old('title', $page->title) }}" disabled>
                    <p class="invalid-feedback" id="title"></p>

                </div> --}}

                <h3 class="fw-bold text-center mb-5 mt-6" style="font-weight: bold">{{ __('Sections') }}</h3>

                @foreach ($page->sections as $index => $section)
                    <div class="card mb-5 ">

                        <input type="hidden" class="form-control" name="sections[{{ $index }}][id]"
                            value="{{ old("sections.$index.id", $section->id ?? '') }}">
                        <div class="mb-4 border p-3 rounded">
                            <h5 class="fw-bold">{{ __('Section') }} {{ $index + 1 }}</h5>
                            <div class="row mb-10">
                                <div class="col-md-6 fv-row">
                                    <div class="col-md-12 fv-row d-flex justify-content-evenly">
                                        <div class="d-flex flex-column align-items-center">
                                            <label class="text-center fw-bold mb-4">{{ __('Section Image') }}</label>
                                            <div>
                                                <x-dashboard.upload-image-inp name="sections[{{ $index }}][image]"
                                                    :image="$section->image ?? null" directory="sections" placeholder="default.jpg"
                                                    type="editable">
                                                </x-dashboard.upload-image-inp>
                                            </div>
                                            <p class="invalid-feedback" id="steps_{{ $index }}_image"></p>
                                        </div>
                                    </div>

                                    <label for="sections[{{ $index }}][title]_inp"
                                        class="form-label">{{ __('Section Title') }}</label>
                                    <input type="text" id="sections[{{ $index }}][title]_inp"
                                        class="form-control" name="sections[{{ $index }}][title]"
                                        value="{{ old("sections.$index.title", $section->title ?? '') }}">
                                    <p class="invalid-feedback" id="sections[{{ $index }}][title]"></p>

                                </div>

                                <div class="col-md-6 fv-row">
                                    <label class="form-label">{{ __('Section Description') }}</label>
                                    <textarea class="form-control" name="sections[{{ $index }}][description]" rows="9">
                                    {{ old("sections.$index.description", $section->description ?? '') }}
                                </textarea>
                                </div>


                            </div>
                            @if (!empty($section->items) && count($section->items) > 0)
                                <hr>
                                <h3 class="fw-bold mt-3 text-primary">{{ __('Items') }}</h3>
                                <div class="row">
                                    @foreach ($section->items as $itemIndex => $item)
                                        <input type="hidden" class="form-control"
                                            name="sections[{{ $index }}][items][{{ $itemIndex }}][id]"
                                            value="{{ old("sections.$index.items.$itemIndex.id", $item->id ?? '') }}">
                                        <div class="col-md-6">
                                            <div class="card shadow-sm p-3 mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold text-secondary">{{ __('Item') }}
                                                        {{ $itemIndex + 1 }}</h5>



                                                    <div class="col-md-12 fv-row d-flex justify-content-evenly">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <label
                                                                class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                                            <div>
                                                                <x-dashboard.upload-image-inp
                                                                    name="sections[{{ $index }}][items][{{ $itemIndex }}][image]"
                                                                    :image="$item->image ?? null" directory="items"
                                                                    placeholder="default.jpg" type="editable">
                                                                </x-dashboard.upload-image-inp>
                                                            </div>
                                                            <p class="invalid-feedback" id="main_image"></p>
                                                        </div>
                                                    </div>

                                                    <!-- Item Title -->
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">{{ __('Item Title') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="sections[{{ $index }}][items][{{ $itemIndex }}][title]"
                                                            value="{{ old("sections.$index.items.$itemIndex.title", $item->title ?? '') }}">
                                                    </div>

                                                    <!-- Item Description -->
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label fw-bold">{{ __('Item Description') }}</label>
                                                        <textarea class="form-control" rows="3"
                                                            name="sections[{{ $index }}][items][{{ $itemIndex }}][description]">{{ old("sections.$index.items.$itemIndex.description", $item->description ?? '') }}</textarea>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif



                        </div>
                    </div>
                @endforeach

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __('Update Page') }}</span>

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
