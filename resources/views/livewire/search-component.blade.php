<div class="container-fluid p-5">
    <div class="row mt-2 mx-auto">
        <div class="input-group offset-3 col-md-6">
        <input type="search" wire:model.debounce.500ms="search" placeholder="Search a solution" id="search" class="form-control h3 py-2 search-input w-50 border-right-0 border"> <span class="input-group-append"><button class="btn btn-secondary border-left-0 border"><i class="fa fa-search"></i></button></span>
        </div>
    </div>


    @if(count($articles))
        <div class="mt-5 p-5 bg-white">
            @foreach($articles as $article)
                <div class="mt-3">
                    <a class="h5 text-primary" href="{{route('articles.show', $article->id)}}">{{$article->title}}</a>-
                    @if(Auth::user()->role == "admin")
                        <a onclick="remove({{$article->id}})" type="button" class="btn btn-danger px-1 py-0 btn-sm"><i class="text-white fa fa-trash"></i></a>
                    @endif
                    @if(Auth::user()->role != 'viewer')
                        <a href="{{route('alter.alter', $article->id)}}" class="btn btn-primary px-1 py-0 btn-sm" wire:click="editArticle({{$article->id}})"><i class="fa fa-edit"></i></a>
                    @endif
                    <span class="text-warning rating" data-rate-value="{{$article->rating}}"></span>
                    <div>
                        <span class="fa fa-user mr-1">&nbspAuthored by&nbsp{{ $article->author_name }} - </span>
                        <span class="fa fa-eye mr-1">&nbspViews&nbsp{{ $article->views }} - </span>
                        <span class='fa fa-calendar mr-1'>&nbsp{{ $article->created_at }}</span>&nbsp-&nbsp
                        <span>{{ $article->kb }}</span>
                        <div class="text-warning rating bg-white h5" data-rate-value="{{$article->rating}}"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @if($search != "")
            <div id="nothing" class="bg-white border p-5 mt-5">
                <h2 class="text-center">No Results</h2>
                <p>Your search did not match any documents</p>
                <p>Suggestions</p>
                <ul>
                    <li>Make sure all words are spelled correctly</li>
                    <li>Try different, more general, or fewer keywords</li>
                </ul>
            </div>
        @endif
    @endif

    <x-toast/>
    <script>
        $(document).ready(function(){

        var options = {
        max_value: 5,
        step_size: 0.5,
        readonly: true,
        }
        $(".rating").rate(options);
        
        });
    
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
