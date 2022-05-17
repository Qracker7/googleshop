@extends('layouts.app')
@section('head')
@include('layouts.partials.headersection',['title'=>'Articles'])
@endsection
@section('content')
<div class="card">
	<div class="card-body">
			<div class="float-right">
					<a href="{{ route('seller.blog-create') }}" class="btn btn-primary float-right">{{ __('Create Articles') }}</a>
				</div>
		<br><br>
	
		<form method="post" action="{{ route('seller.customers.destroys') }}" class="basicform">
			@csrf
		
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
						    <th class="am-title">{{ __('#') }}</th>
						    <th class="am-title">{{ __('Image') }}</th>
							<th class="am-title">{{ __('Title') }}</th>
							<th class="am-title">{{ __('Description') }}</th>
							<th class="am-title">{{ __('tags') }}</th>
							<th class="am-date">{{ __(' Comment') }}</th>
								<th class="am-date">{{ __(' Total Views') }}</th>
							<th class="am-date">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
					     @foreach ($articles as $article)
                                    <tr id="row{{ $article->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td><img src="{{ asset($row->preview->content ?? 'uploads/default.png') }}"
                                                height="50"></td> --}}
                                        <td>  
                                         <img src="{{ asset($article->image) }}" style="border-radius: 50%" width="50px" height="50px" alt="image">
                                        </td>
                                        <td>{{ $article->title }}</td>
                                         <td>{!! $article->description !!}</td>
                                        <td>{{ $article->tags }}</td>
                                        <td>
                                             @if($article->is_comment == 1)
                                            <span class="badge badge-info">Enable</span>
                                            @else
                                            <span class="badge badge-warning">Disable</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $article->views}}
                                        </td>
                                
                                        <td>
                                            <a href="{{ route('seller.blog-article.edit',$article->id)}}" class="btn btn-warning btn-sm text-center" ><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('seller.blog-article.destroy', $article->id)}}" class="btn btn-primary btn-sm text-center"><i
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