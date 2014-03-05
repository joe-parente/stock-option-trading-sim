<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Please Confirm you email address to activate your account.</h2>

		<div>
			To confirm your email, click here: {{ URL::to('user/confirm', $data['cc'] }}.
		</div>
	</body>
</html>