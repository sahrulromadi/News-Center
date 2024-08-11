$(document).ready(function() {
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

    // Submit Button
    $('#submitButton').on('click', function(event) {
        event.preventDefault();

        var form = $(this).closest('form');
        var formData = new FormData(form[0]);

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

   // Reject Button
    $(document).on('click', '#rejectButton', function(event) {
    event.preventDefault();

    var form = $(this).closest('form');
    var formData = new FormData(form[0]);

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        confirmButtonText: 'Yes, reject it!',
        showCancelButton: true,
        cancelButtonText: 'No, cancel',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger mx-1',
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
    
    // Edit Submit Button
    $(document).on('submit', 'form#editForm', function(event) {
        event.preventDefault();
    
        var form = $(this);
        var formData = new FormData(form[0]);
    
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, cancel',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success mx-1',
                cancelButton: 'btn btn-secondary mx-1'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
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
            }
        });
    });
    
    // Discard Button
    $('#discardButton').on('click', function(event) {
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

    // Delete Button
    $(document).on('submit', '#deleteButton', function(event) {
        event.preventDefault();
    
        var form = this; 
        var id = $(form).data('id'); 
    
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success mx-1',
                cancelButton: 'btn btn-danger mx-1'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(form).attr('action'), 
                    method: 'POST',
                    data: $(form).serialize(),
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
            }
        });
    });    

    // Login Button
    $('#loginButton').on('click', function(event) {
        event.preventDefault();

        var form = $(this).closest('form');
        var formData = new FormData(form[0]);

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
    });
});