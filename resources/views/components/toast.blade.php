<div  class="fixed-top" id="update-success" x-cloak x-data="{open: false}" @update-success.window="open = true, setTimeout(() => open = false, 4000)">
    <div x-show="open" style="width:180px !important" class="mt-3 mr-3 float-right">
        <div class="shadow d-flex justify-content-between border-success bg-success text-white p-3 text-success h6" x-show="open">
            <span class="text-white">Success</span><i class="text-white fa fa-check" aria-hidden="true"></i>
        </div>
    </div>
</div>