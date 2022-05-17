@extends('layouts.app')
@section('head')
@include('layouts.partials.headersection',['title'=>'Comments'])
@endsection
@section('content')
<div class="card">
	<div class="card-body">
			<!--<div class="float-right">-->
			<!--		<a href="{{ route('seller.blog-create') }}" class="btn btn-primary float-right">{{ __('Create Articles') }}</a>-->
			<!--	</div>-->
		<br><br>
	
		<form method="post" action="{{ route('seller.customers.destroys') }}" class="basicform">
			@csrf
		
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
						      <th class="am-title">{{ __('#') }}</th>
						    <th class="am-title">{{ __('Name') }}</th>
							<th class="am-title">{{ __('Email') }}</th>
							<th class="am-title">{{ __('Comment') }}</th>
							<th class="am-title">{{ __('Action') }}</th>
						
						</tr>
					</thead>
					<tbody>
					     @if(count($ArticleComments))
					     @foreach ($ArticleComments as $Articlecomment)
                                    <tr id="row{{ $Articlecomment->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $Articlecomment->name }}</td>
                                        <td>{{ $Articlecomment->email }}</td>
                                        <td>{{ $Articlecomment->comment  }}</td>
                    
                                        <td>
                                           
                                             <a href="{{ route('seller.blog-commentDeleted',$Articlecomment->id )}}" class="btn btn-primary btn-sm text-center"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <div class="col-md-12 " style="text-align: center">
                                  <h3 class="text-info">No Comment Found.</h3>
                                </div>
                                @endif
					    
					
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