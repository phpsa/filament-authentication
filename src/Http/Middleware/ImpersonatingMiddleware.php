<?php

namespace Phpsa\FilamentAuthentication\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Filament\Facades\Filament;
use Illuminate\Http\JsonResponse;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonatingMiddleware
{

    /**
     *
     * @var view-string view to render
     * @phpstan-ignore property.defaultValue
     */
    protected string $view = 'filament-authentication::impersonating-banner';

    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);

        // Only touch illuminate responses (avoid binary, etc)
        if (! $response instanceof Response || ! app(ImpersonateManager::class)->isImpersonating()) {
            return $response;
        }

        return $request->wantsJson()
        ? $this->setJsonContent($response) :
        $response->setContent(
            str_replace(
                '</body>',
                $this->getHtmlContent($request) . '</body>',
                $response->getContent()
            )
        );
    }

    protected function getHtmlContent($request): string
    {
        $panel = Filament::getCurrentPanel()->getId();
        return view($this->view, [
            'panel'         => $panel,
            'impersonating' => Filament::getUserName(auth()->user())
        ])->render();
    }

    protected function setJsonContent(JsonResponse|Response $response): JsonResponse|Response
    {
        $data = $this->getResponseData($response);
        if ($data === false || ! is_object($data)) {
            return $response;
        }

        $data->impersonating = true;

        return $this->setResponseData($response, $data);
    }

    protected function getResponseData(JsonResponse|Response $response)
    {
        if ($response instanceof JsonResponse) {
            return $response->getData() ?: new \StdClass();
        }

        $content = $response->getContent();

        return json_decode($content) ?: false;
    }

    protected function setResponseData(JsonResponse|Response $response, $data): JsonResponse|Response
    {
        if ($response instanceof JsonResponse) {
            return $response->setData($data);
        }

        $content = json_encode($data, JsonResponse::DEFAULT_ENCODING_OPTIONS);

        return $response->setContent($content);
    }
}
