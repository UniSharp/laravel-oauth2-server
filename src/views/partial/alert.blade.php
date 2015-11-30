@if (session('status'))
<div class="alert alert-success" style="text-align:center">
	{{ session('status') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger" style="text-align:center">
	{{ session('error') }}
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
