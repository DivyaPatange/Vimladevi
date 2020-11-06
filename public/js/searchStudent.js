// $(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#BT_no').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"studentBTCard",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'BT_no':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#student_name').html(data);
            }
        })
        // end of ajax call
    });
// })