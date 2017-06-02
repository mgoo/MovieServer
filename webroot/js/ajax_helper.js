/**
 * Created by mgoo on 8/01/17.
 */

/**
 * This will do an ajax call that will replace the jquery object with whatever the ajax request resonds with
 * @param url url string
 * @param data object
 * @param replace Jquery object
 */
function ajax_call_replace(url, data, replace) {
    $.ajax({
        url: url,
        data: data,
        success: function (response) {
            replace.html(response);
        },
        error: function (error, message) {
            console.log('There was an ajax error: ' + message);
        }
    });
}

function ajax_call_replace_url(contoller, action, data, replace) {
    ajax_call_replace(make_url(contoller, action), data, replace);
}

/**
 * This will do an ajax request and execute the success function when it returns successfully
 * @param url
 * @param data
 * @param success_function
 */
function ajax_call(url, data, success_function) {
    $.ajax({
        url: url,
        data: data,
        success: success_function,
        error: function (error, message) {
            console.log('There was an ajax error: ' + message);
        }
    });
}

/**
 * This will load a page by passing no data
 * @param url
 * @param load_to
 */
function load_page(url, load_to) {
    ajax_call_replace(url, '', load_to);
}

function submit_form(url, success_function) {
    var formData = new FormData($('form')[0]);
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        error: function(jqXHR, textStatus, errorMessage) {
            console.log(errorMessage);
        },
        success: success_function
    });
}
/**
 * Submits the for to a given url
 * @param url
 * @param id
 */
function submit_form_replace(url, id) {
    var success_function = function(response){
        $('#'+id).html(response);
    };
    submit_form(url, success_function);
}
/**
 * Sumits the first form that jquery finds on the page
 * @param id
 */
function submit_first_form(id) {
/*    for (var validator of validators){
        if (!validator.validate()){
            return false;
        }
    }*/
    submit_form_replace($('form').attr('action'), id);
}


