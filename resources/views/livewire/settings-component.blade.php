<div class="mt-2">
    <div class="row">
        <div class="form-control-inline col-md-6">
            <input type="checkbox" wire:model="email_all"  id="emailAll">
            <label for="emailAll"><h5>Email all users when a new article is created</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-control-inline col-md-6">
            <input type="checkbox" wire:model="approve_articles" id="approve_articles">
            <label for="approve_articles"><h5>Articles created by editors need approval</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-control-inline col-md-6">
            <input type="checkbox" wire:model="allow_delete" id="allowDelete">
            <label for="allowDelete"><h5>Allow editors to delete articles</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-control-inline col-md-6">
            <input type="checkbox" wire:model="notifications" id="notifications">
            <label for="notifications"><h5>Send Notifications</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
         <div class="form-control-inline col-md-6">
            <input type="checkbox" wire:model="bts" id="bts">
            <label for="bts"><h5>BTS</h5></label>
        </div>
    </div>
    <br>
    <div class="row">
         <div class="form-control-inline col-md-6">
            <input wire:model="fulltext" type="checkbox" data-toggle="toggle" data-size="xs" id="full-text">
            <label for="full-text"><h5>Enable full text search</h5></label>
        </div>
    </div>

</div>