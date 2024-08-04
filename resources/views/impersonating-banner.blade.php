<style>
html, body>div>aside {
    margin-top: 40px;
}
body>div>aside
@media print {
    html {
        margin-top: 0;
    }
}
</style>

<div
    id="impersonating-banner"
    class="print:hidden bg-primary-500 absolute h-10 top-0 w-full flex items-center content-center justify-center text-white"
    >
    <div>
        {{ __('filament-authentication::filament-authentication.text.impersonating') }} <strong>{{ $impersonating }}</strong>
        <a href="{{ route("filament.{$panel}.fa.stop.impersonation") }}"><strong>{{ __('filament-authentication::filament-authentication.text.impersonating.end') }}</strong></a>
    </div>

</div>
