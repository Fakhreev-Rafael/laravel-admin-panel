<aside class="aside" id="aside">
    <div class="aside__wrapper">
        <div class="aside__inner">
            <ul class="navigation">
                <li class="navigation__element">
                    <a class="navigation__link navigation__link--primary" href="{{ route('admin.permission.index') }}"
                        title="{{ __('links.permissions') }}">
                        <x-admin.icons.lock class="icon--primary icon--m" />
                        <span class="navigation__label">
                            {{ __('links.permissions') }}
                        </span>
                    </a>
                </li>
                <li class="navigation__element">
                    <a class="navigation__link navigation__link--primary" href="{{ route('admin.permission.index') }}"
                        title="{{ __('links.roles') }}">
                        <x-admin.icons.mask class="icon--primary icon--m" />
                        <span class="navigation__label">
                            {{ __('links.roles') }}
                        </span>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</aside>