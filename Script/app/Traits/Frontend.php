<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\Campaign;
use App\Models\Card;
use App\Models\CardService;
use App\Models\ContentDetails;
use App\Models\SellPostCategory;
use App\Models\TopUp;
use App\Models\TopUpService;

trait Frontend
{
    protected function getSectionsData($sections, $content, $selectedTheme)
    {
        if ($sections == null) {
            $data = ['support' => $content,];
            return view("themes.$selectedTheme.support", $data)->toHtml();
        }

        $contentData = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($sections) {
                $query->whereIn('name', $sections);
            })
            ->get();

        foreach ($sections as $section) {

            $singleContent = $contentData->where('content.name', $section)->where('content.type', 'single')->first() ?? [];
            $multipleContents = $contentData->where('content.name', $section)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
            });
            $data[$section] = [
                'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                'multiple' => $multipleContents
            ];

            $data[$selectedTheme . '_hero'] = $this->getHero($section, $singleContent, $multipleContents, $selectedTheme);
            $data[$selectedTheme . '_exclusive_card'] = $this->getExclusiveCard($section, $singleContent, $multipleContents, $selectedTheme);
            $data[$selectedTheme . '_campaign'] = $this->getCampaign($section, $selectedTheme, $singleContent);
            $data[$selectedTheme . '_top_up'] = $this->getTrendingTopUpServices($section, $selectedTheme, $singleContent, $multipleContents);
            $data[$selectedTheme . '_blog'] = $this->getBlog($section, $selectedTheme, $singleContent);
            $data[$selectedTheme . '_trending_item'] = $this->getCards($section, $selectedTheme, $singleContent, $multipleContents);
            $data[$selectedTheme . '_buy_game_id'] = $this->getGameCategory($section, $selectedTheme, $singleContent, $multipleContents);
            $replacement = view("themes.{$selectedTheme}.sections.{$section}", $data)->toHtml();

            $content = str_replace('<div class="custom-block" contenteditable="false"><div class="custom-block-content">[[' . $section . ']]</div>', $replacement, $content);
            $content = str_replace('<span class="delete-block">×</span>', '', $content);
            $content = str_replace('<span class="up-block">↑</span>', '', $content);
            $content = str_replace('<span class="down-block">↓</span></div>', '', $content);
            $content = str_replace('<p><br></p>', '', $content);
        }

        return $content;
    }

    public function getCampaign($section, $selectedTheme, $singleContent)
    {
        if ($section == $selectedTheme . '_campaign') {
            $campaign = Campaign::firstOrNew();
            $trendingTopUpServices = TopUpService::has('topUp')->with(['topUp:id,slug,avg_rating,total_review,image'])
                ->where('status', 1)
                ->where('is_offered', 1)->orderBy('sort_by', 'ASC')->get();

            $trendingCardServices = CardService::has('card')->with(['card:id,slug,avg_rating,total_review,image'])
                ->where('status', 1)
                ->where('is_offered', 1)->orderBy('sort_by', 'ASC')->get();

            $trendingFirstItem = null;
            if ($section == 'light_campaign') {
                $trendingFirstItem = $trendingTopUpServices->first();
            }

            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            return [
                'campaign' => $campaign,
                'single' => $single,
                'trendingTopUpServices' => $trendingTopUpServices,
                'trendingCardServices' => $trendingCardServices,
                'trendingFirstItem' => $trendingFirstItem,
            ];
        }
    }

    public function getTrendingTopUpServices($section, $selectedTheme, $singleContent, $multipleContents)
    {
        if ($section == $selectedTheme . '_top_up') {
            $trendingItems = TopUp::where('status', 1)
                ->take(12)->orderBy('sort_by', 'ASC')->get();
            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            $multiple = $multipleContents;

            return [
                'trendingItems' => $trendingItems,
                'single' => $single,
                'multiple' => $multiple,

            ];
        }
    }

    public function getCards($section, $selectedTheme, $singleContent, $multipleContents)
    {
        if ($section == $selectedTheme . '_trending_item') {
            $trendingItems = Card::with(['services'])
                ->where('status', 1)
                ->orderBy('sort_by', 'ASC')
                ->take(10)
                ->get();

            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            $multiple = $multipleContents;

            return [
                'trendingItems' => $trendingItems,
                'single' => $single,
                'multiple' => $multiple
            ];
        }
    }

    public function getBlog($section, $selectedTheme, $singleContent)
    {
        if ($section == $selectedTheme . '_blog') {
            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            $multiple = Blog::with(['details', 'category'])->take(3)->latest()->get();

            return [
                'single' => $single,
                'multiple' => $multiple
            ];
        }
    }

    public function getHero($section, $singleContent, $multipleContents, $selectedTheme)
    {
        if ($section == $selectedTheme . '_hero') {
            $trendingItems = CardService::has('card')
                ->with(['card:id,name,slug,avg_rating,total_review,trending'])
                ->whereHas('card', function ($query) {
                    $query->where('trending', 1);
                })
                ->take(10)
                ->where('status', 1)
                ->orderBy('sort_by', 'ASC')
                ->get();
            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            $multiple = $multipleContents;

            return [
                'trendingItems' => $trendingItems,
                'single' => $single,
                'multiple' => $multiple
            ];
        }
    }

    public function getExclusiveCard($section, $singleContent, $multipleContents, $selectedTheme)
    {
        if ($section == $selectedTheme . '_exclusive_card') {
            $cards = Card::with(['services'])
                ->where('status', 1)
                ->where('trending', 1)
                ->orderBy('sort_by', 'ASC')
                ->take(6)
                ->get();
            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            $multiple = $multipleContents;

            return [
                'cards' => $cards,
                'single' => $single,
                'multiple' => $multiple
            ];
        }
    }

    public function getGameCategory($section, $selectedTheme, $singleContent, $multipleContents)
    {
        if ($section == $selectedTheme . '_buy_game_id') {
            $gameCategory = SellPostCategory::with(['activePost', 'details'])->whereStatus(1)
                ->limit(6)->orderBy('id', 'desc')->get();

            $single = $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [];
            $multiple = $multipleContents;

            return [
                'single' => $single,
                'multiple' => $multiple,
                'gameCategory' => $gameCategory,
            ];
        }
    }
}
