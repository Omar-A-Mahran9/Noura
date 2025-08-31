"use strict";

// Class definition
let KTDatatable = (function () {
    let table;
    let datatable;

    // Private functions
    let initDatatable = function () {
        datatable = $("#kt_datatable").DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 500,
            order: [[2, "desc"]], // Ordering by 'Created At'
            stateSave: false,
            select: {
                style: "os",
                selector: "td:first-child",
                className: "row-selected",
            },
            ajax: {
                url: "/dashboard/courses/videos/index",
                type: "GET",
                data: function (d) {
                    let info = $("#kt_datatable").DataTable().page.info();
                    d.page = info ? info.page + 1 : 1;
                    d.per_page = info ? info.length : 10;
                },
                error: function (xhr) {
                    console.error("AJAX Error:", xhr.responseText);
                },
            },

            columns: [
                { data: "id", orderable: true },
                { data: "name", orderable: true },
                { data: "type", orderable: true },
                { data: "video_path", orderable: true },

                { data: "created_at", orderable: true },
                { data: null },
            ],

            columnDefs: [
                {
                    targets: 3, // The "video_path" column
                    data: "video_path",
                    render: function (data, type, row) {
                        if (!data) return "No Video";

                        // Extract YouTube video ID from URL
                        let videoId = "";
                        const youtubeRegex =
                            /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
                        const match = data.match(youtubeRegex);

                        if (match && match[1]) {
                            videoId = match[1];
                        } else {
                            return "Invalid YouTube URL";
                        }

                        return `
                    <iframe width="200" height="100"
        src="https://www.youtube.com/embed/${videoId}"
        frameborder="0" allowfullscreen
        style="border-radius: 10px; overflow: hidden;">
    </iframe>
                        `;
                    },
                },
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                ${__("Actions")}
                                <span class="svg-icon svg-icon-5 m-0">
                                    <i class="fa fa-angle-down mx-1"></i>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/dashboard/courses/${
                                        row.id
                                    }/edit" class="menu-link px-3 d-flex justify-content-between edit-row" >
                                       <span> ${__("Edit")} </span>
                                       <span>  <i class="fa fa-edit"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->



                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/courses/${
                                        row.id
                                    }" class="menu-link px-3 d-flex justify-content-between" target='_blank' >
                                       <span> ${__("Show")} </span>
                                       <span>  <i class="fa fa-eye text-black-50"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${
                                        row.id
                                    }" data-type="${__("videos")}">
                                       <span> ${__("Delete")} </span>
                                       <span>  <i class="fa fa-trash text-danger"></i> </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                            </div>
                            <!--end::Menu-->
                        `;
                    },
                },
            ],
            language: {
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
        });

        table = datatable.$;

        datatable.on("draw", function () {
            KTMenu.createInstances();
            handleDeleteRows();
            handleFilterDatatable();
        });
    };

    // Search function
    let handleSearchDatatable = () => {
        $("#general-search-inp").on("keyup", function () {
            datatable.search($(this).val()).draw();
        });
    };

    // Delete Row Function
    let handleDeleteRows = () => {
        $("#kt_datatable").on("click", ".delete-row", function () {
            let rowId = $(this).data("row-id");
            let type = $(this).data("type");

            deleteAlert(type).then(function (result) {
                if (result.value) {
                    loadingAlert("Deleting now ...");

                    $.ajax({
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "/dashboard/courses/videos/" + rowId,
                        success: () => {
                            successAlert(
                                `You have deleted the ${type} successfully!`
                            ).then(() => datatable.draw());
                        },
                        error: (err) => {
                            if (err.responseJSON?.message) {
                                errorAlert(err.responseJSON.message);
                            }
                        },
                    });
                } else if (result.dismiss === "cancel") {
                    errorAlert("Deletion canceled!");
                }
            });
        });
    };

    // Filter Datatable
    let handleFilterDatatable = () => {
        $(".filter-datatable-inp").on("change", function () {
            let columnIndex = $(this).data("filter-index");
            datatable.column(columnIndex).search($(this).val()).draw();
        });
    };

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
