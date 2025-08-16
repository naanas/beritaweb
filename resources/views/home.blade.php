@extends('layouts.app') {{-- Pastikan Anda menggunakan layout master yang benar --}}

@section('content')
    <div class="container">
        <h1>Selamat Datang di BeritaWeb</h1>

        {{-- Debugging: Pastikan variabel posts ada --}}
        {{-- {{ dd($posts) }} --}}

        @if ($posts->isEmpty())
            <p>Belum ada berita atau artikel yang dipublikasikan.</p>
        @else
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection