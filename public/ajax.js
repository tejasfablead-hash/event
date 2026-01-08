function reusableAjaxCall(url, method, data, successCallback, errorCallback) {
      $.ajax({
        url: url,
        method: method,
        data: data,
        contentType: false,
        processData: false,
        dataTye:'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
         
        success: function (response) {
            if (successCallback) successCallback(response);
        },
        error: function (xhr, status, error) {
            $(".error").empty();
            if (errorCallback) errorCallback(xhr, status, error);
                    if (xhr.status === 422) {
                        $(".error").addClass("text-danger");
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + '_error').text(value);
                        });
                    }
        }
    });
}
