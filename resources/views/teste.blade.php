@extends('layouts.layout')
@section('content')

<div class="card-header">
							<h5 class="mb-0">Custom styles</h5>
						</div>
<form class="needs-validation" novalidate>
	<div class="card-body">
		<p class="mb-4">For custom Bootstrap form validation messages, you’ll need to add the <code>novalidate</code> boolean attribute to your <code>&lt;form></code>. This disables the browser default feedback tooltips, but still provides access to the form validation APIs in JavaScript. When attempting to submit, you’ll see the <code>:invalid</code> and <code>:valid</code> styles applied to your form controls. Custom feedback styles apply custom colors, borders, focus styles, and background icons to better communicate feedback. Background icons for <code>&lt;select></code> are only available with <code>.form-select</code>, and not <code>.form-control</code>.</p>

		<div class="fw-bold border-bottom pb-2 mb-3">Examples</div>

			<div class="row mb-3">
	    		<label class="col-form-label col-lg-3">Text input <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="text" class="form-control" required placeholder="Input placeholder">
					<div class="invalid-feedback">Invalid feedback</div>
					<div class="valid-feedback">Valid feedback</div>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Password input <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="text" class="form-control" required placeholder="Input placeholder">
					<div class="invalid-feedback">Invalid feedback</div>
					<div class="valid-feedback">Valid feedback</div>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Input with icon <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<div class="form-control-feedback form-control-feedback-start">
		    			<input type="text" class="form-control" required placeholder="Input placeholder">
						<div class="form-control-feedback-icon">
							<i class="ph-at"></i>
						</div>
						<div class="invalid-feedback">Invalid feedback</div>
						<div class="valid-feedback">Valid feedback</div>
					</div>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">Select <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<select class="form-select" required="">
	    				<option selected disabled value="">Please select</option>
						<option value="1">Option 1</option>
						<option value="2">Option 2</option>
						<option value="3">Option 3</option>
						<option value="4">Option 4</option>
					</select>
					<div class="invalid-feedback">Invalid feedback</div>
					<div class="valid-feedback">Valid feedback</div>
				</div>
			</div>

			<div class="row mb-3">
				<label class="col-form-label col-lg-3">File input <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<input type="file" class="form-control" required>
					<div class="invalid-feedback">Invalid feedback</div>
					<div class="valid-feedback">Valid feedback</div>
				</div>
			</div>

			<div class="row mb-3">
	    		<label class="col-form-label col-lg-3">Input group <span class="text-danger">*</span></label>
				<div class="col-lg-9">
					<div class="input-group has-validation">
						<span class="input-group-text">@</span>
						<input type="text" class="form-control" required placeholder="Input placeholder">
						<div class="invalid-feedback">Invalid feedback</div>
						<div class="valid-feedback">Valid feedback</div>
					</div>
				</div>
			</div>

								<div class="row mb-3">
									<label class="col-form-label col-lg-3">Textarea <span class="text-danger">*</span></label>
									<div class="col-lg-9">
										<textarea class="form-control" required placeholder="Textarea placeholder"></textarea>
										<div class="invalid-feedback">Invalid feedback</div>
										<div class="valid-feedback">Valid feedback</div>
									</div>
								</div>

								<div class="row mb-3">
									<label class="col-form-label col-lg-3">Switch <span class="text-danger">*</span></label>
									<div class="col-lg-9">
										<div class="form-check-horizontal">
											<label class="form-check form-switch mb-0">
												<input type="checkbox" class="form-check-input" required>
												<span class="form-check-label">Check this switch</span>
												<div class="invalid-feedback">Invalid feedback</div>
												<div class="valid-feedback">Valid feedback</div>
											</label>
										</div>
									</div>
								</div>

								<div class="row mb-3">
									<label class="col-form-label col-lg-3">Single checkbox <span class="text-danger">*</span></label>
									<div class="col-lg-9">
										<div class="form-check-horizontal">
											<label class="form-check mb-0">
												<input type="checkbox" class="form-check-input" required>
												<span class="form-check-label">Check this checkbox</span>
												<div class="invalid-feedback">Invalid feedback</div>
												<div class="valid-feedback">Valid feedback</div>
											</label>
										</div>
									</div>
								</div>

								<div class="row mb-3">
									<label class="col-form-label col-lg-3">Checkbox group <span class="text-danger">*</span></label>
									<div class="col-lg-9">
										<div class="form-check-horizontal">
											<label class="form-check mb-2">
												<input type="checkbox" class="form-check-input" required>
												<span class="form-check-label">Checkbox 1</span>
												<div class="invalid-feedback">Invalid feedback</div>
												<div class="valid-feedback">Valid feedback</div>
											</label>

											<label class="form-check mb-2">
												<input type="checkbox" class="form-check-input" required>
												<span class="form-check-label">Checkbox 2</span>
												<div class="invalid-feedback">Invalid feedback</div>
												<div class="valid-feedback">Valid feedback</div>
											</label>

											<label class="form-check mb-0">
												<input type="checkbox" class="form-check-input" required>
												<span class="form-check-label">Checkbox 3</span>
												<div class="invalid-feedback">Invalid feedback</div>
												<div class="valid-feedback">Valid feedback</div>
											</label>
										</div>
									</div>
								</div>

								<div class="row">
									<label class="col-form-label col-lg-3">Radio <span class="text-danger">*</span></label>
									<div class="col-lg-9">
										<div class="form-check-horizontal">
											<label class="form-check mb-2">
												<input type="radio" class="form-check-input" name="radio-stacked" required>
												<span class="form-check-label">Toggle this radio</span>
											</label>

											<label class="form-check mb-0">
												<input type="radio" class="form-check-input" name="radio-stacked" required>
												<span class="form-check-label" for="validationFormCheck3">Or toggle this other radio</span>
												<div class="invalid-feedback">Invalid feedback</div>
												<div class="valid-feedback">Valid feedback</div>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="card-footer text-end">
								<button type="submit" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
							</div>
						</form>


<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>


@stop
