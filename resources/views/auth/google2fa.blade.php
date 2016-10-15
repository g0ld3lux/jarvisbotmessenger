@extends('layouts.app')

@section('css')
<style>
section {
    padding: 100px 0;
    text-align: center;
}

.input-group {
    margin: 20px auto;
    width: 100%;
}
input.btn.btn-lg,
input.btn.btn-lg:focus {
    outline: none;
    width: 60%;
    height: 60px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
button.btn {
    width: 100%;
    height: 60px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.reminder {
    color: #999;
}

</style>
@endsection

@section('content')
  <section>
  <div class="container">

  	<div class="row">
  		<div class="col-md-6 col-md-offset-3">
        @notification()
          <hgroup>
            <h2>Two Factor Authentication</h2>
           </hgroup>


               <form class="form-horizontal" role="form" method="POST" action="{{ route('auth.post2FA') }}">
              {!! csrf_field() !!}
                   <div class="input-group input-group-lg">
  <span class="input-group-addon" id="sizing-addon1">TOKEN</span>
  <input type="text" name="secret" class="form-control" placeholder="######" aria-describedby="sizing-addon1">
                  </div>
                   <button class="btn btn-info btn-lg" type="submit">Submit</button>
               </form>

           <small class="reminder"><em>If You Cant Access Your Phone Please Contact Our Support.</em></small>
  		</div>
  	</div>
  </div>
  </section>
@endsection
