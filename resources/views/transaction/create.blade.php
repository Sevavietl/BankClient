@extends('layout.main')

@section('head')
@parent

<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('js/create-transaction.js') }}"></script>
@stop

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			New Transaction
		</div>

		<div class="panel-body">
			{!! Form::open(['url' => 'transaction', 'method' => 'post', 'class' => 'form-horizontal']) !!}
				<div class="form-group">
					{!!
						Form::label(
							'first_name',
							'First Name:',
							[
								'class' => 'col-sm-2 control-label required',
							]
						)
					!!}
					<div class="col-sm-8">
						{!!
							Form::text(
								'first_name',
								old('first_name'),
								[
									'class' => 'form-control ',
									'placeholder' => 'First Name',
								]
							)
						!!}
						@if($errors->first('first_name'))
							<span class="error">{{ $errors->first('first_name', ':message') }}</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					{!!
						Form::label(
							'last_name',
							'Last Name:',
							[
								'class' => 'col-sm-2 control-label required',
							]
						)
					!!}
					<div class="col-sm-8">
						{!!
							Form::text(
								'last_name',
								old('last_name'),
								[
									'class' => 'form-control',
									'placeholder' => 'Last Name',
								]
							)
						!!}
						@if($errors->first('last_name'))
							<span class="error">{{ $errors->first('last_name', ':message') }}</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					{!!
						Form::label(
							'card_number',
							'Card Number:',
							[
								'class' => 'col-sm-2 control-label required',
							]
						)
					!!}
					<div class="col-sm-8">
						{!!
							Form::text(
								'card_number',
								old('card_number'),
								[
									'class' => 'form-control',
									'placeholder' => 'Card Number',
								]
							)
						!!}
						@if($errors->first('card_number'))
							<span class="error">{{ $errors->first('card_number', ':message') }}</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					{!!
						Form::label(
							'card_expiration',
							'Card Expiration:',
							[
								'class' => 'col-sm-2 control-label required',
							]
						)
					!!}
					<div class="col-sm-8">
						<div class="input-group">
							{!!
								Form::text(
									'card_expiration',
									old('card_expiration'),
									[
										'class' => 'form-control',
										'placeholder' => 'Card Expiration',
									]
								)
							!!}
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
						@if($errors->first('card_expiration'))
							<span class="error">{{ $errors->first('card_expiration', ':message') }}</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					{!!
						Form::label(
							'amount',
							'Amount:',
							[
								'class' => 'col-sm-2 control-label required',
							]
						)
					!!}
					<div class="col-sm-8">
						{!!
							Form::number(
								'amount',
								old('amount'),
								[
									'class' => 'form-control',
									'placeholder' => 'Amount',
									'min' => 1,
								]
							)
						!!}
						@if($errors->first('amount'))
							<span class="error">{{ $errors->first('amount', ':message') }}</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
						{!! Form::submit('Conduct', ['class' => 'btn btn-default pull-right']) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@stop
