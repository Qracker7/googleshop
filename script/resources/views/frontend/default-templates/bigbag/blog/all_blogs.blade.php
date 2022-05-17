@extends('frontend.'.domain_info('user_id').'.bigbag.layouts.app')

@section('content')
    <style type="text/css">
        .my-active span {
            background-color: #5cb85c !important;
            color: white !important;
            border-color: #5cb85c !important;
            border-radius: 12px !important;
            background-color: #04AA6D;
            border: none !important;
            padding: 8px !important;
            text-align: center !important;
            text-decoration: none !important;
            display: inline-block !important;
            font-size: 16px !important;
            margin: 4px 2px !important;
        }

        li {

            display: inline !important;
            ;
            list-style-type: none !important;
            ;
            padding-right: 20px !important;
            ;
            float: left !important;
            ;
        }

    </style>
    <section class="single-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-content">
                        <h2>Blogs</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">{{ $info->slug }}</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-list">
        <div class="container">
            <div class="container">
                <div class="row">
                    @forelse ($articles as $article)
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pb-4 mx-auto">
                            <div class="card shadow">
                                <img src="{{ asset($article->image) }}" class="card-img-top" alt="..." width="100%"
                                    style="height:215px">
                                <div class="card-body">
                                    <h2 class="card-title">{{ $article->title }}</h2>
                                    <p class="card-text">{!! strlen($article->description) > 50 ? substr($article->description, 0, 50) . '...' : $article->description !!}</p>
                                </div>
                                <div class="card-body card-p">
                                    <div class="row">
                                        <div class="col col-xs-6 ">
                                            <i class="far fa-comments"></i> {{ count($article->comments) }}
                                        </div>
                                        <a href="/blogs/{{ $article->slug }}">
                                            <div class="col col-xs-6 text-success float-right">
                                                <i class="far fa-eye"></i> Read More
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                    @endforelse
                </div>
                <div class="d-flex justify-content-center">
                    {!! $articles->links('frontend.'.domain_info('user_id').'.bigbag.blog.custom_pagination') !!}
                </div>
            </div>
        </div>
    </section>
@endsection
