@extends('layouts.app')
@section('head')
@include('layouts.partials.headersection',['title'=>'Abandoned Cart'])
@endsection
@section('content')
<div class="card">
	<div class="card-body">
            <form method="post" action="{{ route('seller.abandoned_cart.email')}}" method="post" class="basicform_with_reload">
			@csrf
				    <div class="row">
	        <div class="col-12 text-right">
	            <button class="btn btn-primary" type="submit">
                    {{ __('Send Email') }}
                </button>
	        </div>
	    </div>
			<div class="table-responsive custom-table mt-1">
				<table class="table">
					<thead>
						<tr>
						    <th class="am-title">
						        <input type="checkbox" id="selectAll" class="css-checkbox" name="selectAll"/>
						    </th>
						    <th class="am-title">{{ __('User') }}</th>
							<th class="am-title">{{ __('IP & Browser') }}</th>
							<th class="am-title">{{ __('Products') }}</th>
							<th class="am-date">{{ __('Date') }}</th>
							<th class="am-title">{{ __('Total Amounts') }}</th>
							<th class="am-title">-</th>
						</tr>
					</thead>
					<tbody>
						@foreach($carts as $row)
						<tr>
						    <td>
						        @if ($row->customer_id)
						        <input type="checkbox" class="checkboxAll" name="emails[]" value="{{$row->customer->email}}"/>
						        @endif
						    </td>
						    <td>{{ $row->customer_id ? $row->customer->email : 'Guest' }}</td>
							<td>
							    <div>{{ $row->ip }}</div>
							    <div>{{ $row->browser }}</div>
							</td>
							<td>
							    @php
							    $content = json_decode($row->content);
							    @endphp
								@foreach($content as $product)
								<a href="{{ domain_info('full_domain').'/product/'.$product->options->slug.'/'.$product->id }}">{{ $product->name }}</a>
								@endforeach
							</td>
							<td>{{ $row->updated_at }}</td>
							<td>
							    @php
								$total = 0;
								foreach($content as $product) {
									$total += $product->subtotal;
								}
								@endphp
								{{ $total }}
							</td>
							<td>
							    <button class="btn btn-primary">View More</button>
							</td>
						</tr>
						@endforeach
					</tbody>

					<tfoot>
						<tr>
						    <th></th>
							<th class="am-title">{{ __('User') }}</th>
							<th class="am-title">{{ __('IP & Browser') }}</th>
							<th class="am-title">{{ __('Products') }}</th>
							<th class="am-date">{{ __('Date') }}</th>
							<th class="am-title">{{ __('Total Amounts') }}</th>
						    <th class="am-title">-</th>
						</tr>
					</tfoot>
				</table>
			</form>
		</div>
	</div>
</div>

@endsection
@push('js')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#selectAll").click(function(){
            if(this.checked){
                $('.checkboxAll').each(function(){
                    $(".checkboxAll").prop('checked', true);
                })
            }else{
                $('.checkboxAll').each(function(){
                    $(".checkboxAll").prop('checked', false);
                })
            }
        });
    });
</script>
@endpush