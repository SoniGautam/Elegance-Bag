@extends('layouts.front')

 @section('title')
    My Cart
 @endsection
 
 @section('content')
 <div class="py-3 mb-4 shadow-sm" style="background-color: #e093a0;">
    <div class="container">
       <h6 class="mb-0">
           <a href="{{ url('/') }}">
           Home
           </a> /
           <a href="{{ url('cart') }}" style="background-color: #e28a99;" >
             Cart
           </a> 
           
       </h6>
    </div>
   </div>
   
     
 <div class="container my-5">
    <div class="card shadow ">
        <div class="card-body">
            @php $total = 0; @endphp
            @foreach ($cartitems as $item)
            <div class="row product_data">
                <div class="col-md-2">
                    <img src="{{ asset('assets/uploads/products/'.$item->products->image)}}" height="100px" width="100px"alt="Image here">
                </div>
                <div class="col-md-5">
                    <h5> Rs {{ $item->products->selling_price }}</h5>
                </div>
                <div class="col-md-3">
                    <input type="hidden" class="prod_id" value=""{{ $item->prod_id}}>
                    <label for="Quantity">Quantity</label>
                                <div class="input-group text-center mb-3" style="width:130px;">
                                    <button class="input-group-text changeQuantity decrement-btn">-</button>
                                     <input type="text" name="quantity"  class="form-control qty-input text-center" value="{{ $item->prod_qty}}">
                                     <button class="input-group-text changeQuantity increment-btn">+</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger delete-cart-item"style="background-color: #e093a0;"data-product-id="{{ $item->prod_id }}" >
                                     <i class="fas fa-trash"></i> Remove</button>
                                
                            </div>
                        </div>
                        @php $total += $item->products->selling_price * $item->prod_qty ; @endphp
                        @endforeach
                    </div>
                    <div class="card-footer">
                    <h5>Total Price : Rs {{ $total }}</h5>
                    <a href="{{ url('checkout') }}" class="btn btn-outline-success float-end">Proceed to Checkout</a>
                </div>
                </div>
            </div>


 @endsection
 @section('scripts')
<script>
    $(document).ready(function() {
        $('.addToCartBtn').click(function(e) {
            // Your existing code for adding to cart...

        });

        $('.increment-btn').click(function(e) {
            // Your existing code for incrementing quantity...

        });

        $('.decrement-btn').click(function(e) {
            // Your existing code for decrementing quantity...

        });

        $('.delete-cart-item').click(function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var prod_id = $(this).data('product-id');

            $.ajax({
                method: "POST",
                url: "/delete-cart-item",
                data: {
                    'prod_id': prod_id,
                },

                success: function(response) {
                    window.location.reload();
                    swal("", response.status, "success");
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection