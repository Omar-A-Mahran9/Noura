let tagsSp              = $("#tags-sp");
let brandsSp            = $("#brand-sp");
let modelsSp            = $("#model-sp");
let subModelsSp         = $("#sub-model-sp");
let colorsSp            = $("#colors-sp");
let drivingModeSp       = $("#driving-mode-sp");
let priceFieldInp       = $("#price-field-val");
let priceInp            = $("#price_inp");
let discountInp         = $("#discount_price_inp");
let carColorsDiv        = $("#car-colors");
let undoDeleteBtn       = $("#undo-delete-image");
let previouslySelected  = [];
let updatedColorsImages = {};
let duplicatedImages    = {};
let deletedColorsImages = [];

$(document).ready( () => {

    brandsSp.change( function (event , modelId = null ) {

        let selectedBrandId = $(this).val();
        modelsSp.empty();
        modelsSp.attr('disabled','true');
        subModelsSp.empty();

        $.ajax({
            url:`/get-brand-parent-models/${selectedBrandId}` ,
            method:"GET",
            success: (response) => {

                modelsSp.removeAttr('disabled');
                subModelsSp.attr('disabled','true');

                modelsSp.append(`<option></option>`);
                subModelsSp.append(`<option></option>`);

                response['models'].forEach( ( model ) => {
                    modelsSp.append(`<option value="${ model['id'] }" > ${ model['name'] } </option>`)
                });
                if ( modelId )
                {
                    modelsSp.val(modelId);
                    modelsSp.trigger('change',selectedSubModelId)
                }

            }
        });

    });

    modelsSp.change( function (event , subModelId = null) {

        let selectedModelId = $(this).val();

        $.ajax({
            url:`/get-sub-models/${selectedModelId}` ,
            method:"GET",
            success: (response) => {

                subModelsSp.empty();
                subModelsSp.removeAttr('disabled');

                subModelsSp.append(`<option></option>`);

                response['models'].forEach( ( model ) => {
                    subModelsSp.append(`<option value="${ model['id'] }" > ${ model['name'] } </option>`)
                });

                subModelsSp.val(subModelId);


            }
        });

    });

    undoDeleteBtn.click( function () {

        let restoredImage = deletedColorsImages.pop();

        let previousImagesArray = JSON.parse(updatedColorsImages[ restoredImage['color_id'].toString() ][ restoredImage['type'] + '_images']);

        previousImagesArray.push( restoredImage['image'] );

        updatedColorsImages[ restoredImage['color_id'].toString() ][ restoredImage['type'] + '_images'] = JSON.stringify(previousImagesArray) ;

        if ( isDuplicating )
            duplicatedImages[ restoredImage['color_id'].toString() ][ restoredImage['type'] + '_images'] = previousImagesArray ;

        $(`#${ cleanImageName( restoredImage['image'] ) }-deleted-image`).removeClass('d-none');

        if ( deletedColorsImages.length === 0 )
        {
            undoDeleteBtn.prop('disabled',true)
        }
        else
        {
            undoDeleteBtn.prop('disabled',false)
            $("#no-images-text").addClass('d-none');
        }

    });

    colorsSp.change(function (event , isEditing = false) {


        let currentlySelected   = $(this).val(); // ids [1, 2, 3]
        let currentIndex        = currentlySelected.length - 1;
        let lastSelectedColorId = null;
        let isAdding            = currentlySelected.length > previouslySelected.length;


        if ( isAdding )
        {
            lastSelectedColorId = currentlySelected.find( ( element ) => ! previouslySelected.includes(element) )

            let selectedColor   = colors.find( (color) => color['id'] == lastSelectedColorId );
            let colorImages     = carColors.find( (car) => car['color_id'] == lastSelectedColorId );
            let carInnerImagesCount = null;
            let carOuterImagesCount = null;
            if( colorImages )
            {
                 carInnerImagesCount = '( ' + JSON.parse(colorImages.inner_images).length + ' )';
                 carOuterImagesCount = '( ' + JSON.parse(colorImages.outer_images).length + ' )';
            }

            carColorsDiv.append(`<div class="rounded border border-3 p-5 mb-4" id="color-${lastSelectedColorId}">

                                                <!-- begin :: Row -->
                                                <div class="row text-center">

                                                    <!-- Begin :: Column -->
                                                    <div class="col-md-4 fv-row">
                                                        <h4>${ selectedColor['name'] }</h4>
                                                        <div class="rounded-circle w-80px h-80px m-auto" style="border:1px solid lightslategrey;background:${ selectedColor['hex_code'] ?? `url(${getImagePathFromDirectory(selectedColor['image'], 'Colors')})` }"></div>
                                                        <input type="hidden" name="colors[${currentIndex}][id]" value=${ selectedColor['id'] } >
                                                    </div>
                                                    <!-- end   :: Column -->

                                                    <!-- begin :: Column -->
                                                    <div class="col-md-4 fv-row">
                                                        <!-- begin :: Upload image component -->
                                                        <label class="text-center fw-bold mb-4 d-block">${ __("Outer images")}</label>
                                                        <input type="file" class="d-none" name="colors[${currentIndex}][outer_images][]" multiple id="outer_images_inp_${ selectedColor['id'] }">
                                                        <button class="btn btn-secondary m-auto" type="button" id="outer_images_upload_btn_${ selectedColor['id'] }" > <i class="bi bi-upload fs-8" ></i> 0 ${ __('File selected') } </button>
                                                        <a class="text-primary mt-2 d-block" href="javascript:openImagesModal( 'outer' , ${ selectedColor['id'] })"  >${ isEditing ?  __('preview photos') + ' ' + ( carOuterImagesCount ?? '' )  : '' }</a>
                                                        <p class="invalid-feedback" id="colors_${currentIndex}_outer_images" ></p>
                                                        <!-- end   :: Upload image component -->
                                                    </div>
                                                    <!-- end   :: Column -->

                                                    <!-- begin :: Column -->
                                                    <div class="col-md-4 fv-row">
                                                        <!-- begin :: Upload image component -->
                                                        <label class="text-center fw-bold mb-4 d-block">${ __("Inner images")}</label>
                                                        <input type="file" class="d-none" name="colors[${currentIndex}][inner_images][]" multiple id="inner_images_inp_${ selectedColor['id'] }">
                                                        <button class="btn btn-secondary m-auto" type="button" id="inner_images_upload_btn_${ selectedColor['id'] }" > <i class="bi bi-upload fs-8" ></i> 0 ${ __('File selected') } </button>
                                                        <a class="text-primary mt-2 d-block" href="javascript:openImagesModal( 'inner' , ${ selectedColor['id'] } )"  >${ isEditing ?  __('preview photos') + ' ' + ( carInnerImagesCount ?? '' )  : '' }</a>
                                                        <p class="invalid-feedback" id="colors_${currentIndex}_inner_images" ></p>
                                                        <!-- end   :: Upload image component -->
                                                    </div>
                                                    <!-- end   :: Column -->

                                                </div>
                                                <!-- end   :: Row -->

                                            </div>`);
            if ( isEditing )
            {
                let selectedColorIndex = carColors.findIndex( (color) => color['color_id'] == selectedColor['id'] );
                duplicatedImages[ selectedColor['id'] ] = { 'inner_images' : JSON.parse(carColors[selectedColorIndex]['inner_images']) , 'outer_images' : JSON.parse(carColors[selectedColorIndex]['outer_images'])};
            }

        }else
        {
            lastSelectedColorId = previouslySelected.find( ( element ) => ! currentlySelected.includes(element) )

            carColorsDiv.find(`[id=color-${lastSelectedColorId}]`).eq(0).remove();
        }

        previouslySelected = currentlySelected;

    });

    $("#discount-price-switch").change( function () {
        discountInp.prop('disabled' , ! $(this).prop('checked'))
    });

    $(".price-filed-radio:not(#other-radio-btn)").change( function () {
        changePriceField( $(this) )
    });

    $("#save-imgs-btn").click( function () {

        Object.entries(updatedColorsImages).map( color => {

            let colorId    = color[0];
            let imagesKey  = Object.keys(color[1])[0];
            let images     = color[1][imagesKey];

            let colorIndex = carColors.findIndex( (color) => color['color_id'] == colorId);

            carColors[colorIndex][imagesKey] = images;

        })

        $("#edit-images-modal").modal('hide');

    });

    $("#other-radio-btn").click(function () {
        $("#price-other-modal").modal('show')
    });

    $("#price-other-text-btn").click( function () {
        let priceFieldVal = $("#other_text_" + locale.trim() + "_inp").val();
        priceFieldInp.text( priceFieldVal );
        $("#price-other-modal").modal('hide')

    });

    priceInp.keyup(() => changePriceField() );

    discountInp.keyup( function () {

        if ( parseInt( $(this).val() ) >= parseInt( priceInp.val() ) )
        {
            $(this).val("");
            warningAlert(__('Discount price must be smaller than the price'))
        }

        changePriceField()

    });


    $(document).on('click',"[id*=images_upload_btn]", function () {

        $(this).prev().trigger('click');

    });

    $(document).on('change',"[id*=_images_inp]", function () {

        let filesNumber = $(this)[0].files.length;
        $(this).next().html(`<i class="bi bi-upload fs-8" ></i> ${ filesNumber } ${ __('File selected') }`);

    });

    tagsSp.val( carTagsIds ).trigger('change');

});

