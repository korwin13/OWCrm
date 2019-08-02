<!DOCTYPE html>
<html>
<head>
	<title>Attacher</title>
</head>
<body>
 {{ @$output }}
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
    {{ Form::open(array('url' => '/att', 'method' => 'post')) }}
        {{ Form::text('url') }}
        {{ Form::text('valid') }}
        {{ Form::submit('shorten') }}
    {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
