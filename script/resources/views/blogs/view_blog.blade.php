@extends('layouts.app')
@section('head')
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    @php
                        $url = my_url();
                    @endphp

                    <div class="float-right mb-1">

                        <a href="{{ route('seller.new-blog-create') }}"
                            class="btn btn-primary">{{ __('Create Category') }}</a>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Parent Category') }}</th>

                                    <th>{{ __('Slug') }}</th>
                                    <th>{{ __('Meta Kewords') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blog_cats as $row)
                                    <tr id="row{{ $row->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td><img src="{{ asset($row->preview->content ?? 'uploads/default.png') }}"
                                                height="50"></td> --}}
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->is_child == 0 ? 'No' : 'Yes' }}</td>
                                        <td>{{ $row->slug }}</td>
                                        <td>{{ $row->meta_keywords }}</td>
                                        <td>
                                            <a href="{{ route('seller.blog.edit_this', $row->id) }}"
                                                class="btn btn-primary btn-sm text-center"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('seller.blog.destroy', $row->id) }}"
                                                class="btn btn-primary btn-sm text-center"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $posts->links('vendor.pagination.bootstrap-4') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>
@endpush
