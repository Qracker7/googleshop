@extends('layouts.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit Blog Articles') }}</h4>
                </div>
                <div class="card-body">
                    <form class="basicform_with_reload" action="{{ route('seller.blog-article.updatess') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Title') }}</label>
                            <div class="col-md-12">
                                <input type="text" name="title" class="form-control" value="{{ $articles->title }}" onload="convertToSlug(this.value)"
                                    onkeyup="convertToSlug(this.value)" required/>
                                 <input type="hidden" name="id" class="form-control" value="{{ $articles->id }}" required>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Category') }}</label>
                            <div class="col-md-12">
                                <select class="form-control selectric" name="category_id" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                      @foreach ($blog_articles as $article)
                                         <option value="{{ $article->id }}" {{ $article->id == $articles->category_id ? 'selected' : ''}}>{{ $article->title }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                          <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Slug') }}</label>
                            <div class="col-md-12">
                                <input class="form-control" type="text" id="slug-text" name="slug" value="{{ $articles->slug }}" required>
                            </div>
                        </div>
                       <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Tag') }}
                               
                            <span
                                    class="text-danger">Comma Separated( , )</span></label>
                            <div class="col-md-12">
                                <input class="form-control" type="text"  name="tag" value="{{ $articles->tags }}" required>
                            </div>
                        </div>


                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('comments') }}
                                </label>
                            <div class="col-md-12">
                                 <select class="form-control selectric" name="comments" required>
                                      <option value="1" {{ $articles->is_comment == 1 ? 'selected' : '' }}>{{ __('Enable') }}</option>
                                      <option value="0" {{ $articles->is_comment == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
                                </select>
                            </div>
                        </div>
                        
                          <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Image') }}</label>
                            <div class="col-md-12">
                                <input class="form-control" type="file"  name="image">
                            </div>
                        </div>
                         <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Existing Picture') }}</label>
                            <div class="col-md-12">
                               <img src="{{ asset($articles->image) }}" class="" height="150" alt="">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-form-label col-12">{{ __('Description') }}</label>

                            <div class="col-md-12">
                                <textarea id="summernote" name="description" required>{{ $articles->description }}</textarea>
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
