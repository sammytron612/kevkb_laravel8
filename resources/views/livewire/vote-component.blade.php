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
                    <div class="pt-2 pb-2 pl-0" id="rateYo"></div>
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
</div>
