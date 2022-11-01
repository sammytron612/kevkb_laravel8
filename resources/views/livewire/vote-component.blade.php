<div>
    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row">
        <div class="form-group col-12">
            <div>Helpful?&nbsp&nbsp<button {{ $enabled ? '' : 'disabled'}}  id="yes" wire:click='voteYes' class="vote btn btn-success btn-sm">Yes</button>
                <button {{ $enabled ? '' : 'disabled'}} id="no" wire:clicl='voteNo' class="vote btn btn-warning btn-sm">no</button>&nbsp
                {{ $pct }}%&nbsp Found this article helpful
                <div class="d-flex justify-content-center">
                    <div  id="spinner1" style="display:none" class="spinner-border text-primary" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    <div x-data="{ open: @entangle('show').defer }" style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row">
        <div class="form-group col-12">
            <h4 for="comment">Suggest an improvement</h4>
            <div x-show="open">
                <form wire:submit.prevent>
                    <h5>Comment</h5>
                    <textarea class="form-control w-100" wire:model.defer="comment" name="comment" id="comment" required></textarea>
                    <h5 class="mt-3">Name</h5>
                    <input type="text" wire:model.defer="name" placeholder="Name" class="form-control" required>
                    <div wire:ignore id="rating" class="py-4">
                        <h5 class="font-bold">Rating</h5>
                        <div style="cursor:pointer">
                            <span id="star-1" @mouseover="starHover(1)"  x-on:click="clickStar(1)"><i class="text-warning fa fa-star-o"></i></span>
                            <span id="star-2" @mouseover="starHover(2)" x-on:click="clickStar(2)"><i class="text-warning fa fa-star-o"></i></span>
                            <span id="star-3" @mouseover="starHover(3)" x-on:click="clickStar(3)"><i class="text-warning fa fa-star-o"></i></span>
                            <span id="star-4" @mouseover="starHover(4)" x-on:click="clickStar(4)"><i class="text-warning fa fa-star-o"></i></span>
                            <span id="star-5" @mouseenter="starHover(5)" x-on:click="clickStar(5)"><i class="text-warning fa fa-star-o"></i></span>
                        </div>
                    </div>
                    <button wire:click="submit" class="mt-1 btn btn-primary">Submit</button>
                </form>
                
            </div>
            <button x-show="open == false" x-on:click="open = ! open" class="btn btn-primary">Create a Comment</button>
        </div>
    </div>

    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row mt-2">
        <div  class="form-group col-12">
            <label for="comment"><h4>Comments</h4></label>
            <div class="w-100">
                @foreach($comments as $comment)
                <div style="display:flex">
                    <div style="flex1"><b>{{ $comment->userid ? $comment->users->name : $comment->name}}</b> - {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}&nbsp-&nbsp</div>
                    <div style="" class='text-warning rating' data-rate-value='{{ $article->rating }}'></div>
                </div>
                @if($comment->comment)
                <i>"{{ $comment->comment }}"</i>
                @endif
                <br>
                <br>
                @endforeach
            </div>
        </div>
    </div>
    <x-toast/>
   
    <script>
       function starHover(e)
       {
        //for (let i = 1; i < e+1; i++) {
          //  document.getElementById("star-"+i).innerHTML = "<i class='text-warning fa fa-star'></i>";
        //}
       }

       function clickStar(e)
       {
        @this.set('rating',e);
        for (let i = 1; i < 6; i++) {
            document.getElementById("star-"+i).innerHTML = "<i class='text-warning fa fa-star-o'></i>";
        }
        
        for (let i = 1; i < e+1; i++) {
            document.getElementById("star-"+i).innerHTML = "<i class='text-warning fa fa-star'></i>";
        }
        //document.getElementById("star"+e).innerHTML = "<i class='text-warning fa fa-star'></i>";
       }

       function leave(e)
       {

       }

   </script> 
</div>
