@extends('admin.layouts.primary')

@section('title', __('titles.permissions'))

@section('content')
<section class="main__section grid-container">
    <div class="grid-container__column--24">
        <span class="heading heading--secondary">
            {{ __('headings.permissions') }}
        </span>
    </div>
</section>
<section class="main__section grid-container">
    <div class="grid-container__column--24">
        <ul class="toolbar">
            <li class="toolbar__element">
                <label class="label label--primary">{{ __('labels.sort_by') }}:</label>
                <select-component
                    class="select--primary"
                    id="sort"
                    :options="{{ \Illuminate\Support\Js::from($viewModel->sortOptions()) }}"
                    data-callback="sortHandler"
                    name="sort" />
            </li>
            <li class="toolbar__element">
                <button class="button button-icon button-icon--primary" id="toggle-filters" @click="toggleFilters">
                    <x-admin.icons.filter class="icon--primary icon--m" />
                </button>
            </li>
        </ul>
    </div>
</section>
<section class="main__section grid-container">
    <div class="grid-container__column--24">
        <div class="table table--primary">

            <div class="table__row">
                <div class="table__heading">
                    {{ __('headings.id') }}
                </div>
                <div class="table__heading">
                    {{ __('headings.name') }}
                </div>
                <div class="table__heading">
                    {{ __('headings.entity') }}
                </div>
                <div class="table__heading">
                    {{ __('headings.created_at') }}
                </div>
                <div class="table__heading">
                    {{ __('headings.updated_at') }}
                </div>


            </div>

            @foreach($viewModel->permissions() as $permission)
            <div class="table__row">
                <div class="table__data">
                    {{ $permission->id }}
                </div>
                <div class="table__data">
                    {{ __('permissions.' . $permission->slug) }}
                </div>
                <div class="table__data">
                    {{ __('entities.' . $permission->entity) }}
                </div>
                <div class="table__data">
                    {{ $permission->created_at }}
                </div>
                <div class="table__data">
                    {{ $permission->updated_at }}
                </div>
      

            </div>
            @endforeach

        </div>
    </div>
</section>
<section class="main__section grid-container">
    <div class="grid-container__column--24">
        {{ $viewModel->permissions()->links() }}
    </div>
</section>

<div class="filters" id="filters">
    <div class="filters__wrapper">
        <div class="filters__inner">
            <label for="" class="label label--primary">{{ __('labels.filter_by') }}:</label>
            <ul class="filters__list">
                <label for="" class="label label--primary">{{ __('labels.group') }}:</label>
                <li class="filters__element">

                </li>
            </ul>
            <button class="button button--primary">
                {{ __('buttons.apply') }}
            </button>
        </div>
    </div>
</div>
@endsection