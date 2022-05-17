@extends('layouts.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Blog Setting') }}</h4>
                </div>
                @if (is_null(DB::table('blog_settings')->where('user_id',seller_id())->first()))
                <div class="card-body">
                    <p class="text-center text-danger">No article available For Blog Setting First create Article.<br><a href="{{route('seller.blog-create')}}" class="text-center text-success">Create article ?</a></p>
                    
                </div>
                @else
                    <div class="card-body">
                    <form class="basicform_with_reload" action="{{ route('seller.blog-article.update')}}" method="POST"
                        enctype="multipart/form-data">
                         @csrf
                       @method('PUT')
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Article Per Page') }}</label>
                            <div class="col-md-12">
                                <input type="number" name="articleperpage" class="form-control" value="{{ $blog_setting->articles_per_page}}" min="1" max="50" step = "1"   
                                / required>
                            </div>
                        </div>
                       
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Comments') }}
                                </label>
                            <div class="col-md-12">
                                 <select class="form-control selectric" name="comments" required>
                                       <option value="enable" {{ $blog_setting->comments == 'enable'  ? 'selected' : '' }}>{{ __('Enable') }}</option>
                                      <option value="disable" {{ $blog_setting->comments == 'disable' ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                   
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12"></label>
                            <div class="col-md-12">
                                <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/form.js') }}"></script>

    <script>
        function convertToSlug(str) {

            //replace all special characters | symbols with a space
            str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                .toLowerCase();

            // trim spaces at start and end of string
            str = str.replace(/^\s+|\s+$/gm, '');

            // replace space with dash/hyphen
            str = str.replace(/\s+/g, '-');
            document.getElementById("slug-text").value = str;
            //return str;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endpush