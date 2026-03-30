"use strict";
var KTDatatableRemoteAjaxDemo = {
    init: function(url,columnsArray,  table_id,search_input_id) {
        localStorage.removeItem(table_id+'-1-meta');
        let t;

        t = $("#"+table_id).KTDatatable({

            data: {
                type: "remote",
                source: {
                    read: {
                        url: url,
                        map: function(t) {
                            var a = t;
                            return void 0 !== t.data && (a = t.data), a
                        },
                        params: {

						  _token: $('meta[name="token"]').attr('content')		
						}
                    }
                },

                pageSize: 10,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0
            },

            layout: {
                // scroll: !1,
                footer: !1
            },
            sortable: !0,
            pagination: !0,
            search: {
                input: $("#"+search_input_id),
                key: "generalSearch"
            },
            columns: columnsArray
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        return t;
    }
};

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(document).on('click','.delete_btn', function(event){

	event.preventDefault();
	var url             =   $(this).attr('href');
    var thisTRobject    =   $(this).closest('tr');
    var thisobj         =   $(this);
    
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You won\"t be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "<i class='fa fa-fw fa-lg fa-check-circle'></i>Yes, delete it!",
        cancelButtonText: "<i class='fa fa-fw fa-lg fa-times-circle'></i>Cancel"

    }).then(function(result) {

        // console.log(thisTRobject);
        // console.log(thisobj);

        if(thisobj.attr('data-delete') == 'soft'){

            thisTRobject.remove();
        }

        if (result.value) {

            if(url !== ''){

                window.location.href = url;

            }
        }
	});
});

function __sweetAlert(title = 'Title', type = 'success', confirmButtonText = 'OK')
{
    swal.fire({
        title: title,
        type: type,
        buttonsStyling: false,
        confirmButtonText: confirmButtonText,
        confirmButtonClass: 'btn btn-primary font-weight-bold'
    });
}

function convertToSlug(Text = '', selector = '') {

    if(!Text){
        return '';
    }

    var slug = Text.toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");

    if(!selector){
        return slug;
    }

    $(selector).val(slug);
}