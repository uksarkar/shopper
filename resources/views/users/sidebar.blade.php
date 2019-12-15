<div class="mt-16 bg-white md:border-b">
    <div class="container mx-auto px-4">
        <div class="flex">
        <div class="flex -mb-px mr-8">
            <a href="{{ route('home.account.index') }}" class="no-underline flex items-center py-4 border-b @if(Route::is('home.account.index')) border-blue-600 text-blue-600 @else text-grey-500 border-transparent hover:border-grey-500 @endif">
            <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M3.889 3h6.222a.9.9 0 0 1 .889.91v8.18a.9.9 0 0 1-.889.91H3.89A.9.9 0 0 1 3 12.09V3.91A.9.9 0 0 1 3.889 3zM3.889 15h6.222c.491 0 .889.384.889.857v4.286c0 .473-.398.857-.889.857H3.89C3.398 21 3 20.616 3 20.143v-4.286c0-.473.398-.857.889-.857zM13.889 11h6.222a.9.9 0 0 1 .889.91v8.18a.9.9 0 0 1-.889.91H13.89a.9.9 0 0 1-.889-.91v-8.18a.9.9 0 0 1 .889-.91zM13.889 3h6.222c.491 0 .889.384.889.857v4.286c0 .473-.398.857-.889.857H13.89C13.398 9 13 8.616 13 8.143V3.857c0-.473.398-.857.889-.857z"/></svg>
             <span class="hidden sm:inline">
                Dashboard
             </span>
            </a>
        </div>
        <div class="flex -mb-px mr-8">
            <a href="{{ route('home.account.shops') }}" class="no-underline flex items-center py-4 border-b @if(Route::is('home.account.shops')) border-blue-600 text-blue-600 @else text-grey-500 border-transparent hover:border-grey-500 @endif">
            <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg>
                <span class="hidden sm:inline">
                        Shops
                </span>
            </a>
        </div>
        <div class="flex -mb-px mr-8">
            <a href="{{ route('home.account.products') }}" class="no-underline flex items-center py-4 border-b @if(Route::is('home.account.products')) border-blue-600 text-blue-600 @else text-grey-500 border-transparent hover:border-grey-500 @endif">
            <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M32 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V160H32v288zm160-212c0-6.6 5.4-12 12-12h104c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H204c-6.6 0-12-5.4-12-12v-8zM480 32H32C14.3 32 0 46.3 0 64v48c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16V64c0-17.7-14.3-32-32-32z"/></svg>
            <span class="hidden sm:inline">
                    Products
            </span>
            </a>
        </div>
        <div class="flex -mb-px mr-8">
            <a href="{{ route('home.memberships.index') }}" class="no-underline flex items-center py-4 border-b @if(Route::is('home.memberships.index')) border-blue-600 text-blue-600 @else text-grey-500 border-transparent hover:border-grey-500 @endif">
            <svg class="h-6 w-6 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M482.2 372.1C476.5 365.2 250 75 242.3 65.5c-13.7-17.2 0-16.8 19.2-16.9 9.7-.1 106.3-.6 116.5-.6 24.1-.1 28.7.6 38.4 12.8 2.1 2.7 205.1 245.8 207.2 248.3 5.5 6.7 15.2 19.1 7.2 23.4-2.4 1.3-114.6 47.7-117.8 48.9-10.1 4-17.5 6.8-30.8-9.3m114.7-5.6s-115 50.4-117.5 51.6c-16 7.3-26.9-3.2-36.7-14.6l-57.1-74c-5.4-.9-60.4-9.6-65.3-9.3-3.1.2-9.6.8-14.4 2.9-4.9 2.1-145.2 52.8-150.2 54.7-5.1 2-11.4 3.6-11.1 7.6.2 2.5 2 2.6 4.6 3.5 2.7.8 300.9 67.6 308 69.1 15.6 3.3 38.5 10.5 53.6 1.7 2.1-1.2 123.8-76.4 125.8-77.8 5.4-4 4.3-6.8-1.7-8.2-2.3-.3-24.6-4.7-38-7.2m-326-181.3s-12 1.6-25 15.1c-9 9.3-242.1 239.1-243.4 240.9-7 10 1.6 6.8 15.7 1.7.8 0 114.5-36.6 114.5-36.6.5-.6-.1-.1.6-.6-.4-5.1-.8-26.2-1-27.7-.6-5.2 2.2-6.9 7-8.9l92.6-33.8c.6-.8 88.5-81.7 90.2-83.3v-1l-51.2-65.8"/></svg>
            <span class="hidden sm:inline">
                    Memberships
            </span>
            </a>
        </div>
        </div>
    </div>
</div>