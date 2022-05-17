@extends('layouts.app') 
@push('style')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('head')
@include('layouts.partials.headersection',['title'=>'Create'])
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>{{ __('Calculate Shipping Rates') }}</h4>
      </div>
      <div class="card-body">
        <form class="basicform_with_reset " action="{{ route('seller.shipping.store') }}" method="post">
          @csrf
          <div class="form-group row mb-4 w-75 m-auto">
          <div class="col-sm-4">
              <a data-toggle="modal" data-target="#ups"  class="w-100 p-3 text-white btn btn-primary">UPS </a>
            </div>
         
         
      
        

        <div class="col-sm-4">
              <a data-toggle="modal" data-target="#usps"  class="w-100 p-3 text-white btn btn-primary">USPS </a>
            </div>
      


         
           
            <div class="col-sm-4">
              <a data-toggle="modal" data-target="#dhl"  class="w-100 p-3 text-white btn btn-primary">DHL </a>
            </div>
          </div>

        </form>


      </div>
    </div>
  </div>
</div>



@if( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'ups' && isset($array_data) )
<div class="showRates"> <h4 class="bg-dark">UPS RATES</h4>

   <table class="table table-striped table-hover text-center table-borderless bg-light ">
              <tbody>  
                 
              
                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Weight: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{round($array_data['BillingWeight']['Weight']/2.20462,1)}} KG  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Transportation Charges: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['TransportationCharges']['MonetaryValue']}}$  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Guaranteed Days To Delivery: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['GuaranteedDaysToDelivery']}} Days </div> 
                </div>
                 </td>   </tr>

                

                

               
               </tbody> 
                  </table>
                  @endif



@if(Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'usps' && isset($array_data))
<div class="showRates"> <div class="showRates"> <h4 class="bg-dark">USPS RATES</h4>

   <table class="table table-striped table-hover text-center table-borderless bg-light ">
              <tbody>  
                 
              
                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Origin Zip: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['ZipOrigination']}}  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Destination Zip: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['ZipOrigination']}}  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >(Pounds,Ounces): </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>({{$array_data['Pounds']}},{{$array_data['Ounces']}})  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Service Name: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>@php $service=explode('&',$array_data['Postage']['MailService']); @endphp
                  {{$service[0]}}   </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Rate: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['Postage']['Rate']}}$ </div> 
                </div>
                 </td>   </tr>
               
               </tbody> 
                  </table> <hr> <h4 class="bg-light">Special Services</h4>



   <table class="table table-striped table-hover text-center table-borderless">
              <tbody>  
                 
                @foreach($specialService as $key => $value)
                 <tr id=""> 
                <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Service Name: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>@php $service=explode('&',$value['ServiceName']); @endphp {{$service[0]}}  </div> 
                </div>

                 </td>

                  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Rate: </div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p> {{$value['Price']}}$  </div> 
                </div>
                 </td>
                   </tr>  
                 @endforeach    
                
       
        </tbody>             
 </table> 
</div>
@endif



@if( Session::has('ratesUSPS') && Session::get('ratesUSPS') == 'dhl' && isset($array_data) )
<div class="showRates"> <h4 class="bg-dark">DHL RATES</h4>

   <table class="table table-striped table-hover text-center table-borderless bg-light ">
              <tbody>  
                 
              
                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >PickupDate: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['PickupDate']}}  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >DeliveryDate: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['DeliveryDate']}}  </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >WeightCharge: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['WeightCharge']}}$ </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >ShippingCharge: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['ShippingCharge']}}$ </div> 
                </div>
                 </td>   </tr>

                 <tr id="">  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >DimensionalWeight: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$array_data['DimensionalWeight']}}KG </div> 
                </div>
                 </td>   </tr>

                

               
               </tbody> 
                  </table> <hr> <h4 class="bg-light">Special Services</h4>



   <table class="table table-striped table-hover text-center table-borderless">
              <tbody>  
                 
                @foreach($specialService as $key => $value)
                 <tr id=""> 
                <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold"><p >Service Name: </p></div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p>{{$value['GlobalServiceName']}}  </div> 
                </div>

                 </td>

                  <td>
                 <div class="row"> 
                  <div class="col-sm-3 font-weight-bold">Rate: </div> 
                   <div class="col-sm-9"> 
                    <p class="text-center bg-info"></p> {{$value['ChargeValue']}}$  </div> 
                </div>
                 </td>
                   </tr>  
                 @endforeach    
                
       
        </tbody>             
 </table> 
</div>
@endif




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


@endsection

@push('js')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form.js') }}"></script>
@endpush