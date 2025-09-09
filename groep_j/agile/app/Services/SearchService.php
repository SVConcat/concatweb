<?php

namespace App\Services;

use App\Enums\EventCategoryEnum;

class SearchService
{
    protected $models = [
        \App\Models\Event::class,
        \App\Models\Sponsor::class,
        \App\Models\Announcement::class,
    ];

    protected $translatedEventCategory = [
        'evenement' => 'EVENT',
        'borrel' => 'DRINKS',
        'community avond' => 'COMMUNITY',
    ];

    protected $translatedActiveType = [
        'actief' => 'ACTIVE',
        'afgelopen' => 'ARCHIVED',
    ];

    public function multiSearch($query, $request)
    {
        $searchTerm = strtolower($request);
        $models = $this->models;
        $query->where(function ($query) use ($searchTerm, $models) {
            foreach ($models as $model) {
                foreach ($model->getSearchable() as $field) {
                    $query->orWhereRaw('LOWER('.$field.') like ?', ['%'.$searchTerm.'%']);
                }
            }
        });
    }

    public function singleSearch($query, $request, $model){
        $searchTerm = strtolower($request);
        $query->where(function ($query) use ($searchTerm, $model) {
            foreach ((new $model)->getSearchable() as $field) {
                $query->orWhereRaw('LOWER('.$field.') like ?', ['%'.$searchTerm.'%']);
            }
        });
    }

    public function search($query, mixed $search, string $class)
    {
        if (preg_match('/\b\d{2}-\d{2}-\d{4}\b/', $search, $fullDate) > 0) {
            $this->singleSearch($query, date('Y-m-d', strtotime($fullDate[0])), $class);
        }
        else if(preg_match('/\b\d{2}-\d{4}\b/', $search, $monthYear) > 0) {
            $formattedDate = '01-' . $monthYear[0];
            $this->singleSearch($query, date('Y-m', strtotime($formattedDate)), $class);
        }
        else if(preg_match('/\b\d{2}-\d{2}\b/', $search, $monthDay) > 0) {
            $formattedDate = $monthDay[0] . '-' . date('Y');
            $this->singleSearch($query, date('m-d', strtotime($formattedDate)), $class);
        }
        else if (array_key_exists(strtolower($search), $this->translatedEventCategory)) {
            $this->singleSearch($query, $this->translatedEventCategory[strtolower($search)], $class);
        }
        else if (array_key_exists(strtolower($search), $this->translatedActiveType)) {
            $this->singleSearch($query, $this->translatedActiveType[strtolower($search)], $class);
        }
        else {
            $this->singleSearch($query, $search, $class);
        }
    }
}
