<div>
    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row">
        <div class="form-group col-12">
            <div>Helpful?&nbsp&nbsp<button id="yes" wire:clicl='voteYes' class="vote btn btn-success btn-sm">Yes</button>
                <button id="no" wire:clicl='voteNo' class="vote btn btn-warning btn-sm">no</button>&nbsp
                {{ $pct }}%&nbsp Found this article helpful
                <div class="d-flex justify-content-center">
                    <div  id="spinner1" style="display:none" class="spinner-border text-primary" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row">
        <div class="form-group col-12">
            <h5 for="comment">Suggest an improvement</h5>
            <textarea class="form-control w-100" wire:model.defer="comment" name="comment" id="comment"></textarea>
            Please rate this article
            <div class="d-flex justify-content-center">
                <div  id="spinner" style="display:none" class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
             </div>
            <div class="pt-2 pb-2 pl-0" id="rateYo"></div>
            <button wire:click='submit' type="text" class="mt-1 btn btn-primary">Submit</button>
        </div>

    </div>
</div>
