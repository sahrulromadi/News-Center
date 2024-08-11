@extends('layouts.app')

@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <ol class="breadcrumb justify-content-start mb-4">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item active text-dark">{{ $news->title }}</li>
            </ol>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <a href="#" class="h1 display-5">{{ $news->title }}</a>
                    </div>
                    <div class="position-relative rounded overflow-hidden mb-3">
                        <img src="{{ $news->image ? asset('storage/images/' . $news->image) : asset('img/noimg.jpg') }}"
                            class="img-zoomin img-fluid rounded w-100" alt="">
                        <div class="position-absolute text-white px-4 py-2 bg-primary rounded"
                            style="top: 20px; right: 20px;">
                            {{ $news->category->name }}
                        </div>
                    </div>
                    <p class="my-4">{!! $news->content !!}
                    </p>
                    <div class="tab-class">
                        <div class="d-flex justify-content-between border-bottom mb-4">
                            <ul class="nav nav-pills d-inline-flex text-center">
                                <li class="nav-item mb-3">
                                    <h5 class="mt-2 me-3 mb-0">Tags:</h5>
                                </li>
                                <li class="nav-item mb-3">
                                    <a class="d-flex py-2 bg-light rounded-pill active me-2" data-bs-toggle="pill">
                                        <span class="text-dark" style="width: 100px;">{{ $news->category->name }}</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('news.like', $news->id) }}" method="POST">
                                    @csrf
                                    @if ($news->likes->where('device_id', session('device_id'))->count())
                                        <button type="submit" class="btn btn-square">
                                            <i class="fas fa-thumbs-up text-primary"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-square">
                                            <i class="far fa-thumbs-up text-primary"></i>
                                        </button>
                                    @endif
                                </form>
                                <span class="ms-1">{{ $news->likes->count() }}</span>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active">
                                <div class="row g-4 align-items-center">
                                    <div class="col-3">
                                        <img src="{{ $news->author->image ? asset('storage/images/' . $news->author->image) : asset('img/default.jpeg') }}"
                                            class="img-fluid w-100 rounded" alt="">
                                    </div>
                                    <div class="col-9">
                                        <h3>{{ $news->author->name }}</h3>
                                        <p class="mb-0">{{ $news->author->bio }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light rounded my-4 p-4">
                        <h4 class="mb-4">You Might Also Like</h4>
                        <div class="row g-4">
                            @foreach ($randomNews as $news)
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center p-3 bg-white rounded">
                                        <img src="{{ $news->image ? asset('storage/images/' . $news->image) : asset('img/noimg.jpg') }}"
                                            class="img-fluid rounded" alt=""
                                            style="width: 100px; height: 100px; object-fit: cover;">
                                        <div class="ms-3">
                                            <a href="{{ route('news.show', $news->id) }}"
                                                class="h5 mb-2">{{ $news->title }}</a>
                                            <p class="text-dark mt-3 mb-0 me-3"><i class="fa fa-clock"></i>
                                                {{ $news->created_at->translatedFormat('d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Disqus Comment --}}
                    <div class="bg-light rounded p-4">
                        <div id="disqus_thread"></div>
                        <script>
                            /**
                             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                            /*
                            var disqus_config = function () {
                            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                            };
                            */
                            (function() { // DON'T EDIT BELOW THIS LINE
                                var d = document,
                                    s = d.createElement('script');
                                s.src = 'https://news-center-1.disqus.com/embed.js';
                                s.setAttribute('data-timestamp', +new Date());
                                (d.head || d.body).appendChild(s);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments
                                powered by Disqus.</a></noscript>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border">
                                <div class="input-group w-100 mx-auto d-flex mb-4">
                                    <input type="search" class="form-control p-3" placeholder="keywords"
                                        aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="btn btn-primary input-group-text p-3"><i
                                            class="fa fa-search text-white"></i></span>
                                </div>

                                @component('components.col-2')
                                @endcomponent

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->

    <script id="dsq-count-scr" src="//news-center-1.disqus.com/count.js" async></script>
@endsection
