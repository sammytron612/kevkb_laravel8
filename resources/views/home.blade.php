@extends('layouts.mainStats')

@section('content')

<div class="container-fluid">
    @if (Session::has('success'))
               <div class="alert alert-warning alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{{ Session::get('success') }}</strong>
               </div>
               <br>
           @php
               Session::forget('success');
           @endphp
    @endif

</div>
<div id="disclaimer" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Disclaimer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>I agree to the terms of this site and will not post any information deemed as
              sensitive, such as (names, individual email addresses, passwords etc..)
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"  data-dismiss="modal">Accept</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
        </div>
      </div>
    </div>
  </div>


@endsection