let changePriceField = ( element = $('input[name="price_field_status"]:checked') ) => {

    if ( element.val() === "show" )
    {

        if ( discountInp.val() && priceInp.val() )
        {
            priceFieldInp.html(`<span>${ discountInp.val() + currency }  <del> ${ priceInp.val() + currency } </del> </span>`)
        }
        else if ( priceInp.val() )
        {
            priceFieldInp.html(priceInp.val() + currency)
        }

    }else
    {
        let priceFieldVal = element.next().html();
        priceFieldInp.text( priceFieldVal );
    }

}

let openImagesModal = ( type , colorId) => {

    $("#modal-title").text( type === "outer" ? __('Outer images') : __('Inner images') );

    let selectedColorIndex = carColors.findIndex( (color) => color['color_id'] == colorId );
    let images    = JSON.parse( carColors[selectedColorIndex][ type + '_images' ] );

    $("#images-container").empty();

    if ( images.length > 0)
        $("#no-images-text").addClass('d-none');
    else
        $("#no-images-text").removeClass('d-none');

    images.forEach( ( image ) => {

        let imageContainerId = cleanImageName( image ) + "-deleted-image";

        $("#images-container").append(`

                <div class="col-md-3 col-12 my-4 text-center" id="${imageContainerId}">

                <div class="image-input image-input-outline" >

                <div class="image-input-wrapper w-100px h-100px" style="background-image: url('${ getImagePathFromDirectory(image, 'Cars')}'); background-size:contain;"></div>

                    <!-- begin :: Delete button -->
                    <label
                        onclick="deleteColorImage('${selectedColorIndex}','${image}', '${type}')"
                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        title="${ __('Delete image') }">
                        <i class="bi bi-trash-fill fs-7 text-danger"></i>
                    </label>
                    <!-- end   :: Delete button -->

                </div>
                <!--end::Image input-->

                </div>`
        );

    });

    $("#edit-images-modal").modal('show');


}

