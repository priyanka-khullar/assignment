<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-{{ $type }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $message }}</p>

                @if(isset($warning))
                    <p class="text-{{ $type }}"><strong>{{ $warning }}</strong></p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="ajax-submit-{{ $modalId }} btn btn-{{ $type }}" id="{{$id}}" method="delete" action="{{$action}}" >
                    Yes
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).on('click','.ajax-submit-{{ $modalId }}',function(event){
    event.preventDefault();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var id = $(this).attr('id');
    $.ajax({
        url : url,
        type : method,
        success : function(response){
            if(response.type=='Success'){
                $('.item-row-'+id).remove();
                $('{{ $modalId }}').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                $.toast({
                    position: 'top-right',
                    heading: 'Success',
                    text: response.message,
                    showHideTransition: 'slide',
                    icon: 'success'
                });

            } else{
                $.toast({
                    position: 'top-right',
                    heading: 'Error',
                    text: response.message,
                    showHideTransition: 'slide',
                    icon: 'success'
                })
            }
        }, error: function(xhr, status, error) {
            $.toast({
                position: 'top-right',
                heading: 'Error',
                text: xhr.responseJSON.message,
                showHideTransition: 'slide',
                icon: 'error'
            });
        }
    });
   
    return false;
});

</script>
