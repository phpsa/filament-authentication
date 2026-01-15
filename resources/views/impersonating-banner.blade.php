<style>
    #impersonating-banner {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        background-color: rgb(250 204 21);
        color: rgb(17 24 39);
    }

    #impersonating-banner .banner-content {
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
    }

    #impersonating-banner .banner-link {
        margin-left: 1rem;
        text-decoration-line: underline;
        font-weight: 800;
        color: rgb(17 24 39);
    }

    #impersonating-banner .banner-link:hover {
        text-decoration-line: none;
        color: rgb(55 65 81);
    }

    html.impersonating {
        padding-top: 40px !important;
    }

    @media print {
        html.impersonating {
            padding-top: 0 !important;
        }
        
        #impersonating-banner {
            display: none !important;
        }
    }
</style>

<script>
    document.documentElement.classList.add('impersonating');
</script>

<div id="impersonating-banner">
    <div class="banner-content">
        {{ __('filament-authentication::filament-authentication.text.impersonating') }} 
        <strong>{{ $impersonating }}</strong>
        <a href="{{ route("filament.{$panel}.fa.stop.impersonation") }}" class="banner-link">
            {{ __('filament-authentication::filament-authentication.text.impersonating.end') }}
        </a>
    </div>
</div>
