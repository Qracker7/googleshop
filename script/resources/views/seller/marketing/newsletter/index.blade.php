@extends('layouts.app')
@section('head')
@include('layouts.partials.headersection',['title'=>'News Letter'])
@endsection
@section('content')
<div class="card">
	<div class="card-body">
			<div class="float-right">
			    	<a href="{{ route('seller.send-email') }}" class="btn btn-primary float-right">{{ __('Send Email To User') }}</a>
					<a href="{{ route('seller.newsletter') }}" class="btn btn-primary float-right">{{ __('Create News Letter') }}</a>
					
				</div>
		<br><br>
	
		<form method="post" action="{{ route('seller.customers.destroys') }}" class="basicform">
			@csrf
		
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
						    <th class="am-title">{{ __('#') }}</th>
							<th class="am-title">{{ __('Title') }}</th>
							<th class="am-title">{{ __('Description') }}</th>
							<th class="am-date">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
					     @foreach ($newsletters as $newsletter)
                                    <tr id="row{{ $newsletter->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td><img src="{{ asset($row->preview->content ?? 'uploads/default.png') }}"
                                                height="50"></td> --}}
                                       
                                        <td>{{ $newsletter->title }}</td>
                                         <td>{!! $newsletter->description !!}</td>
                                        <td>
                                            <a href="{{ route('seller.edit-newsletter', $newsletter->id)}}" class="btn btn-warning btn-sm text-center" ><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('seller.delete.newsletter_this', $newsletter->id)}}" class="btn btn-primary btn-sm text-center"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
					
					</tbody>

				
				</table>
				
			</form>

			<span>{{ __('Note') }}: <b class="text-danger">{{ __('For Better Performance Remove Unusual Users') }}</b></span>
		</div>
	</div>
</div>


@endsection
@push('js')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/success.js') }}"></script>
@endpush