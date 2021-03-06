@extends('web.layouts.base')
@section('title', __("News"))
@section('css')
@endsection
@section('content')
@include('web.layouts.header')
<!--========== PROMO BLOCK ==========-->
<div class="js__parallax-window" style="background: url({{ asset('assets/img/bg/06.jpg') }}) 50% 0 no-repeat fixed;">
    <div class="g-container--md g-text-center--xs g-padding-y-150--xs">
        <div class="g-margin-b-60--xs">
            <h1 class="g-font-size-40--xs g-font-size-50--sm g-font-size-70--md g-color--white g-letter-spacing--1 g-margin-b-30--xs">{{ __('News') }}</h1>
        </div>
        <a href="#js__scroll-to-section">
            <span class="s-icon s-icon--md s-icon--white-brd g-radius--circle ti-angle-double-down"></span>
        </a>
    </div>
</div>
<!--========== END PROMO BLOCK ==========-->
<div id="js__scroll-to-section" class="g-container--md g-padding-y-80--xs g-padding-y-125--sm">
    @forelse ($collectionlist as $news)
    <section>
        <h3><a href="{{ route('web:news_detail', [$news->slug]) }}">{{ $news->name }}</a> <br><small style="font-size:50%;">{{ $news->created_at->toDayDateTimeString() }}</small></h3>
        <p>{{ str_limit($news->body, 200) }}</p>
    </section>
    @empty
    <p class="text-center">{{ __('There is no data here') }}</p>
    @endforelse
    <div class="text-center">
        {!! $collectionlist->appends(['search' => request()->get('search')])->links() !!}
    </div>
</div>
@include('web.layouts.footer')
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/libs/components/faq.min.js') }}"></script>
@endsection