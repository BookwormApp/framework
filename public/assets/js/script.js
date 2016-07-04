$(function(){

    $('table').on('click', 'tr[data-href] td', function()
    {
        if ( ! $(this).hasClass('links') ) {
            var url = $(this).closest('tr').data('href');
            window.location.href = url;
        }
    });

    $('form.sort select').change(function()
    {
        var select = $(this);
        var form = select.closest('form');

        form[0].submit();
    });

    $('[data-submit]').on('click', function(e) {
        var button = $(this);
        var form = button.closest('form');

        var label = button.data('submit') || 'Saving';

        button.addClass('disabled').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> ' + label);

        form[0].submit();
    });

    $('input[data-confirm-action], button[data-confirm-action]').on('click', function(e) {
        var button = $(this);
        var form = button.closest('form');

        var title = button.data('confirmAction');

        e.preventDefault();
        bootbox.confirm('Are you sure you want to '+title+'?', function(result){
            if ( result ) {
                form.submit();
            }
        });

        return false;
    });

    $('input[data-confirm-delete], button[data-confirm-delete]').on('click', function(e) {
        var button = $(this);
        var form = button.closest('form');

        var title = button.data('confirmDelete');

        e.preventDefault();
        bootbox.confirm('Are you sure you want to delete '+title+'?', function(result){
            if ( result ) {
                form.submit();
            }
        });

        return false;
    });

    $('.form-control-date').datepicker({
        format: 'yyyy-mm-dd'
    });

});
