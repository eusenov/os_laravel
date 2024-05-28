
<x-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <div class="reg-container wrapper">
            <div class="reg-container__content">
                <form class="regForm" method="post" action="{{ url('/admin2') }}">
                    @csrf
                    <input name="adminLogin" placeholder="login" type="text">
                    <input name="adminPass" placeholder="pass" type="text">
                    <input type="submit" value="Вход">
                </form>
            </div>
        </div>
    </x-slot>
</x-layout>


