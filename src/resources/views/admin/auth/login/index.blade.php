@extends('admin.auth.layouts.auth')

@section('title', __('titles.login'))

@section('content')
<section class="main__section grid-container">
    <div class="block grid-container__column--6 grid-container__column--start-10">
        <form class="form-structure form-structure--vertical" method="POST" action="{{ route('admin.auth.login.handle') }}">
            @csrf
            <section class="form-structure__section">
                <span class="heading heading--primary">
                    {{ __('headings.login') }}
                </span>
            </section>
            <section class="form-structure__section">
                <label class="label label--primary label--required" for="email">{{ __('labels.email') }}</label>
                <div class="field field--primary">
                    <input class="field__input" type="text" name="email" autocomplete="off"/>
                </div>
                @error('email')
                <span class="error-message">
                    {{ $message }}
                </span>
                @enderror
            </section>
            <section class="form-structure__section">
                <label class="label label--primary label--required" for="password">{{ __('labels.password') }}</label>
                <div class="field field--primary">
                    <input class="field__input" type="password" name="password" />
                    <button class="button button-icon button-icon--secondary" type="button" @click="passwordTypeToggle">
                        <x-admin.icons.eye class="icon--m icon--primary" />
                    </button>
                </div>
                @error('password')
                <span class="error-message">
                    {{ $message }}
                </span>
                @enderror
            </section>
             <section class="form-structure__section">
                <label class="label label--primary" for="password">
                    <input class="checkbox checkbox--primary" type="checkbox" name="remember"/>
                    {{ __('labels.remember_me') }}
                </label>
            </section>
            <section class="form-structure__section">
                <button class="button button--primary" type="submit">
                    {{ __('buttons.login') }}
                </button>
            </section>
        </form>
    </div>
</section>
@endsection