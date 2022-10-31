<div class="container bg-white p-5">
    <div>
        <input class="form-control" type="search" wire:model='search'>
    </div>


    @if(count($articles))
        <div class="mt-5">
            @foreach($articles as $article)
                <div class="mt-3">
                    <a class="h5 text-primary" href="{{route('articles.show', $article->id)}}">{{$article->title}}</a>
                    @if(Auth::user()->role == "admin")
                        <a onclick="remove({{$article->id}})" type="button" class="btn btn-danger px-1 py-0 btn-sm"><i class="text-white fa fa-trash"></i></a>
                    @endif
                    @if(Auth::user()->role != 'viewer')
                        <a href="{{route('alter.alter', $article->id)}}" class="btn btn-primary px-1 py-0 btn-sm" wire:click="editArticle({{$article->id}})"><i class="fa fa-edit"></i></a>
                    @endif
                    <div>
                        <span class="fa fa-user mr-1">&nbspAuthored by&nbsp{{ $article->author_name }} - </span>
                        <span class="fa fa-eye mr-1">&nbspViews&nbsp{{ $article->views }} - </span>
                        <span class='fa fa-calendar mr-1'>&nbsp{{ $article->created_at }}</span>&nbsp-&nbsp
                        <span>{{ $article->kb }}</span>
                        <div id="rating" data-rate-value="{{$article->rating}}"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <x-toast/>
    <script>
    
        function remove(e)
            {
            Swal.fire({
                showClass: {
                popup: 'animate__animated animate__fadeInDown'
                },
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                
                @this.call('deleteArticle',e)
            } else {return}
            })
    
        }
    </script>
</div>
