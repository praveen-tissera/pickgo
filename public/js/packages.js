$(document).ready(function(){
    // display package information
    $('.packageInfo').on('click', function(){
        //get the package id
        var package = $(this).attr('data-package');
        var num = $('.packageInfoModalNum');
        var weight = $('.packageInfoModalWeight');
        var ddate = $('.packageInfoModalDdate');
        var from = $('.packageInfoModalFrom');
        var to = $('.packageInfoModalTo');
        var desc = $('.packageInfoModalDecription');

        //get the package info using ajax request
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/package',
            method: 'POST',
            data: {"package" :  package },
            success: function(data){
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                var p = data['package'];

                num.text(p['num']);
                weight.text(p['weight']);
                ddate.text(new Date(p['delivers_date']).toLocaleDateString('en-US', options));
                from.text(p['from']);
                to.text(p['to']);
                desc.text(p['description']);

            }
        });
    });

    // confirm package deletion
    $('.packageDeletedBtn').on('click', function(e){
        e.preventDefault();
        var form = $('.packageDeleted');
        if(confirm('Are you sure you want to delete this package ?')){
            form.submit();
        }
    });
});