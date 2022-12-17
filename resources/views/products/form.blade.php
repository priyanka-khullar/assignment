@if(isset($product))
    {{ Form::model($product, [
        'route' => ['products.update', $product->id], 'method' => 'patch','enctype' => 'multipart/form-data','id'=>'product-form']) }}
@else
    {{ Form::open(['url' => route('products.store'),
            'enctype' => 'multipart/form-data',
            'id'=>'product-form',
            'method' => 'POST'
        ]) }}
@endif
<fieldset>
        <legend>{{isset($product) ? 'Update' : 'Add'}} Product</legend>

        <div class="form-group row mb-3">
            {!! Form::label('text', 'Name:*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
        </div>

        <div class="form-group row mb-3">
            {!! Form::label('price', 'Price:*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('price', old('price'), ['class' => 'form-control']) !!}
            </div>
        </div>


        <div class="form-group row mb-3">
            {!! Form::label('description', 'Description:*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>

        <div class="form-group row mb-3">
            {!! Form::label('images', 'Images:*', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::file('images[]', ['multiple' => 'true']) !!}
            </div>
            @if(isset($product->images))
                @foreach($product->images as $image)
                    <img src='{{ asset("storage/products/images/".$image->filename) }}'
                        alt="{{ $image->filename }}" class="view-images old-images" width="70" height=70>
                @endforeach
            @endif
        </div>

        <div class="form-group row mb-3">
            <div class="col-lg-12">
                {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
            </div>
        </div>

    </fieldset>
{{ Form::close() }}


@section('script')
<script type="text/javascript">
$(document).ready(function(){
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    $( "#product-form" ).validate({
        rules: {
            name: {
                required: true
            },
            price: {
                required: true
            },
            description: {
                required: true
            },
            'images[]': {
                required: function(){
                    return !$(".old-images").length;
                }
            }
        }
    });

})
$("#product-form").submit(function(event){
    event.preventDefault();
    if ($("#product-form").valid()){
        var formData = new FormData(event.target);
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        $.ajax({
            url : url,
            data : formData,
            type : method,
            processData: false,
            contentType: false,
            success : function(response){
                if(response.type=='Success'){
                    console.log(response)
                    $.toast({
                        position: 'top-right',
                        heading: 'Success',
                        text: response.message,
                        showHideTransition: 'slide',
                        icon: 'success'
                    })
                    setTimeout(()=>{
                        location.href="{{route('products.index')}}";
                    },1500)
                }else{
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
    }
   
    return false;
});

</script>
@endsection