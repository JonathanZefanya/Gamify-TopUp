<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\Currency;
use App\Models\Language;
use App\Models\ManageMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Mailchimp\Transport\MandrillTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendgrid\Transport\SendgridTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            DB::connection()->getPdo();

            $data['basicControl'] = basicControl();
            View::share($data);

            view()->composer([
                'themes.dark.partials.nav',
                'themes.light.partials.nav',
                'themes.dark.sections.footer',
                'themes.light.sections.footer',
                'themes.light.page',
                'themes.dark.page',
            ], function ($view) {
                $languages = \Cache::get("language");
                if(!$languages || empty($languages)){
                    $languages = Language::where('status',1)->get();
                    \Cache::put('language', $languages);
                }

                $currencies = \Cache::get("currency");
                if(!$currencies || empty($currencies)){
                    $currencies = Currency::where('status',1)->get();
                    \Cache::put('currency', $currencies);
                }

                $lang = new \App\Http\Middleware\Language();
                $code = $lang->getCode();
                $defaultLanguage = $languages->where('short_name', $code)->first();

                $contentDetails = \Cache::get("manage_content");
                if(!$contentDetails || empty($languages)){
                    $contentDetails = ContentDetails::with('content')
                        ->whereIn('content_id', Content::whereIn('name', ['cookie', 'footer'])->pluck('id'))
                        ->get()
                        ->groupBy(function ($item) {
                            return $item->content->name;
                        });
                    \Cache::put('manage_content', $contentDetails);
                }

                $footerData = $this->prepareContentData($contentDetails->get('footer'), $defaultLanguage, 'footer', $languages);

                $view->with([
                    'footer' => $footerData,
                    'languages' => $languages,
                    'currencies' => $currencies,
                ]);
            });

            if (basicControl()->force_ssl == 1) {
                if ($this->app->environment('production') || $this->app->environment('local')) {
                    \URL::forceScheme('https');
                }
            }

            $this->registerMailTransport('sendinblue', new SendinblueTransportFactory);
            $this->registerMailTransport('sendgrid', new SendgridTransportFactory);
            $this->registerMailTransport('mandrill', new MandrillTransportFactory);

        } catch (\Exception $e) {
        }

    }

    private function registerMailTransport(string $name, $factory)
    {
        Mail::extend($name, fn() => $factory->create(
            new Dsn("{$name}+api", 'default', config("services.{$name}.key"))
        ));
    }
    private function prepareContentData($contents ,$default ,$contentType ,$language = null )
    {
        if (is_null($contents)) {
            return [
                'single' => [],
                'multiple' => collect(),
                'languages' => $language,
                'defaultLanguage' => $default,
            ];
        }

        $singleContent = $contents->where('content.name', $contentType)
            ->where('content.type', 'single')
            ->first() ?? [];

        $multipleContents = $contents->where('content.name', $contentType)
            ->where('content.type', 'multiple')
            ->values()
            ->map(fn($content) => collect($content->description)->merge($content->content->only('media')));

        return [
            'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
            'multiple' => $multipleContents,
            'languages' => $language,
            'defaultLanguage' => $default,
        ];
    }
}
