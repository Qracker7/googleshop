@extends('frontend.'.domain_info('user_id').'.bigbag.layouts.app')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/'.domain_info('user_id').'/bigbag/css/checkout.css') }}">
@endpush
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

@section('content')   
<section class="single-banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="single-content">
					<h2>{{ __('Checkout') }}</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{ __('Checkout') }}</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>



<form action="{{ url('/make_order') }}" class="checkout_form"  id="address-form"  method="post" autocomplete="off">
@csrf
<div class="section">
	<div class="container">

		
			<div class="row">
				<div class="col-xl-7">
					 @if(env('MULTILEVEL_CUSTOMER_REGISTER') == true)
					@if(!Auth::guard('customer')->check())
					<!-- Login -->
					<div class="bigbag_notice">
						<p>{{ __('Are you a returning customer?') }} <a href="{{ url('/user/login') }}">{{ __('Click here to login') }}</a> </p>
					</div>
					@endif
					@endif
					
					<!-- Coupon Code -->
					<div class="bigbag_notice">
						<p>{{ __('Do you have a coupon code?') }} <a href="{{ url('/cart') }}">{{ __('Click here to apply') }}</a> </p>
					</div>
					
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if(Session::has('user_limit'))
					<div class="alert alert-danger">
						<ul>
							<li>{{ Session::get('user_limit') }}</li>
						</ul>
					</div>
					@endif
					@if(Session::has('payment_fail'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						{{ Session::get('payment_fail') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
					@endif
					<!-- Buyer Info Start -->
					<h4>{{ __('Billing Details') }}</h4>
					<div class="row">
						<div class="form-group col-xl-12">
							<label>{{ __('Name') }} <span class="text-danger">*</span></label>
							<input type="text" placeholder="Full Name" name="name" class="form-control" required="" value="{{ Auth::guard('customer')->user()->name  ?? '' }}">
						</div>
						<div class="form-group col-xl-6">
							<label>{{ __('Email Address') }} <span class="text-danger">*</span></label>
							<input type="email" placeholder="Email Address" name="email" class="form-control" required="" value="{{ Auth::guard('customer')->user()->email ?? '' }}">
						</div>
						<div class="form-group col-xl-6">
							<label>{{ __('Phone Number') }} <span class="text-danger">*</span></label>
							<input type="text" placeholder="Phone Number" name="phone" class="form-control" value="" required="">
						</div>
						@if(env('MULTILEVEL_CUSTOMER_REGISTER') == true)
						@if(!Auth::guard('customer')->check())
						<div class="form-group col-xl-12">
							<label><input type="checkbox"  name="create_account" value="1" class="create_account">{{ __('With Create Account') }}</label>
						</div>
						<div class="form-group col-xl-12 password_area none">

							<label>{{ __('Password') }} <span class="text-danger">*</span></label>
							<input type="password" placeholder="Enter Password" name="password" class="form-control" value="" minlength="8">
						</div>
						@endif
						@endif
						@if(domain_info('shop_type') == 1)
						@if(count($locations) > 0)
						<div class="form-group col-xl-12">
							<label>{{ __('Courtry') }} <span class="text-danger">*</span></label>

							<select class="form-control location" name="location">
								<option selected disabled value="">{{ __('Select Location') }}</option>
								@foreach($locations as $location)
								<option value="{{ $location->id }}" data-method="{{ $location->child_relation }}">{{ $location->name }}</option>
								@endforeach

							</select>
						</div>
						@endif
						
						<div class="form-group col-xl-6">
							<label>{{ __('Delivery Address') }}  <span class="text-danger">*</span></label>
							<input type="text" placeholder="Delivery Address" name="delivery_address" class="form-control" value="" required="">
						</div>
						
						<div class="form-group col-xl-6">
							<label>{{ __('Zip Code') }}<span class="text-danger">*</span></label>
							<input type="number" placeholder="Zip Code" name="zip_code" class="form-control" value="" required="">
						</div>
						
						@endif
						<div class="form-group col-xl-12 mb-0">
							<label>{{ __('Order Notes') }}</label>
							<textarea name="comment" rows="5" class="form-control" placeholder="Order Notes (Optional)"></textarea>
						</div>
					</div>
					<!-- Buyer Info End -->

				</div>
				<div class="col-xl-5 checkout-billing">
					<!-- Order Details Start -->
					<table class="bigbag_responsive-table">
						<thead>
							<tr>
								<th>{{ __('Product') }}</th>
								<th>{{ __('Qunantity') }}</th>
								<th>{{ __('Total') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach(Cart::content() as $row)
							<tr>
								<td data-title="Product">
									<div class="bigbag_cart-product-wrapper">
										<div class="bigbag_cart-product-body">
											<h6> <a href="{{ url('/product/'.$row->name.'/'.$row->id) }}">{{ $row->name }}</a> </h6>
											@foreach ($row->options->attribute as $attribute)
                                            <p><b>{{ $attribute->attribute->name }}</b> : {{ $attribute->variation->name }}</p>
                                            @endforeach
											@foreach ($row->options->options as $op)
											<p>{{ $op->name }}</p>
                                            @endforeach
											<p>{{ $row->qty }} {{ __('Piece') }}</p>
										</div>
									</div>
								</td>
								<td data-title="Quantity">x{{ $row->qty }}</td>
								<td data-title="Total"> <strong>{{ amount_format($row->price) }}</strong> </td>
							</tr>
							@endforeach
							<tr class="total none shipping_charge">
								<td>
									<h6 class="mb-0">{{ __('Shipping Charge') }}</h6>
								</td>
								<td></td>
								<td> <strong id="shipping_charge"></strong> </td>
							</tr>
							<tr class="total">
								<td>
									<h6 class="mb-0">{{ __('Tax') }}</h6>
								</td>
								<td></td>
								<td> <strong >{{ amount_format(Cart::tax()) }}</strong> </td>
							</tr>
							<tr class="total">
								<td>
									<h6 class="mb-0">{{ __('Grand Total') }}</h6>
								</td>
								<td></td>
								<td> 
									 @if( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'dhl' && isset($array_data) )
									<strong idclass="total_cost_amount">{{ amount_format(Cart::total()+$array_data['ShippingCharge']) }}</strong> 
									

										 @elseif( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'usps' && isset($array_data) )
									<strong idclass="total_cost_amount">{{ amount_format(Cart::total()+$array_data['Postage']['Rate']) }}</strong>  
								

										 @elseif( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'ups' && isset($array_data) )
									<strong idclass="total_cost_amount">{{ amount_format(Cart::total()+$array_data['TransportationCharges']['MonetaryValue']) }}</strong>
								

									@else

									<strong idclass="total_cost_amount">{{ amount_format(Cart::total()) }}</strong>
									@endif

									 </td>
							</tr>
						</tbody>
					</table>


					<div  class="bigbag-checkout-payment ">
						<h6>{{ __('Select Shipping Mode') }}</h6>
						<hr>

						<div class="card-body">
        <form class="basicform_with_reset " action="{{ route('seller.shipping.store') }}" method="post">
          @csrf
          <div class="form-group row mb-4 w-75 m-auto">
          <div class="col-sm-4">
              <a data-toggle="modal" data-target="#ups"  class=" ups w-100 p-2 text-white btn btn-primary">UPS </a>
            </div>
         
         
      
        

        <div class="col-sm-4">
              <a data-toggle="modal" data-target="#usps"  class=" usps w-100 p-2 text-white btn btn-primary">USPS </a>
            </div>
      


         
           
            <div class="col-sm-4">
              <a data-toggle="modal" data-target="#dhl"  class=" dhl w-100 p-2 text-white btn btn-primary">DHL </a>
            </div>
          </div>

          <input hidden checked id="payment_method_101" type="radio" class="input-radio shipping_mode" name="shipping_mode" data-price="300" value="101">

        </form>


      </div>

					{{-- 	<ul class="wc_payment_methods payment_methods shipping_methods"></ul>		--}}

				    </div>

          <!-- Shipping price & days -->

          @if( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'dhl' && isset($array_data) )
				     <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >ShippingCharge: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{ $array_data['ShippingCharge'] }}$ </div> 
                </div>

                <div class="row my-2 "> 
                  <div class="col-sm-3 font-weight-bold"><p >DeliveryDate: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p> {{$array_data['DeliveryDate'] }} days  </div> 
                </div>
                @endif


                 @if( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'ups' && isset($array_data) )
                 <script type="text/javascript"> $('.ups').css({"background-color": "yellow", "font-size": "200%"});</script>
				     <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >ShippingCharge: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['TransportationCharges']['MonetaryValue']}}$  </div> 
                </div>

                <div class="row my-2 "> 
                  <div class="col-sm-3 font-weight-bold"><p >DeliveryDate: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p> {{$array_data['GuaranteedDaysToDelivery']}} days  </div> 
                </div>
                @endif


                 @if( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'usps' && isset($array_data) )
				     <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >ShippingCharge: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p> {{$array_data['Postage']['Rate']}}$  </div> 
                </div>

                <div class="row my-2 "> 
                  <div class="col-sm-3 font-weight-bold"><p >DeliveryDate: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>Not Available </div> 
                </div>
                @endif

                <!-- Shipping price & days -->


					<div id="payment" class="bigbag-checkout-payment mt-3">

						<h6>{{ __('Select Payment Mode') }}</h6>
						<hr>

						<ul class="wc_payment_methods payment_methods">
							@foreach($getways as $key => $row)
							@php
							$data=json_decode($row->content);
							@endphp
							<li class="wc_payment_method payment_method_bacs">
								<input id="payment_method_{{ $key }}" type="radio" class="input-radio" name="payment_method" value="{{ $row->category_id  }}" @if($key==0) checked="checked" @endif>
								<label for="payment_method_{{ $key }}">
								{{ $data->title }} </label>
								@if(isset($data->additional_details))
								<div class="payment_box payment_method_{{ $key }}">
									<p>{{ $data->additional_details }}</p>
								</div>
								@endif
							</li>
							@endforeach
						</ul>						
				    </div>

				@if(Cart::count() > 0)
				<button type="submit" class="bigbag_btn-custom primary btn-block mt-2 checkout_submit_btn">{{ __('Place Order') }}</button>
				@endif
				<!-- Order Details End -->				
			</div>
		</div>	
</div>
</div> 
</form>
<input type="hidden" value="{{ str_replace(',','',number_format(Cart::total(),2)) }}" id="total_amount"/>
@endsection
@push('js')
<script src="{{ asset('frontend/'.domain_info('user_id').'/bigbag/js/checkout.js') }}"></script>
@endpush

 <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initAutocomplete&libraries=places&v=weekly"
      async  >
    
 let autocomplete;
let address1Field;
let address2Field;
let postalField;

function initAutocomplete() {
  address1Field = document.querySelector("#ship-address");
  address2Field = document.querySelector("#address2");
  postalField = document.querySelector("#postcode");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocomplete = new google.maps.places.Autocomplete(address1Field, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  address1Field.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = autocomplete.getPlace();
  let address1 = "";
  let postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#locality").value = component.long_name;
        break;
      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.short_name;
        break;
      }
      case "country":
        document.querySelector("#country").value = component.long_name;
        break;
    }
  }

  address1Field.value = address1;
  postalField.value = postcode;
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2Field.focus();
}	


    </script>




                         <!-- API User input FORM Starts -->


 <!-- Hidden UPS div -->
  
  <div  class="modal fade w-100" id="ups" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
    <form class="basicform_with_resetss" action="{{url('seller/ups')}}" > @csrf
      <div class="modal-body">
        
      <div class="hidden_currency  m-auto ">

    <table class="table table-striped table-hover text-center table-borderless">
              <tbody>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">UPS Access Key: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="accessKey" value="">    </div> 
                </div>
                 </td></tr>

                  <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">UPS User Id: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="userId" value="">    </div> 
                </div>
                 </td></tr>

                  <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">UPS Password: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="password" value="">    </div> 
                </div><p class="border border-dark"> </p>
                 </td></tr>   

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Origin City: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="fromCity" value="">    </div> 
                </div>
                 </td></tr>


                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Origin Country Code: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="fromCC" value="">    </div> 
                </div>
                 </td></tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Origin Zip: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="fromPC" value="">    </div> 
                </div>
                 </td></tr>



                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Destination City: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="toCity" value="">    </div> 
                </div>
                 </td></tr>

                  <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Destination Country Code:  </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="toCC" value="">    </div> 
                </div>
                 </td></tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Destination Zip: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="toPC" value="">    </div> 
                </div>
                </td></tr>


                 <tr id=""><td> 
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Item Weight(KG): </div> 
                   <div class="col-sm-9"> 
                     <input type="number" step="any" class="form-control p-2" required="" name="pounds" value="">   </div> 
                </div>
                </td> </tr>


                 
       
        </tbody>

             
           </table>
             <input type="submit"class="btn btn-info m-auto d-block" value="Calculate" /> 
           </form>

 
  
  </div>
    
    
      </div>
    
    
      <div class="modal-footer">

       <button type="button" class="btn btn-danger p-2 close" data-dismiss="modal" aria-label="Close">
          Cancel
        </button>
       
      </div>

    </div>
  </div>
</div>
  
  <!-- Hidden UPS div -->



 <!-- Hidden USPS div -->
  
  <div  class="modal fade" id="usps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
    <form class="basicform_with_resetss" action="{{url('seller/usps')}}" > @csrf
      <div class="modal-body">
        
      <div class="hidden_currency  m-auto ">

         <table class="table table-striped table-hover text-center table-borderless">
              <tbody> 


                  <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">USPS User Id: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="username" value="">    </div> 
                </div><p class="border border-dark"> </p>
                 </td></tr>   

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Origin Zip: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="origin" value="">    </div> 
                </div>
                 </td></tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Destination Zip: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="dest" value="">    </div> 
                </div>
                </td></tr>


                 <tr id=""><td> 
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Item Pounds: </div> 
                   <div class="col-sm-9"> 
                     <input type="number" class="form-control p-2" required="" name="pounds" value="">   </div> 
                </div>
                </td> </tr>


                 <tr id="">  <td> 
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Ounces: </div> 
                   <div class="col-sm-9"> 
                    <input type="number" class="form-control p-2" required="" name="ounces" value="">    </div> 
                </div>
                </td></tr>
       
        </tbody>

             
           </table>
             <input type="submit"class="btn btn-info m-auto d-block" value="Calculate" /> 
           </form>

 
  
  </div>
    
    
      </div>
    
    
      <div class="modal-footer">

       <button type="button" class="btn btn-danger p-2 close" data-dismiss="modal" aria-label="Close">
          Cancel
        </button>
       
      </div>

    </div>
  </div>
</div>
  
  <!-- Hidden USPS div -->



   <!-- Hidden DHL div -->
  
  <div  class="modal fade" id="dhl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
    <form class="basicform_with_resetss" action="{{url('seller/dhl')}}" > @csrf
      <div class="modal-body">
        
      <div class="hidden_currency  m-auto ">

         <table class="table table-striped table-hover text-center table-borderless">
              <tbody>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Origin Country Code: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="fromCC" value="">    </div> 
                </div>
                 </td></tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Origin Zip: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="fromPC" value="">    </div> 
                </div>
                 </td></tr>


                  <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Destination Country Code:  </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="toCC" value="">    </div> 
                </div>
                 </td></tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Destination Zip: </div> 
                   <div class="col-sm-9"> 
                     <input type="text" class="form-control p-2" required="" name="toPC" value="">    </div> 
                </div>
                </td></tr>


                 <tr id=""><td> 
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Item Weight(KG): </div> 
                   <div class="col-sm-9"> 
                     <input type="number" class="form-control p-2" required="" name="pounds" value="">   </div> 
                </div>
                </td> </tr>


                 <tr id="">  <td> 
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Shipping Date: </div> 
                   <div class="col-sm-9"> 
                    <input type="date" min="@php echo date('Y-m-d'); @endphp" class="form-control p-2" required="" name="date" >    </div> 
                </div>
                </td></tr>
       
        </tbody>

             
           </table>
             <input type="submit"class="btn btn-info m-auto d-block" value="Calculate" /> 
           </form>

 
  
  </div>
    
    
      </div>
    
    
      <div class="modal-footer">

       <button type="button" class="btn btn-danger p-2 close" data-dismiss="modal" aria-label="Close">
          Cancel
        </button>
       
      </div>

    </div>
  </div>
</div>
  
  <!-- Hidden DHL div -->