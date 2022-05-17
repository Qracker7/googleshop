@extends('layouts.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Create Blog Category') }}</h4>
                </div>
                <div class="card-body">
                    <form class="basicform_with_reload" action="{{ route('seller.blog-create.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Title') }}</label>
                            <div class="col-md-12">
                                <input type="text" name="title" class="form-control" onload="convertToSlug(this.value)"
                                    onkeyup="convertToSlug(this.value)" required/>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Parent Category') }}</label>
                            <div class="col-md-12">
                                <select class="form-control selectric" name="is_child" required>
                                    <option value="0">{{ __('No') }}</option>
                                    @foreach ($blog_cats as $cat)
                                          <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Slug') }}</label>
                            <div class="col-md-12">
                                <input class="form-control" type="text" id="slug-text" name="slug" >
                            </div>
                        </div>


                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Meta Keywords') }} 
                            <span
                                    class="text-danger">Comma Separated( , )</span></label>
                            <div class="col-md-12">
                                <input class="form-control" type="text" name="meta_keywords" required>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Description') }}</label>

                            <div class="col-md-12">
                                <textarea id="summernote" name="description" required></textarea>
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
