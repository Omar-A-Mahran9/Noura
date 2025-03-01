let priceFieldInp = $("#price-field-val");
let priceInp = $("#price_inp");
let discountInp = $("#discount_price_inp");
let discountdurationInp = $("#discount_duration_days_counts_inp");

let previouslySelected = [];

$(document).ready(() => {
    $("#discount-price-switch").change(function () {
        discountInp.prop("disabled", !$(this).prop("checked"));
        discountdurationInp.prop("disabled", !$(this).prop("checked"));
    });

    $(".price-filed-radio:not(#other-radio-btn)").change(function () {
        changePriceField($(this));
    });

    $("#other-radio-btn").click(function () {
        $("#price-other-modal").modal("show");
    });

    $("#price-other-text-btn").click(function () {
        let priceFieldVal = $("#other_text_" + locale.trim() + "_inp").val();
        priceFieldInp.text(priceFieldVal);
        $("#price-other-modal").modal("hide");
    });

    priceInp.keyup(() => changePriceField());

    discountInp.keyup(function () {
        if (parseInt($(this).val()) >= parseInt(priceInp.val())) {
            $(this).val("");
            warningAlert(__("Discount price must be smaller than the price"));
        }

        changePriceField();
    });

    $(document).on("click", "[id*=images_upload_btn]", function () {
        $(this).prev().trigger("click");
    });

    $(document).on("change", "[id*=_images_inp]", function () {
        let filesNumber = $(this)[0].files.length;
        $(this)
            .next()
            .html(
                `<i class="bi bi-upload fs-8" ></i> ${filesNumber} ${
                    filesNumber === 1 ? "file" : "files"
                } selected`
            );
    });
});

function changePriceField(
    element = $('input[name="price_field_status"]:checked')
) {
    if (element.val() === "show") {
        if (discountInp.val() && priceInp.val()) {
            priceFieldInp.html(
                `<span>${discountInp.val() + currency}  <del> ${
                    priceInp.val() + currency
                } </del> </span>`
            );
        } else if (priceInp.val()) {
            priceFieldInp.html(priceInp.val() + currency);
        }
    } else {
        let priceFieldVal = element.next().html();
        priceFieldInp.text(priceFieldVal);
    }
}

let validateStep = async (successCallback) => {
    nextBtn.attr("disabled", true).attr("data-kt-indicator", "on");

    if (currentStep == 3) {
        await tinymce.get("tinymce_description_ar").execCommand("mceSave");
        await tinymce.get("tinymce_description_en").execCommand("mceSave");
    }

    let formData = new FormData(document.getElementById("submitted-form"));
    formData.append("step", currentStep);

    $.ajax({
        url: "/dashboard/course-validate",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        contentType: false,
        processData: false,
        success: () => {
            removeValidationMessages();

            if (currentStep !== totalSteps)
                // not the last step
                successCallback();
            else
                successAlert().then(() =>
                    window.location.replace("/dashboard/courses")
                );
        },
        error: (response) => {
            removeValidationMessages();

            if (response.status === 422)
                displayValidationMessages(response.responseJSON.errors);
            else if (response.status === 403) unauthorizedAlert();
            else errorAlert({ time: 5000 });

            if (
                response.status === 422 &&
                (response.responseJSON.errors["other_text_ar"] ||
                    response.responseJSON.errors["other_text_en"])
            )
                $("#price-other-modal").modal("show");
        },
        complete: () => {
            nextBtn.attr("disabled", false).removeAttr("data-kt-indicator");
        },
    });
};
