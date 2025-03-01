let parentSectionSp = $("#section_inp");
let course_inp = $("#course_inp");

$(document).ready(() => {
    course_inp.change(function (event, selectedSectionId = null) {
        let selectedCourseId = $(this).val();

        $.ajax({
            url: `/get-course-parent-section/${selectedCourseId}`,
            method: "GET",
            success: (response) => {
                parentSectionSp.empty();

                parentSectionSp.append(`<option></option>`);

                response["sections"].forEach((model) => {
                    parentSectionSp.append(
                        `<option value="${model["id"]}" > ${model["name"]} </option>`
                    );
                });

                parentSectionSp.val(selectedSectionId);
            },
        });
    });
});
