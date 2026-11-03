<header class="header" id="header">
    <div class="header__inner">
        <div class="header__left">
            <button class="button button-icon button-icon--primary" @click="toggleAside">
                <x-admin.icons.application class="icon--primary icon--m" />
            </button>
        </div>
        <div class="header__right">
            <div class="user-menu" id="user-menu">
                <button class="button button-icon button-icon--primary" @click="toggleUserMenu">
                    <x-admin.icons.user class="icon--primary icon--m" />
                </button>
                <div class="user-menu__dropdown">
                    <a class="user-menu__link" href="{{ route('admin.auth.logout.handle') }}">
                        <span class="user-name__label">
                            {{ __('links.logout') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>