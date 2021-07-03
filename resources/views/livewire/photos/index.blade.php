<div>
    <div class="row justify-content-center mb-4">
        <div wire:loading>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <span class="inline-block" wire:loading.remove>

            @if ($categories->first())
                <ul class="list-group list-group-horizontal-md list-group-accent .clist-group-accent h5">
                    <li class="list-group-item">
                        <a href="#!" wire:click.prevent="all">
                            ALL
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <a href="#!" class="text-mute"
                                wire:click.prevent="selectCategory('{{ strtolower($category->category) }}')">
                                {{ strtoupper($category->category) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

            @endif

        </span>

    </div>

    @foreach ($creations as $creation)
        <div class="row justify-content-start mb-3">
            <span class="inline-block" wire:loading.remove>
                <span class="display-4">{{ $creation->title }}</span>
            </span>
        </div>
        <div class="row justify-content-start">


            @foreach ($creation->getMedia('creation') as $media)
                <div class="col-lg-4 mb-4" wire:loading.remove>
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset($media->getFullUrl()) }}" class="card-img-top  img-fluid" alt="..."
                            height="200" style="object-fit: cover;">
                        <div class="card-img-overlay">
                            {{-- <h5 class="card-title "
                                style="text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">
                                {{ $creation->title }}
                            </h5> --}}
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote text-center">
                                <p class="mb-0">{{ Str::limit($creation->title, 25, '...') }}</p>
                                <p class="text-muted text-center">{{ $creation->description }}</p>
                                <a href="{{ route('photographer.show', $creation->author->username) }}"
                                    class="stretched-link">
                                    <footer class="blockquote-footer">
                                        {{ $creation->author->name }}
                                    </footer>
                                </a>
                            </blockquote>
                        </div>



                    </div>
                </div>
            @endforeach

        </div>
    @endforeach

</div>