let deleteColorImage = ( deletedColorIndex ,deletedImage , type) => {

    let deletedColor = Object.create(carColors[deletedColorIndex]);

    deletedColorsImages.push({  color_id : deletedColor['color_id'] , image:deletedImage , type}); // add the deleted image to deletedColorsImages array to use it in undo operation

    let deletedImages               = deletedColorsImages.filter((color) => color['color_id'] == deletedColor['color_id'] ).map( obj => obj['image']);
    let images                      = JSON.parse(deletedColor[ type + '_images']); // get the outer/inner images from the deleted color object and parse the json array
    let filteredImages              = images.filter( ( image ) => ! deletedImages.includes(image) ); // return new outer/inner images array without the deletedImage
    deletedColor[ type + '_images'] = JSON.stringify(filteredImages); // update the deletedColor outer/inner images array with the filtered one


    type === "inner" ? delete deletedColor.outer_images : delete deletedColor.inner_images;

    updatedColorsImages[ deletedColor['color_id'] ] =  { ...updatedColorsImages[ deletedColor['color_id'] ]  , ...deletedColor } // push the updated color to the updatedColorsImages array

    $(`#${ cleanImageName( deletedImage ) }-deleted-image`).addClass('d-none'); // hide the deleted image

    undoDeleteBtn.prop('disabled',false); // enable the undo button

    let noElementsVisible= $(`[id*=-deleted-image]`).map(function() {  // check if all elements is invisible
        return this.getAttribute('class');
    }).get().every((element) => element.includes('d-none'));


    if ( noElementsVisible ) // if all elements has d-none class so make the no images text visible
        $("#no-images-text").removeClass('d-none');
    else
        $("#no-images-text").addClass('d-none');

    if ( isDuplicating )
    {
        duplicatedImages[deletedColor['color_id']][type + '_images'] = duplicatedImages[deletedColor['color_id']][type + '_images'].filter( (image) => image !== deletedImage);
    }



}

let validateStep = async (successCallback) => {

    nextBtn.attr('disabled',true).attr("data-kt-indicator", "on")

    if( currentStep == 1 )
    {
        await tinymce.get('tinymce_description_ar').execCommand('mceSave');
        await tinymce.get('tinymce_description_en').execCommand('mceSave');
    }

    let formData = new FormData( document.getElementById('submitted-form') );
    formData.append('step',currentStep );
    formData.append('updatedColorsImages',JSON.stringify(updatedColorsImages));

    if ( isDuplicating )
        formData.append('duplicated_images', JSON.stringify(duplicatedImages) );

    $.ajax({
        url:"/dashboard/car-validate/" + carId,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:formData,
        contentType: false,
        processData: false,
        success: () => {

            removeValidationMessages();

            if ( currentStep !== totalSteps ) // not the last step
                successCallback();
            else
               successAlert().then( () =>  window.location.replace('/dashboard/cars') );

        },
        error: (response) => {

            removeValidationMessages();

            if (response.status === 422)
                displayValidationMessages(response.responseJSON.errors);
            else if (response.status === 403)
                unauthorizedAlert();
            else
                errorAlert({ time: 5000 })

            if (response.status === 422 && ( response.responseJSON.errors['other_text_ar'] || response.responseJSON.errors['other_text_en']))
                $("#price-other-modal").modal('show')

        },
        complete: () => {
            nextBtn.attr('disabled',false).removeAttr("data-kt-indicator")
        }
    });

}

let cleanImageName = ( image ) => {
    return image.replaceAll("/", "").replaceAll(".", "").replaceAll(" ", "");
}

let initializeColorsSp = () => {

    let tempArr = [];

    carColorsIds.forEach( ( id , index) => {

        tempArr.push(id);

        colorsSp.val(tempArr).trigger('change' , true);

    });
}
