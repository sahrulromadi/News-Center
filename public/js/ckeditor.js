import {
    ClassicEditor,
    Essentials,
    Bold,
    Italic,
    Font,
    Paragraph
} from 'ckeditor5';

let editor; 
let previousEditorContent;

ClassicEditor
    .create(document.querySelector('#editor'), {
        plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
        toolbar: {
            items: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        }
    })
    .then(ed => {
        editor = ed; 
        console.log('CKEditor initialized', editor);

        previousEditorContent = editor.getData();

        $('#CKsubmitButton').on('click', function(event) {
            event.preventDefault();

            var form = $(this).closest('form');
            var formData = new FormData(form[0]);

            var editorData = editor.getData();
            formData.set('content', editorData);    

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                confirmButtonText: 'Yes, submit it!',
                showCancelButton: true,
                cancelButtonText: 'No, cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success mx-1',
                    cancelButton: 'btn btn-secondary mx-1'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message, response.redirect_url);
                            } else {
                                showAlert('error', response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON.message || 'Error';
                            showAlert('error', errorMessage);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // 
                }
            });
        });

    })
    .catch(error => {
        console.error('Error initializing CKEditor:', error);
    });

$('#CKdiscardButton').on('click', function(event) {
    event.preventDefault();
    var form = $(this).closest('form');
    showDiscardConfirmation(form);
});

function showDiscardConfirmation(form) {
    Swal.fire({
        title: 'Discard changes?',
        text: 'Are you sure you want to discard all changes?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, discard it',
        cancelButtonText: 'No, cancel',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger mx-1',
            cancelButton: 'btn btn-secondary mx-1'
        },
        reverseButtons: true
    }).then((discardResult) => {
        if (discardResult.isConfirmed) {
            form.trigger('reset');
            var inputFile = form.find('input[type="file"]');
            var imagePreview = $('#imagePreview');
            inputFile.val(''); 
            imagePreview.attr('src', '');
            imagePreview.hide();
            editor.setData(previousEditorContent);

            Swal.fire({
                title: 'Changes discarded',
                text: '',
                icon: 'info',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info',
                },
            });
        }
    });
}

function showAlert(type, message, redirectUrl = null) {
    Swal.fire({
        icon: type,
        title: type === 'success' ? 'Success' : 'Error',
        text: message,
        buttonsStyling: false,
        customClass: {
            confirmButton: type === 'success' ? 'btn btn-success' : 'btn btn-danger',
        },
    }).then((result) => {
        if (result.isConfirmed && type === 'success' && redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}
