$(document).ready(function(){
    $('#new-comment-form').submit(function(ev){
        ev.preventDefault();
        var form = $(this);
        $.ajax({
            'url':form.attr('action'),
            'type': 'POST',
            'data': form.serialize(),
            'success': function(response) {
                if(response.status == 'ok') {
                    $(response.html).insertAfter(form);
                    form.trigger('reset');
                    alert(response.message);
                }
                else {
                    alert('ERROR OCCURED! HERE WHAT IT SAYS: '+response.message);
                }
            }
        });
    });
});